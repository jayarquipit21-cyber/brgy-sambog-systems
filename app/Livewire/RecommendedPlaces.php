<?php

namespace App\Livewire;

use App\Models\Place;
use App\Services\PlacesService;
use Livewire\Component;

class RecommendedPlaces extends Component
{
    public int $limit = 6;

    public ?float $lat = null;

    public ?float $lng = null;

    public function render()
    {
        // Attempt to fetch from Google Places if API key is configured.
        $service = new PlacesService;

        // Default coordinates: try environment variables, else fallback to barangay center.
        $lat = $this->lat ?? env('BARANGAY_LAT', 9.635000);
        $lng = $this->lng ?? env('BARANGAY_LNG', 124.160000);

        $remote = $service->nearbyPlaces((float) $lat, (float) $lng, 1500, $this->limit);

        if (! empty($remote)) {
            $places = collect($remote);
        } else {
            $places = Place::where('is_featured', true)
                ->orderBy('purok_no')
                ->take($this->limit)
                ->get();
        }

        return view('livewire.recommended-places', [
            'places' => $places,
        ]);
    }
}
