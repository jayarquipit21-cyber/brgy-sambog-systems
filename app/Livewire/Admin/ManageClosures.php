<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\AppointmentClosure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ManageClosures extends Component
{
    public array $weekdays = [];

    public function mount()
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            throw new AccessDeniedHttpException('Unauthorized');
        }
        // Ensure there is a record for each weekday
        for ($i = 1; $i <= 7; $i++) {
            $record = AppointmentClosure::firstOrCreate(['weekday' => $i], ['closed' => false, 'reason' => null]);
            $this->weekdays[$i] = ['closed' => (bool)$record->closed, 'reason' => $record->reason];
        }
    }

    public function save(): void
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            throw new AccessDeniedHttpException('Unauthorized');
        }
        foreach ($this->weekdays as $weekday => $data) {
            AppointmentClosure::updateOrCreate(
                ['weekday' => $weekday],
                ['closed' => (bool)$data['closed'], 'reason' => $data['reason']]
            );
        }

        session()->flash('message', __('Closures updated successfully.'));
    }

    public function render()
    {
        return view('livewire.admin.manage-closures', ['weekdays' => $this->weekdays]);
    }
}
