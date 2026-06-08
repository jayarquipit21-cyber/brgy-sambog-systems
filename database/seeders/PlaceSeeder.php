<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $places = [
            [
                'name' => 'Barangay Hall',
                'type' => 'government',
                'description' => 'Barangay administrative office and public services counter.',
                'address' => 'Brgy. Sambog, Corella, Bohol',
                'lat' => 9.635000,
                'lng' => 124.160000,
                'is_featured' => true,
                'purok_no' => 1,
            ],
            [
                'name' => 'Barangay Health Center',
                'type' => 'health',
                'description' => 'Primary care and vaccination services for residents.',
                'address' => 'Health Center Rd, Brgy. Sambog',
                'lat' => 9.636000,
                'lng' => 124.161000,
                'is_featured' => true,
                'purok_no' => 2,
            ],
            [
                'name' => 'Sambog Central Market',
                'type' => 'market',
                'description' => 'Local wet market with fresh produce and vendors.',
                'address' => 'Public Market Compound',
                'lat' => 9.634500,
                'lng' => 124.159500,
                'is_featured' => false,
                'purok_no' => 3,
            ],
            [
                'name' => 'Sambog Elementary School',
                'type' => 'school',
                'description' => 'Primary education institution serving local children.',
                'address' => 'Elementary School Rd, Brgy. Sambog',
                'lat' => 9.637000,
                'lng' => 124.159000,
                'is_featured' => false,
                'purok_no' => 4,
            ],
            [
                'name' => 'Corella National High School',
                'type' => 'school',
                'description' => 'Secondary education institution serving Corella municipality.',
                'address' => 'Brgy. Sambog / Corella, Bohol',
                'lat' => 9.640000,
                'lng' => 124.162500,
                'is_featured' => false,
                'purok_no' => null,
            ],
            [
                'name' => 'Sambog General Merchandise',
                'type' => 'store',
                'description' => 'Local sari-sari and general goods store.',
                'address' => 'Main Rd, Brgy. Sambog',
                'lat' => 9.635500,
                'lng' => 124.162000,
                'is_featured' => false,
                'purok_no' => 2,
            ],
            [
                'name' => 'Sambog Bakery & Delicacies',
                'type' => 'bakery',
                'description' => 'Local bakery offering bread and local pastries.',
                'address' => 'Market Lane, Brgy. Sambog',
                'lat' => 9.634800,
                'lng' => 124.159800,
                'is_featured' => false,
                'purok_no' => 3,
            ],
            [
                'name' => 'Sambog Hardware',
                'type' => 'hardware',
                'description' => 'Community hardware and tools supplier.',
                'address' => 'Corner Main Rd & School Rd',
                'lat' => 9.636200,
                'lng' => 124.160800,
                'is_featured' => false,
                'purok_no' => 2,
            ],
            [
                'name' => 'Sambog Veterinary Clinic',
                'type' => 'veterinary_care',
                'description' => 'Small animal clinic for pets and livestock support.',
                'address' => 'Farm Lane, Brgy. Sambog',
                'lat' => 9.632900,
                'lng' => 124.158700,
                'is_featured' => false,
                'purok_no' => 6,
            ],
        ];

        foreach ($places as $p) {
            Place::create($p);
        }
    }
}
