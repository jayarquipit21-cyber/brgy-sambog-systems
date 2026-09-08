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

    public string $typeFilter = ''; // 'document', 'rental', or '' for all

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

    // Payment & OR modal state
    public ?int $selectedPaymentAppointmentId = null;

    public float $paymentAmount = 0.00;

    public string $paymentMethod = 'cash';

    public ?string $paymentOrNumber = null;

    public ?string $paymentNotes = null;

    public bool $showPaymentModal = false;

    // Unpaid warning modal state
    public ?int $pendingCompleteId = null;

    public bool $showUnpaidWarningModal = false;

    public function startPayment(int $id): void
    {
        $appointment = Appointment::with('transaction')->findOrFail($id);
        $this->selectedPaymentAppointmentId = $id;

        $transaction = $appointment->transaction;
        if (! $transaction) {
            $isRental = str_starts_with($appointment->purpose, '[Rental Service]');
            $cleanName = $isRental ? str_replace('[Rental Service] ', '', explode('—', $appointment->purpose)[0]) : explode('—', $appointment->purpose)[0];
            $cleanName = trim($cleanName);
            $fee = \App\Models\ServiceFee::getFeeByName($cleanName) ?: ($isRental ? 100.00 : 50.00);

            $transaction = \App\Models\Transaction::create([
                'appointment_id' => $appointment->id,
                'user_id' => $appointment->user_id,
                'payer_name' => $appointment->user?->name ?? 'Resident Requester',
                'payer_address' => $appointment->user?->resident?->household?->address ?? 'Barangay Sambog, Corella, Bohol',
                'service_type' => $isRental ? 'rental' : 'document',
                'item_name' => $cleanName,
                'quantity' => 1,
                'unit_price' => $fee,
                'total_amount' => $fee,
                'amount_paid' => 0.00,
                'payment_status' => ($fee == 0.00) ? 'waived' : 'pending',
                'payment_method' => ($fee == 0.00) ? 'free_exemption' : 'cash',
            ]);
        }

        $this->paymentAmount = (float) $transaction->total_amount;
        $this->paymentMethod = $transaction->payment_method ?: 'cash';
        $this->paymentOrNumber = $transaction->official_receipt_number ?: sprintf('OR-%s-%04d', now()->format('Y'), rand(100, 999));
        $this->paymentNotes = $transaction->notes ?: '';
        $this->showPaymentModal = true;
    }

    public function confirmPayment(): void
    {
        $this->validate([
            'paymentAmount' => 'required|numeric|min:0',
            'paymentMethod' => 'required|string',
            'paymentOrNumber' => 'nullable|string|max:50',
            'paymentNotes' => 'nullable|string|max:500',
        ]);

        $appointment = Appointment::with('transaction')->findOrFail($this->selectedPaymentAppointmentId);
        $transaction = $appointment->transaction;

        if ($transaction) {
            $transaction->update([
                'amount_paid' => $this->paymentAmount,
                'payment_status' => ($this->paymentAmount >= $transaction->total_amount || $this->paymentMethod === 'free_exemption') ? 'paid' : 'pending',
                'payment_method' => $this->paymentMethod,
                'official_receipt_number' => $this->paymentOrNumber ?: null,
                'processed_by' => auth()->id(),
                'notes' => $this->paymentNotes ?: 'Payment received at Barangay Hall',
                'paid_at' => now(),
            ]);
        }

        $this->showPaymentModal = false;
        $this->selectedPaymentAppointmentId = null;

        Flux::toast(variant: 'success', text: __('Payment recorded & Official Receipt updated successfully!'));
    }

    public function markAsFreeExemption(int $id): void
    {
        $appointment = Appointment::with('transaction')->findOrFail($id);
        if ($appointment->transaction) {
            $appointment->transaction->markAsWaived(auth()->id(), 'Statutory Exemption (Indigency / RA 11261)');
        }
        Flux::toast(variant: 'success', text: __('Fee waived under statutory exemption.'));
    }

    public static array $defaultTimeSlots = [
        '09:00 AM - 10:00 AM',
        '10:00 AM - 11:00 AM',
        '11:00 AM - 12:00 PM',
        '01:00 PM - 02:00 PM',
        '02:00 PM - 03:00 PM',
        '03:00 PM - 04:00 PM',
        '04:00 PM - 05:00 PM',
    ];

    public function getFirstAvailableSlot(string $date): string
    {
        $slots = self::$defaultTimeSlots;
        if ($date === now()->toDateString()) {
            $now = now();
            foreach ($slots as $slot) {
                $startTimeStr = trim(explode(' - ', $slot)[0]);
                try {
                    $slotStart = \Carbon\Carbon::parse("{$date} {$startTimeStr}");
                    if ($slotStart->gte($now)) {
                        return $slot;
                    }
                } catch (\Exception $e) {
                }
            }
        }

        return $slots[0];
    }

    public function updatedRedemptionDate(): void
    {
        if ($this->redemptionDate) {
            $this->redemptionTime = $this->getFirstAvailableSlot($this->redemptionDate);
        }
    }

    public function startApprove(int $id): void
    {
        $this->selectedAppointmentId = $id;
        $this->redemptionDate = now()->toDateString();
        $this->redemptionTime = $this->getFirstAvailableSlot($this->redemptionDate);
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
                            $fail(__('The office is closed on this date: :reason', ['reason' => $reason]));

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
                },
            ],
            'redemptionTime' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if ($this->redemptionDate === now()->toDateString()) {
                        $startTimeStr = trim(explode(' - ', $value)[0]);
                        try {
                            $slotStart = \Carbon\Carbon::parse("{$this->redemptionDate} {$startTimeStr}");
                            if ($slotStart->lt(now())) {
                                $fail(__('The scheduled release time cannot be earlier than the current time.'));
                            }
                        } catch (\Exception $e) {
                        }
                    }
                },
            ],
        ]);

        $appointment = Appointment::findOrFail($this->selectedAppointmentId);
        $appointment->update([
            'status' => 'approved',
            'appointment_date' => $this->redemptionDate,
            'appointment_time' => $this->redemptionTime,
            'admin_notes' => $this->approvalNotes ?: null,
        ]);

        $this->showApproveModal = false;
        $this->selectedAppointmentId = null;
        $this->approvalNotes = '';

        $isRental = str_starts_with($appointment->purpose, '[Rental Service]');
        $notifTitle = $isRental ? 'Rental Booking Approved' : 'Appointment Approved';

        // Notify the resident who booked
        $appointment->user?->notify(new SystemNotification(
            $notifTitle,
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

        $isRental = str_starts_with($appointment->purpose, '[Rental Service]');

        $appointment->user?->notify(new SystemNotification(
            $isRental ? 'Rental Booking Ready for Signing' : 'Document Ready for Signing',
            "Your request for \"{$appointment->purpose}\" has been approved and is awaiting the Kapitan's signature.",
            'clipboard-document-check',
            route('my-appointments')
        ));

        Flux::toast(variant: 'success', text: __('Request approved for Kapitan\'s signature (Approved-Pending).'));
    }

    public function getPendingCompleteAppointmentProperty(): ?Appointment
    {
        return $this->pendingCompleteId
            ? Appointment::with(['transaction', 'user'])->find($this->pendingCompleteId)
            : null;
    }

    public function complete(int $id, bool $force = false): void
    {
        $appointment = Appointment::with(['transaction', 'user'])->findOrFail($id);

        $transaction = $appointment->transaction;
        $isUnpaid = $transaction
            && (float) $transaction->total_amount > 0
            && ! in_array($transaction->payment_status, ['paid', 'waived']);

        if ($isUnpaid && ! $force) {
            $this->pendingCompleteId = $id;
            $this->showUnpaidWarningModal = true;
            $docName = str_replace('[Rental Service] ', '', $appointment->purpose);

            Flux::toast(
                variant: 'warning',
                text: __("Warning: The document claim for \":doc\" has not been paid yet! Total Due: ₱:amount.", [
                    'doc' => \Illuminate\Support\Str::limit($docName, 35),
                    'amount' => number_format($transaction->total_amount, 2),
                ])
            );

            return;
        }

        $appointment->update(['status' => 'completed']);
        $this->showUnpaidWarningModal = false;
        $this->pendingCompleteId = null;

        $isRental = str_starts_with($appointment->purpose, '[Rental Service]');

        $appointment->user?->notify(new SystemNotification(
            $isRental ? 'Rental Service Completed' : 'Document Ready for Pickup',
            $isRental
                ? "Your rental request for \"{$appointment->purpose}\" is completed."
                : "Your request for \"{$appointment->purpose}\" is completed. Please pick up your document at the Barangay Hall.",
            'document-check',
            route('my-appointments')
        ));

        Flux::toast(variant: 'success', text: __('Appointment marked as completed.'));
    }

    public function confirmComplete(): void
    {
        if ($this->pendingCompleteId) {
            $this->complete($this->pendingCompleteId, true);
        }
    }

    public function payBeforeComplete(): void
    {
        $id = $this->pendingCompleteId;
        $this->showUnpaidWarningModal = false;
        if ($id) {
            $this->startPayment($id);
        }
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
            'rejectReason.min' => 'Reason must be at least 5 characters.',
        ]);

        $appointment = Appointment::findOrFail($this->selectedRejectId);
        $appointment->update([
            'status' => 'cancelled',
            'admin_notes' => $this->rejectReason,
        ]);

        // Notify the resident (must happen before resetting rejectReason)
        $appointment->user?->notify(new SystemNotification(
            'Appointment Cancelled',
            "Your request for \"{$appointment->purpose}\" has been cancelled. Reason: {$this->rejectReason}",
            'x-circle',
            route('my-appointments')
        ));

        $this->showRejectModal = false;
        $this->selectedRejectId = null;
        $this->rejectReason = '';

        Flux::toast(variant: 'success', text: __('Appointment has been rejected/cancelled.'));
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
        $baseQuery = Appointment::with(['user.resident', 'transaction'])
            ->orderByRaw("CASE 
                WHEN status = 'pending' THEN 0 
                WHEN status = 'approved-pending' THEN 1 
                ELSE 2 
            END")
            ->orderBy('created_at', 'desc');

        if ($this->statusFilter) {
            $baseQuery->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $baseQuery->whereHas('user', function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }

        $documentRequests = (clone $baseQuery)
            ->where('purpose', 'not like', '[Rental Service]%')
            ->get();

        $rentalBookings = (clone $baseQuery)
            ->where('purpose', 'like', '[Rental Service]%')
            ->get();

        return view('livewire.admin.manage-appointments', [
            'documentRequests' => $documentRequests,
            'rentalBookings' => $rentalBookings,
        ]);
    }
}
