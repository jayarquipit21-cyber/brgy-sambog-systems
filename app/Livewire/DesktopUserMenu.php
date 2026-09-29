<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class DesktopUserMenu extends Component
{
    public bool $mobile = false;

    #[On('avatar-saved')]
    #[On('profile-updated')]
    public function refreshUser(): void
    {
        // Triggers reactive re-render when avatar or profile is updated
    }

    public function render()
    {
        return view('livewire.desktop-user-menu', [
            'user' => Auth::user(),
        ]);
    }
}
