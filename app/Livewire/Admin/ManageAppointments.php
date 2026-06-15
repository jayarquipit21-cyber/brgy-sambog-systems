<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\AppointmentDateClosure;
use App\Services\HolidaysService;
use Flux\Flux;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class ManageAppointments extends Component
{
    public string $search = '';

    public string $statusFilter = '';

    // Modal/Scheduling state
    public ?int $selectedAppointmentId = null;
    public string $redemptionDate = '';
    public string $redemptionTime = '';
    public bool $showApproveModal = false;

    public function startApprove(int $id): void
    {
        $this->selectedAppointmentId = $id;
        $this->redemptionDate = now()->toDateString();
        $this->redemptionTime = '09:00 AM - 10:00 AM';
        $this->showApproveModal = true;
    }

    public function confirmApprove(): void
    {
        $this->validate([
            'redemptionDate' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (Schema::hasTable('appointment_date_closures')) {
                        $dateClosure = AppointmentDateClosure::where('date', $value)->first();
                        if ($dateClosure) {
                            $reason = $dateClosure->reason ? ' ('.$dateClosure->reason.')' : '';
                            $fail(__('The office is closed on this date:reason', ['reason' => $reason]));
                            return;
                        }
                    }

                    $holidayName = HolidaysService::isHoliday($value);
                    if ($holidayName) {
                        $fail(__('This date is a national holiday: :holiday', ['holiday' => $holidayName]));
                        return;
                    }

                    $dayOfWeek = date('N', strtotime($value));
                    if ($dayOfWeek >= 6) {
                        $fail(__('The office is closed on weekends.'));
                    }
                }
            ],
            'redemptionTime' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($this->selectedAppointmentId);
        $appointment->update([
            'status' => 'approved',
            'appointment_date' => $this->redemptionDate,
            'appointment_time' => $this->redemptionTime,
        ]);

        $this->showApproveModal = false;
        $this->selectedAppointmentId = null;

        Flux::toast(variant: 'success', text: __('Appointment approved and scheduled successfully!'));
    }

    public function markApprovedPending(int $id): void
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'approved-pending']);
        Flux::toast(variant: 'success', text: __('Request approved for Kapitan\'s signature (Approved-Pending).'));
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
            'admin_notes' => $notes ?: 'Cancelled by Admin.',
        ]);
        Flux::toast(variant: 'success', text: __('Appointment has been rejected/cancelled.'));
    }

    public function delete(int $id): void
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        Flux::toast(variant: 'success', text: __('Appointment record deleted.'));
    }

    public function render()
    {
        $query = Appointment::with('user.resident')
            ->orderByRaw("CASE 
                WHEN status = 'pending' THEN 0 
                WHEN status = 'approved-pending' THEN 1 
                ELSE 2 
            END")
            ->orderBy('created_at', 'desc');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }

        return view('livewire.admin.manage-appointments', [
            'appointments' => $query->get(),
        ]);
    }
}
