<?php

namespace App\Livewire\Admin;

use App\Models\Resident;
use Livewire\Attributes\On;
use Livewire\Component;

class ResidentProfileModal extends Component
{
    public bool $showModal = false;

    public ?Resident $resident = null;

    public string $activeSection = 'all';

    #[On('show-resident-profile')]
    public function openProfile(int $id): void
    {
        $this->resident = Resident::with(['household', 'user'])->find($id);
        $this->showModal = true;
    }

    public function closeProfile(): void
    {
        $this->showModal = false;
        $this->resident = null;
    }

    public function render()
    {
        return view('livewire.admin.resident-profile-modal');
    }
}
