<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Component;

class Announcements extends Component
{
    public function render()
    {
        $announcements = Announcement::whereNotNull('published_at')
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(8)
            ->get();

        $events = Announcement::whereNotNull('published_at')
            ->where('type', 'event')
            ->where(function ($query) {
                $query->where('event_date', '>=', now()->startOfDay())
                    ->orWhere('event_end_date', '>=', now()->startOfDay());
            })
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        return view('livewire.announcements', [
            'announcements' => $announcements,
            'events' => $events,
        ]);
    }
}
