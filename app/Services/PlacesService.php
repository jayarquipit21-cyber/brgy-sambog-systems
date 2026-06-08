<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PlacesService
{
    /**
     * Query Google Places Nearby Search and return simplified results.
     * Requires environment variable `GOOGLE_PLACES_API_KEY` to be set.
     *
     * @param  int  $radius  meters
     */
    public function nearbyPlaces(float $lat, float $lng, int $radius = 1500, int $limit = 6, ?string $type = null): array
    {
        $key = env('GOOGLE_PLACES_API_KEY');

        // If no API key is provided, return a built-in static list of common barangay places
        // so the UI can function without external APIs or billing requirements.
        if (empty($key)) {
            $fallback = [
                [
                    'name' => 'Barangay Hall',
                    'type' => 'government',
                    'description' => 'Barangay administrative office and public services counter.',
                    'address' => 'Brgy. Sambog, Corella, Bohol',
                    'lat' => 9.635100,
                    'lng' => 124.160100,
                    'photo' => null,
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
                    'photo' => null,
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
                    'photo' => null,
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
                    'photo' => null,
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
                    'photo' => null,
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
                    'photo' => null,
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
                    'photo' => null,
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
                    'photo' => null,
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
                    'photo' => null,
                    'is_featured' => false,
                    'purok_no' => 6,
                ],
            ];

            return array_slice($fallback, 0, $limit);
        }

        $params = [
            'location' => $lat.','.$lng,
            'radius' => $radius,
            'key' => $key,
        ];

        if ($type) {
            $params['type'] = $type;
        }

        try {
            $resp = Http::asForm()->get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', $params);
            if ($resp->failed()) {
                return [];
            }

            $json = $resp->json();
            $results = $json['results'] ?? [];

            $places = [];
            foreach ($results as $r) {
                if (count($places) >= $limit) {
                    break;
                }
                $places[] = [
                    'name' => $r['name'] ?? null,
                    'type' => $r['types'][0] ?? null,
                    'description' => $r['vicinity'] ?? ($r['formatted_address'] ?? null),
                    'address' => $r['vicinity'] ?? ($r['formatted_address'] ?? null),
                    'lat' => $r['geometry']['location']['lat'] ?? null,
                    'lng' => $r['geometry']['location']['lng'] ?? null,
                    'photo' => $this->buildPhotoUrl($r['photos'][0]['photo_reference'] ?? null, $key),
                    'is_featured' => false,
                    'purok_no' => null,
                ];
            }

            return $places;
        } catch (\Throwable $e) {
            return [];
        }
    }

    protected function buildPhotoUrl(?string $photoRef, string $key): ?string
    {
        if (! $photoRef) {
            return null;
        }

        return 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference='.urlencode($photoRef).'&key='.$key;
    }
}
