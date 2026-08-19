<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\ServiceFee;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ServiceFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fees = [
            // Documents
            [
                'category' => 'document',
                'name' => 'Barangay Clearance',
                'code' => 'DOC-BC',
                'default_fee' => 50.00,
                'fee_unit' => 'per document',
                'description' => 'Official clearance for employment, IDs, or legal requirements',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'document',
                'name' => 'Certificate of Indigency',
                'code' => 'DOC-CI',
                'default_fee' => 0.00,
                'fee_unit' => 'per certificate',
                'description' => 'Official certificate for medical, financial, or educational assistance (Free exemption)',
                'is_free_exemption_eligible' => true,
            ],
            [
                'category' => 'document',
                'name' => 'Certificate of Residency',
                'code' => 'DOC-CR',
                'default_fee' => 50.00,
                'fee_unit' => 'per document',
                'description' => 'Proof of residence in Barangay Sambog, Corella, Bohol',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'document',
                'name' => 'Barangay Business Permit Clearance',
                'code' => 'DOC-BP',
                'default_fee' => 200.00,
                'fee_unit' => 'per clearance',
                'description' => 'Clearance for micro or commercial business registration/renewal',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'document',
                'name' => 'Certificate of Good Moral Character',
                'code' => 'DOC-GM',
                'default_fee' => 50.00,
                'fee_unit' => 'per certificate',
                'description' => 'Certification for school, scholarship, or institutional applications',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'document',
                'name' => 'First-Time Job Seeker Certificate (RA 11261)',
                'code' => 'DOC-FTJ',
                'default_fee' => 0.00,
                'fee_unit' => 'per certificate',
                'description' => 'Free document assistance under Republic Act No. 11261',
                'is_free_exemption_eligible' => true,
            ],
            [
                'category' => 'document',
                'name' => 'Barangay Identification Card (ID)',
                'code' => 'DOC-ID',
                'default_fee' => 100.00,
                'fee_unit' => 'per ID card',
                'description' => 'Official Barangay Sambog inhabitant ID card request',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'document',
                'name' => 'Building / Construction Clearance',
                'code' => 'DOC-BLD',
                'default_fee' => 150.00,
                'fee_unit' => 'per clearance',
                'description' => 'Clearance for house, fencing, or commercial construction',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'document',
                'name' => 'Tricycle / Transport Permit Clearance',
                'code' => 'DOC-TP',
                'default_fee' => 100.00,
                'fee_unit' => 'per permit',
                'description' => 'Clearance for local public utility transport operation',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'document',
                'name' => 'Other / Custom Barangay Document',
                'code' => 'DOC-OTH',
                'default_fee' => 50.00,
                'fee_unit' => 'per request',
                'description' => 'Custom barangay document or special certificate',
                'is_free_exemption_eligible' => false,
            ],

            // Rentals
            [
                'category' => 'rental',
                'name' => 'Plastic Monoblock Chairs Rental',
                'code' => 'RNT-CHR',
                'default_fee' => 5.00,
                'fee_unit' => 'per chair / day',
                'description' => 'Barangay plastic monoblock chairs for events, gatherings, & occasions',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'rental',
                'name' => 'Heavy-Duty Event Tents / Canopy Rental',
                'code' => 'RNT-TNT',
                'default_fee' => 500.00,
                'fee_unit' => 'per tent / day',
                'description' => 'Barangay heavy-duty shelter tents for outdoor occasions',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'rental',
                'name' => 'Barangay Basketball Court / Multipurpose Gym Reservation',
                'code' => 'RNT-CRT',
                'default_fee' => 200.00,
                'fee_unit' => 'per hour',
                'description' => 'Reservation of covered basketball court for sports, leagues, or events',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'rental',
                'name' => 'Portable Sound System & Microphone Rental',
                'code' => 'RNT-SND',
                'default_fee' => 500.00,
                'fee_unit' => 'per day',
                'description' => 'PA system with active speakers and wireless microphones for community events',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'rental',
                'name' => 'Banquet Tables & Long Benches Rental',
                'code' => 'RNT-TBL',
                'default_fee' => 50.00,
                'fee_unit' => 'per table set / day',
                'description' => 'Barangay folding banquet tables and wooden/plastic benches',
                'is_free_exemption_eligible' => false,
            ],
            [
                'category' => 'rental',
                'name' => 'Other Facility / Equipment Rental',
                'code' => 'RNT-OTH',
                'default_fee' => 100.00,
                'fee_unit' => 'per reservation',
                'description' => 'Custom barangay facility or equipment rental request',
                'is_free_exemption_eligible' => false,
            ],
        ];

        foreach ($fees as $feeData) {
            ServiceFee::updateOrCreate(
                ['name' => $feeData['name']],
                $feeData
            );
        }

        // Seed realistic sample transactions for the sales report if none exist
        if (Transaction::count() === 0) {
            $admin = User::where('role', 'admin')->first();
            $adminId = $admin ? $admin->id : null;
            $residents = User::whereIn('role', ['resident', 'household_head'])->get();

            $sampleData = [
                ['payer' => 'Juan Dela Cruz', 'item' => 'Barangay Clearance', 'cat' => 'document', 'fee' => 50.00, 'qty' => 1, 'method' => 'cash', 'status' => 'paid', 'days_ago' => 0],
                ['payer' => 'Maria Santos', 'item' => 'Barangay Business Permit Clearance', 'cat' => 'document', 'fee' => 200.00, 'qty' => 1, 'method' => 'gcash', 'status' => 'paid', 'days_ago' => 1],
                ['payer' => 'Pedro Penduko', 'item' => 'Barangay Basketball Court / Multipurpose Gym Reservation', 'cat' => 'rental', 'fee' => 200.00, 'qty' => 3, 'method' => 'cash', 'status' => 'paid', 'days_ago' => 2],
                ['payer' => 'Ana Reyes', 'item' => 'Plastic Monoblock Chairs Rental', 'cat' => 'rental', 'fee' => 5.00, 'qty' => 50, 'method' => 'cash', 'status' => 'paid', 'days_ago' => 3],
                ['payer' => 'Carlos Garcia', 'item' => 'Heavy-Duty Event Tents / Canopy Rental', 'cat' => 'rental', 'fee' => 500.00, 'qty' => 2, 'method' => 'gcash', 'status' => 'paid', 'days_ago' => 4],
                ['payer' => 'Elena Bautista', 'item' => 'Certificate of Residency', 'cat' => 'document', 'fee' => 50.00, 'qty' => 2, 'method' => 'cash', 'status' => 'paid', 'days_ago' => 5],
                ['payer' => 'Roberto Lim', 'item' => 'Portable Sound System & Microphone Rental', 'cat' => 'rental', 'fee' => 500.00, 'qty' => 1, 'method' => 'cash', 'status' => 'paid', 'days_ago' => 6],
                ['payer' => 'Lourdes Tan', 'item' => 'Building / Construction Clearance', 'cat' => 'document', 'fee' => 150.00, 'qty' => 1, 'method' => 'cash', 'status' => 'paid', 'days_ago' => 7],
                ['payer' => 'Ferdinand Marcos', 'item' => 'Certificate of Indigency', 'cat' => 'document', 'fee' => 0.00, 'qty' => 1, 'method' => 'free_exemption', 'status' => 'waived', 'days_ago' => 8],
                ['payer' => 'Gloria Macapagal', 'item' => 'Barangay Identification Card (ID)', 'cat' => 'document', 'fee' => 100.00, 'qty' => 1, 'method' => 'maya', 'status' => 'paid', 'days_ago' => 10],
                ['payer' => 'Corazon Aquino', 'item' => 'Barangay Clearance', 'cat' => 'document', 'fee' => 50.00, 'qty' => 1, 'method' => 'cash', 'status' => 'paid', 'days_ago' => 12],
                ['payer' => 'Rodrigo Duterte', 'item' => 'Barangay Basketball Court / Multipurpose Gym Reservation', 'cat' => 'rental', 'fee' => 200.00, 'qty' => 4, 'method' => 'cash', 'status' => 'paid', 'days_ago' => 14],
            ];

            foreach ($sampleData as $index => $sample) {
                $total = $sample['fee'] * $sample['qty'];
                $paidDate = Carbon::now()->subDays($sample['days_ago'])->subHours(rand(1, 8));
                $residentUser = $residents->count() > 0 ? $residents[$index % $residents->count()] : null;

                Transaction::create([
                    'transaction_code' => sprintf('TXN-%s-%04d', $paidDate->format('Ymd'), $index + 1),
                    'user_id' => $residentUser ? $residentUser->id : null,
                    'payer_name' => $residentUser ? $residentUser->name : $sample['payer'],
                    'payer_address' => 'Purok '.rand(1, 7).', Barangay Sambog, Corella, Bohol',
                    'service_type' => $sample['cat'],
                    'item_name' => $sample['item'],
                    'quantity' => $sample['qty'],
                    'unit_price' => $sample['fee'],
                    'total_amount' => $total,
                    'amount_paid' => $sample['status'] === 'paid' ? $total : 0.00,
                    'payment_status' => $sample['status'],
                    'payment_method' => $sample['method'],
                    'official_receipt_number' => $sample['status'] === 'paid' ? sprintf('OR-2026-%04d', 100 + $index) : null,
                    'processed_by' => $adminId,
                    'notes' => 'Official transaction collection for '.$sample['item'],
                    'paid_at' => $paidDate,
                    'created_at' => $paidDate,
                    'updated_at' => $paidDate,
                ]);
            }
        }
    }
}
