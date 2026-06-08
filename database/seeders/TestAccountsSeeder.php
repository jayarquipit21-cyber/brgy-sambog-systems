<?php

namespace Database\Seeders;

use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating 5 test households and resident accounts...');

        $firstNames = ['Juan', 'Pedro', 'Maria', 'Jose', 'Ana'];
        $lastNames = ['Dela Cruz', 'Santos', 'Reyes', 'Gonzales', 'Bautista'];
        $memberFirstNames = [
            ['Crisostomo', 'Basilio'],
            ['Julio', 'Ligaya'],
            ['Clara', 'Felipe'],
            ['Sisa', 'Crispin'],
            ['Simoun', 'Isagani'],
        ];

        for ($i = 0; $i < 5; $i++) {
            $num = $i + 1;

            // 1. Create Household
            $household = Household::create([
                'household_no' => "TEST-HH-0{$num}",
                'purok_no' => (string) ($num % 8 ?: 1),
                'address' => 'Purok '.($num % 8 ?: 1).', Barangay Sambog, Corella, Bohol',
            ]);

            // 2. Create Household Head User account
            $headEmail = "head0{$num}@test.com";
            $headUser = User::create([
                'name' => "{$firstNames[$i]} {$lastNames[$i]}",
                'email' => $headEmail,
                'password' => Hash::make('password'),
                'role' => 'household_head',
            ]);

            // 3. Create Household Head Resident profile
            $birthdate = Carbon::now()->subYears(35 + $i)->subMonths($i)->format('Y-m-d');
            $age = Carbon::parse($birthdate)->age;

            Resident::create([
                'household_id' => $household->id,
                'user_id' => $headUser->id,
                'first_name' => $firstNames[$i],
                'last_name' => $lastNames[$i],
                'relationship_to_head' => 'Household Head',
                'birthdate' => $birthdate,
                'age' => $age,
                'sex' => $i % 2 === 0 ? 'Male' : 'Female',
                'civil_status' => 'Married',
                'citizenship' => 'Filipino',
                'mobile_number' => "0917123456{$num}",
                'email_address' => $headEmail,
                'registered_national_voter' => 'Y',
                'resident_voter' => 'Y',
                'fully_vaccinated' => 'Y',
                'has_philhealth' => 'Y',
                'educational_status' => 'Enrolled',
                'work_status' => 'Employed',
                'occupation' => 'Professional',
                'income' => '35000',
            ]);

            $this->command->info("Created Household Head: {$headEmail} / password");

            // 4. Create 2 Household Members for each household (one gets a user account)
            foreach ($memberFirstNames[$i] as $index => $mName) {
                $mEmail = null;
                $mUserId = null;
                $role = 'resident';

                // Create a User account for the first member
                if ($index === 0) {
                    $mEmail = "resident0{$num}@test.com";
                    $memberUser = User::create([
                        'name' => "{$mName} {$lastNames[$i]}",
                        'email' => $mEmail,
                        'password' => Hash::make('password'),
                        'role' => $role,
                    ]);
                    $mUserId = $memberUser->id;
                }

                $mBirthdate = Carbon::now()->subYears(8 + ($index * 5))->format('Y-m-d');
                $mAge = Carbon::parse($mBirthdate)->age;

                Resident::create([
                    'household_id' => $household->id,
                    'user_id' => $mUserId,
                    'first_name' => $mName,
                    'last_name' => $lastNames[$i],
                    'relationship_to_head' => $index === 0 ? 'Spouse' : 'Child',
                    'birthdate' => $mBirthdate,
                    'age' => $mAge,
                    'sex' => $index === 0 ? ($i % 2 === 0 ? 'Female' : 'Male') : 'Male',
                    'civil_status' => $index === 0 ? 'Married' : 'Single',
                    'citizenship' => 'Filipino',
                    'email_address' => $mEmail,
                    'registered_national_voter' => $mAge >= 18 ? 'Y' : 'N',
                    'resident_voter' => $mAge >= 18 ? 'Y' : 'N',
                    'fully_vaccinated' => 'Y',
                    'has_philhealth' => 'N',
                    'educational_status' => 'Enrolled',
                    'work_status' => $mAge >= 18 ? 'Employed' : 'Student',
                ]);

                if ($mEmail) {
                    $this->command->info("  - Created Member Resident Account: {$mEmail} / password");
                }
            }
        }

        $this->command->info('Seeding of 5 test households and resident accounts completed successfully!');
    }
}
