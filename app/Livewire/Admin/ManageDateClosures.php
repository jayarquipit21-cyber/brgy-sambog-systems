<?php

namespace App\Livewire\Admin;

use App\Models\AppointmentDateClosure;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ManageDateClosures extends Component
{
    public $date = '';

    public $reason = '';

    public function mount()
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            throw new AccessDeniedHttpException('Unauthorized');
        }
    }

    public function add(): void
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            throw new AccessDeniedHttpException('Unauthorized');
        }

        $this->validate(['date' => 'required|date|after_or_equal:today']);

        AppointmentDateClosure::updateOrCreate(
            ['date' => $this->date],
            ['reason' => $this->reason]
        );

        $this->date = '';
        $this->reason = '';

        session()->flash('message', __('Date closure added.'));
    }

    public function remove(int $id): void
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            throw new AccessDeniedHttpException('Unauthorized');
        }

        AppointmentDateClosure::findOrFail($id)->delete();
        session()->flash('message', __('Date closure removed.'));
    }

    public function render()
    {
        $closures = AppointmentDateClosure::orderBy('date', 'asc')->get();

        return view('livewire.admin.manage-date-closures', ['closures' => $closures]);
    }
}
