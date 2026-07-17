<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\AppointmentDateClosure;
use App\Notifications\SystemNotification;
use App\Services\HolidaysService;
use Flux\Flux;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class ManageAppointments extends Component
{
    public string $search = '';

    public string $statusFilter = '';

    // Approve modal state
    public ?int $selectedAppointmentId = null;
    public string $redemptionDate = '';
    public string $redemptionTime = '';
    public string $approvalNotes = '';
    public bool $showApproveModal = false;

    // Reject modal state
    public ?int $selectedRejectId = null;
    public string $rejectReason = '';
    public bool $showRejectModal = false;

    public function startApprove(int $id): void
    {
        $this->selectedAppointmentId = $id;
        $this->redemptionDate = now()->toDateString();
        $this->redemptionTime = '09:00 AM - 10:00 AM';
        $this->approvalNotes = '';
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
            'status'           => 'approved',
            'appointment_date' => $this->redemptionDate,
            'appointment_time' => $this->redemptionTime,
            'admin_notes'      => $this->approvalNotes ?: null,
        ]);

        $this->showApproveModal = false;
        $this->selectedAppointmentId = null;
        $this->approvalNotes = '';

        // Notify the resident who booked
        $appointment->user->notify(new SystemNotification(
            'Appointment Approved',
            "Your request for \"{$appointment->purpose}\" has been approved and scheduled for {$appointment->appointment_date->format('M d, Y')} at {$appointment->appointment_time}.",
            'check-circle',
            route('my-appointments')
        ));

        Flux::toast(variant: 'success', text: __('Appointment approved and scheduled successfully!'));
    }

    public function markApprovedPending(int $id): void
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'approved-pending']);

        $appointment->user->notify(new SystemNotification(
            'Document Ready for Signing',
            "Your request for \"{$appointment->purpose}\" has been approved and is awaiting the Kapitan's signature.",
            'clipboard-document-check',
            route('my-appointments')
        ));

        Flux::toast(variant: 'success', text: __('Request approved for Kapitan\'s signature (Approved-Pending).'));
    }

    public function complete(int $id): void
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'completed']);

        $appointment->user->notify(new SystemNotification(
            'Document Ready for Pickup',
            "Your request for \"{$appointment->purpose}\" is completed. Please pick up your document at the Barangay Hall.",
            'document-check',
            route('my-appointments')
        ));

        Flux::toast(variant: 'success', text: __('Appointment marked as completed.'));
    }

    public function startReject(int $id): void
    {
        $this->selectedRejectId = $id;
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    public function confirmReject(): void
    {
        $this->validate([
            'rejectReason' => 'required|string|min:5|max:500',
        ], [
            'rejectReason.required' => 'Please provide a reason for cancellation.',
            'rejectReason.min'      => 'Reason must be at least 5 characters.',
        ]);

        $appointment = Appointment::findOrFail($this->selectedRejectId);
        $appointment->update([
            'status'      => 'cancelled',
            'admin_notes' => $this->rejectReason,
        ]);

        $this->showRejectModal = false;
        $this->selectedRejectId = null;
        $this->rejectReason = '';

        // Notify the resident
        $appointment->user->notify(new SystemNotification(
            'Appointment Cancelled',
            "Your request for \"{$appointment->purpose}\" has been cancelled. Reason: {$this->rejectReason}",
            'x-circle',
            route('my-appointments')
        ));

        Flux::toast(variant: 'success', text: __('Appointment has been rejected/cancelled.'));
    }

    public function reject(int $id, string $notes = ''): void
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'status'      => 'cancelled',
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
