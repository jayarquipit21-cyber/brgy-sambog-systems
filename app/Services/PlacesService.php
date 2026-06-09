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

        // If no API key is provided, return an empty array so the caller
        // (e.g. Livewire components) can fallback to the database-backed `Place` records.
        if (empty($key)) {
            return [];
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
