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
                'name' => 'Sambog Barangay Hall',
                'type' => 'government',
                'description' => 'Barangay administrative office and public services counter.',
                'address' => 'MWG3+JH3, Barangay Rd, Sambog, Corella, Bohol',
                'lat' => 9.676627, 
                'lng' => 123.904066,
                'is_featured' => true,
                'purok_no' => 1,
            ],
            [
                'name' => 'Sambog Health Center',
                'type' => 'health',
                'description' => 'Primary care and vaccination services for residents.',
                'address' => 'MWG4+729, Sambog, Corella, Bohol',
                'lat' => 9.675785,
                'lng' => 123.905087,
                'is_featured' => true,
                'purok_no' => 2,
            ],
            [
                'name' => 'Sambog Day Care Center',
                'type' => 'education',
                'description' => 'Day care center providing early childhood education and care.',
                'address' => 'MWG4+72R, Sambog, Corella, Bohol',
                'lat' => 9.675703, 
                'lng' => 123.905203,
                'is_featured' => false,
                'purok_no' => 3,
            ],
            [
                'name' => 'Sambog Elementary School',
                'type' => 'school',
                'description' => 'Primary education institution serving local children.',
                'address' => 'MWG3+24, Sambog, Corella, Bohol',
                'lat' => 9.675106,
                'lng' => 123.902868,
                'is_featured' => false,
                'purok_no' => 4,
            ],
            [
                'name' => 'Holy Hill',
                'type' => 'place_of_worship',
                'description' => 'Sacred site for religious activities.',
                'address' => 'MW92+PJF, Sambog, Corella, Bohol',
                'lat' => 9.669613, 
                'lng' => 123.900983,
                'is_featured' => false,
                'purok_no' => null,
            ],
            [
                'name' => 'Bulcachong Bulalo',
                'type' => 'store',
                'description' => 'Local bulalo stand.',
                'address' => 'Main Rd, Brgy. Sambog',
                'lat' => 9.674767, 
                'lng' => 123.904373,
                'is_featured' => false,
                'purok_no' => 2,
            ],
            [
                'name' => 'Jea\'s Bakeshop',
                'type' => 'bakery',
                'description' => 'Local bakery offering bread and local pastries.',
                'address' => 'MVHW+674, Tagbilaran City-Corella-Sikatuna-Loboc Rd, Sambog, Corella, Bohol',
                'lat' => 9.678146, 
                'lng' => 123.895708,
                'is_featured' => false,
                'purok_no' => 3,
            ],
            [
                'name' => 'JJ Hardware & Construction Supplies',
                'type' => 'hardware',
                'description' => 'Community hardware and tools supplier.',
                'address' => 'MVHV+7W2, Tagbilaran City-Corella-Sikatuna-Loboc Rd, Sambog, Corella, Bohol',
                'lat' => 9.678197, 
                'lng' => 123.895745,
                'is_featured' => false,
                'purok_no' => 2,
            ],
            [
                'name' => 'TTing\'s Pizza',
                'type' => 'pizzeria',
                'description' => 'Local pizzeria serving delicious pizzas.',
                'address' => 'MVHV+5VG, Sambog, Corella, Bohol',
                'lat' => 9.678005,
                'lng' => 123.894712,
                'is_featured' => false,
                'purok_no' => 6,
            ],
        ];

        foreach ($places as $p) {
            Place::create($p);
        }
    }
}
