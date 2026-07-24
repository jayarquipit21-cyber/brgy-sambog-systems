<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsDropdown extends Component
{
    public $notifications = [];

    public $userId;

    public $unreadCount = 0;

    public function mount()
    {
        if (Auth::check()) {
            $this->userId = Auth::id();
        }
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->notifications = $user->notifications()->take(10)->get();
            $this->unreadCount = $user->unreadNotifications()->count();
        }
    }

    public function markAsRead($id)
    {
        if (Auth::check()) {
            $notification = Auth::user()->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
                $this->loadNotifications();
            }
        }
    }

    public function markAllAsRead()
    {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.notifications-dropdown');
    }
}
