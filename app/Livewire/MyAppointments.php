<?php

namespace App\Livewire;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Flux\Flux;

class MyAppointments extends Component
{
    #[On('appointment-booked')]
    public function refresh(): void
    {
        // Reload list automatically when booking is made
    }

    public function cancel(int $id): void
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($appointment->status === 'pending') {
            $appointment->update(['status' => 'cancelled']);
            Flux::toast(variant: 'success', text: __('Appointment has been cancelled.'));
        } else {
            Flux::toast(variant: 'danger', text: __('Only pending appointments can be cancelled.'));
        }
    }

    public function render()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('livewire.my-appointments', [
            'appointments' => $appointments
        ]);
    }
}
