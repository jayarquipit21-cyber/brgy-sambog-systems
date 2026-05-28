<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Household;
use App\Models\Resident;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate to ensure clean run
        DB::statement('PRAGMA foreign_keys = OFF;');
        Resident::truncate();
        Household::truncate();
        User::truncate();
        DB::statement('PRAGMA foreign_keys = ON;');

        $this->command->info('Creating system administrative users...');

        // 1. Create Core System Admins
        $admin = User::create([
            'name' => 'Barangay Administrator',
            'email' => 'admin@barangay.gov',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $healthAdmin = User::create([
            'name' => 'Barangay Health Officer',
            'email' => 'health@barangay.gov',
            'password' => Hash::make('password'),
            'role' => 'health_admin',
        ]);

        $this->command->info('System admins created:');
        $this->command->info('  - Admin: admin@barangay.gov / password');
        $this->command->info('  - Health: health@barangay.gov / password');

        // 2. Read RBI JSON file
        $jsonPath = database_path('seeders/rbi_data.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("rbi_data.json not found! Run the node converter first.");
            return;
        }

        $this->command->info('Loading RBI data from JSON...');
        $data = json_decode(file_get_contents($jsonPath), true);

        if (!$data || !isset($data['households']) || !isset($data['residents'])) {
            $this->command->error("Invalid JSON data structure in rbi_data.json");
            return;
        }

        $this->command->info('Seeding households (' . count($data['households']) . ')...');
        
        // Map of old JSON household ID to newly created Household Model ID
        $householdIdMap = [];
        
        foreach ($data['households'] as $hh) {
            $household = Household::create([
                'household_no' => $hh['household_no'],
                'purok_no' => $hh['purok_no'],
                'address' => $hh['address'],
            ]);
            $householdIdMap[$hh['id']] = $household->id;
        }

        $this->command->info('Seeding residents (' . count($data['residents']) . ')...');
        
        $residentCount = 0;
        $userCount = 0;
        
        $demoHeadLinked = false;
        $demoResidentLinked = false;

        foreach ($data['residents'] as $res) {
            // Find correct database household ID
            $dbHouseholdId = isset($householdIdMap[$res['household_id']]) ? $householdIdMap[$res['household_id']] : null;
            
            // Prepare resident fields
            $residentData = $res;
            $residentData['household_id'] = $dbHouseholdId;
            
            // Create resident profile
            $resident = Resident::create($residentData);
            $residentCount++;
            
            // Create User Account if applicable
            $email = isset($res['email_address']) ? trim(strtolower($res['email_address'])) : '';
            $isHead = in_array(strtolower($res['relationship_to_head'] ?? ''), ['hh', 'household head']);
            $fullName = $resident->first_name . ' ' . $resident->last_name;
            
            // First we link the core demo accounts:
            // - first Household Head we encounter becomes head@barangay.gov
            if ($isHead && !$demoHeadLinked) {
                $headUser = User::create([
                    'name' => $fullName,
                    'email' => 'head@barangay.gov',
                    'password' => Hash::make('password'),
                    'role' => 'household_head',
                ]);
                $resident->update(['user_id' => $headUser->id]);
                $demoHeadLinked = true;
                $userCount++;
            }
            // - first regular resident (not head) becomes resident@barangay.gov
            elseif (!$isHead && !$demoResidentLinked) {
                $resUser = User::create([
                    'name' => $fullName,
                    'email' => 'resident@barangay.gov',
                    'password' => Hash::make('password'),
                    'role' => 'resident',
                ]);
                $resident->update(['user_id' => $resUser->id]);
                $demoResidentLinked = true;
                $userCount++;
            }
            // Otherwise, if they have an email address in the Excel data, create a real user account for them!
            elseif (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Ensure email is unique
                if (!User::where('email', $email)->exists()) {
                    $role = $isHead ? 'household_head' : 'resident';
                    $user = User::create([
                        'name' => $fullName,
                        'email' => $email,
                        'password' => Hash::make('password'),
                        'role' => $role,
                    ]);
                    $resident->update(['user_id' => $user->id]);
                    $userCount++;
                }
            }
        }

        $this->command->info("Seeding completed successfully!");
        $this->command->info("  - Households seeded: {$residentCount}");
        $this->command->info("  - Residents seeded: {$residentCount}");
        $this->command->info("  - User accounts created: {$userCount}");
        $this->command->info("Demo accounts linked:");
        $this->command->info("  - Household Head: head@barangay.gov / password");
        $this->command->info("  - Resident Member: resident@barangay.gov / password");
    }
}
