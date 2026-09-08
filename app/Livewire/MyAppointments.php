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

    public string $search = '';

    public string $statusFilter = '';

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
        $baseQuery = Appointment::where('user_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc');

        if ($this->statusFilter) {
            $baseQuery->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $s = '%'.$this->search.'%';
            $baseQuery->where(function ($q) use ($s) {
                $q->where('purpose', 'like', $s)
                    ->orWhere('admin_notes', 'like', $s)
                    ->orWhereHas('transaction', function ($tq) use ($s) {
                        $tq->where('transaction_code', 'like', $s)
                            ->orWhere('official_receipt_number', 'like', $s);
                    });
            });
        }

        $documentRequests = ($this->type === 'rental')
            ? collect()
            : (clone $baseQuery)->where('purpose', 'not like', '[Rental Service]%')->get();

        $rentalBookings = ($this->type === 'document')
            ? collect()
            : (clone $baseQuery)->where('purpose', 'like', '[Rental Service]%')->get();

        return view('livewire.my-appointments', [
            'documentRequests' => $documentRequests,
            'rentalBookings' => $rentalBookings,
        ]);
    }
}
