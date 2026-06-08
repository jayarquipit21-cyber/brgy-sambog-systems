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

        return view('livewire.announcements', ['announcements' => $announcements]);
    }
}
