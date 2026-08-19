<?php

namespace App\Livewire;

use App\Models\Appointment;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class MyAppointments extends Component
{
    public string $type = ''; // 'document', 'rental', or '' for all

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

        if (in_array($appointment->status, ['pending', 'approved-pending'])) {
            $appointment->update(['status' => 'cancelled']);
            Flux::toast(variant: 'success', text: __('Request has been cancelled.'));
        } else {
            Flux::toast(variant: 'danger', text: __('Only pending or pending-approval requests can be cancelled.'));
        }
    }

    public function render()
    {
        $documentRequests = ($this->type === 'rental')
            ? collect()
            : Appointment::where('user_id', Auth::id())
                ->where('purpose', 'not like', '[Rental Service]%')
                ->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'desc')
                ->get();

        $rentalBookings = ($this->type === 'document')
            ? collect()
            : Appointment::where('user_id', Auth::id())
                ->where('purpose', 'like', '[Rental Service]%')
                ->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'desc')
                ->get();

        return view('livewire.my-appointments', [
            'documentRequests' => $documentRequests,
            'rentalBookings' => $rentalBookings,
        ]);
    }
}
