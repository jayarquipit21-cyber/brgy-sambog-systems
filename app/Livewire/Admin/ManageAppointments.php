<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use Livewire\Component;
use Flux\Flux;

class ManageAppointments extends Component
{
    public string $search = '';
    public string $statusFilter = '';

    public function approve(int $id): void
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'approved']);
        Flux::toast(variant: 'success', text: __('Appointment approved successfully!'));
    }

    public function complete(int $id): void
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'completed']);
        Flux::toast(variant: 'success', text: __('Appointment marked as completed.'));
    }

    public function reject(int $id, string $notes = ''): void
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'status' => 'cancelled',
            'admin_notes' => $notes ?: 'Cancelled by Admin.'
        ]);
        Flux::toast(variant: 'success', text: __('Appointment has been rejected/cancelled.'));
    }

    public function render()
    {
        $query = Appointment::with('user.resident')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.admin.manage-appointments', [
            'appointments' => $query->get()
        ]);
    }
}
