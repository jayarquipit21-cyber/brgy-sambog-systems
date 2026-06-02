<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Announcement;

class Announcements extends Component
{
    public function render()
    {
        $announcements = Announcement::whereNotNull('published_at')
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(8)
            ->get();

        return view('livewire.announcements', ['announcements' => $announcements]);
    }
}
