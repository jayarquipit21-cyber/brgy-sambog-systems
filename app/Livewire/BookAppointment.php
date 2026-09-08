<?php

namespace App\Livewire;

use App\Models\Appointment;
// weekday-based closures removed; using date-based closures only
use App\Models\AppointmentDateClosure;
use App\Models\User;
use App\Notifications\SystemNotification;
use App\Services\HolidaysService;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class BookAppointment extends Component
{
    public string $appointment_category = 'document'; // 'document' or 'rental'

    public bool $lockCategory = false;

    public string $document_type = '';

    public string $purpose_details = '';

    public ?string $rental_date = null;

    public int $rental_quantity = 1;

    public static array $availableDocuments = [
        'Barangay Clearance' => 'Official clearance for employment, IDs, or legal requirements',
        'Certificate of Indigency' => 'Official certificate for medical, financial, or educational assistance',
        'Certificate of Residency' => 'Proof of residence in Barangay Sambog, Corella, Bohol',
        'Barangay Business Permit Clearance' => 'Clearance for micro or commercial business registration/renewal',
        'Certificate of Good Moral Character' => 'Certification for school, scholarship, or institutional applications',
        'First-Time Job Seeker Certificate (RA 11261)' => 'Free document assistance under Republic Act No. 11261',
        'Barangay Identification Card (ID)' => 'Official Barangay Sambog inhabitant ID card request',
        'Building / Construction Clearance' => 'Clearance for house, fencing, or commercial construction',
        'Tricycle / Transport Permit Clearance' => 'Clearance for local public utility transport operation',
        'Other / Custom Barangay Document' => 'Specify custom document or special purpose request',
    ];

    public static array $availableRentals = [
        'Plastic Monoblock Chairs Rental' => 'Barangay plastic monoblock chairs for events, funerals, & gatherings',
        'Heavy-Duty Event Tents / Canopy Rental' => 'Barangay heavy-duty shelter tents for outdoor occasions',
        'Barangay Basketball Court / Multipurpose Gym Reservation' => 'Reservation of covered basketball court for sports, leagues, or events',
        'Portable Sound System & Microphone Rental' => 'PA system with active speakers and wireless microphones for community events',
        'Banquet Tables & Long Benches Rental' => 'Barangay folding banquet tables and wooden/plastic benches',
        'Other Facility / Equipment Rental' => 'Custom barangay facility or equipment rental request',
    ];

    public function rules(): array
    {
        return [
            'appointment_category' => 'required|in:document,rental',
            'document_type' => 'required|string',
            'purpose_details' => 'nullable|string|max:500',
            'rental_date' => 'nullable|date|after_or_equal:today',
            'rental_quantity' => 'nullable|integer|min:1|max:1000',
        ];
    }

    public function mount(string $appointment_category = 'document'): void
    {
        $this->appointment_category = in_array($appointment_category, ['document', 'rental']) ? $appointment_category : 'document';
    }

    public function updatedAppointmentCategory(): void
    {
        $this->document_type = '';
        $this->rental_date = null;
        $this->rental_quantity = 1;
    }

    public function book(): void
    {
        $this->validate();

        $selectedItem = $this->document_type;
        $details = trim($this->purpose_details);
        $isRental = ($this->appointment_category === 'rental');
        $quantity = $isRental ? max(1, (int) $this->rental_quantity) : 1;

        // Prevent duplicate pending requests for the same service
        $existingPending = Appointment::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->where('purpose', 'like', "%{$selectedItem}%")
            ->first();

        if ($existingPending) {
            $this->addError('document_type', __('You already have a pending request for this service. Please wait for it to be processed before submitting another.'));

            return;
        }

        if ($selectedItem === 'Other / Custom Barangay Document' || $selectedItem === 'Other Facility / Equipment Rental') {
            if (empty($details)) {
                $this->addError('purpose_details', $isRental ? 'Please describe your equipment or facility rental request.' : 'Please describe your required document or custom request.');

                return;
            }
            $finalPurpose = $isRental ? "[Rental Service] {$details} (Qty: {$quantity})" : $details;
        } else {
            $prefix = $isRental ? "[Rental Service] {$selectedItem}" : $selectedItem;
            $qtySuffix = $isRental ? " (Qty: {$quantity})" : "";
            $finalPurpose = ! empty($details) ? "{$prefix}{$qtySuffix} — {$details}" : "{$prefix}{$qtySuffix}";
        }

        $unitFee = \App\Models\ServiceFee::getFeeByName($selectedItem);
        if ($unitFee === 0.00 && ($selectedItem === 'Other / Custom Barangay Document' || $selectedItem === 'Other Facility / Equipment Rental')) {
            $unitFee = $isRental ? 100.00 : 50.00;
        }
        $totalFee = $isRental ? ($unitFee * $quantity) : $unitFee;

        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'purpose' => $finalPurpose,
            'status' => 'pending',
            'appointment_date' => ($isRental && ! empty($this->rental_date)) ? $this->rental_date : null,
            'appointment_time' => null,
        ]);

        // Generate Transaction record
        $isFreeExemption = ($totalFee == 0.00);
        $user = Auth::user();
        \App\Models\Transaction::create([
            'appointment_id' => $appointment->id,
            'user_id' => $user->id,
            'payer_name' => $user->name,
            'payer_address' => $user->resident?->household?->address ?? ($user->resident?->purok ? 'Purok '.$user->resident->purok.', Brgy. Sambog' : 'Barangay Sambog, Corella, Bohol'),
            'service_type' => $isRental ? 'rental' : 'document',
            'item_name' => $selectedItem,
            'quantity' => $quantity,
            'unit_price' => $unitFee,
            'total_amount' => $totalFee,
            'amount_paid' => 0.00,
            'payment_status' => $isFreeExemption ? 'waived' : 'pending',
            'payment_method' => $isFreeExemption ? 'free_exemption' : 'cash',
            'notes' => $isFreeExemption ? 'Statutory fee exemption (Free assistance)' : 'Pending payment collection at Barangay Hall',
            'paid_at' => $isFreeExemption ? now() : null,
        ]);

        $this->reset(['document_type', 'purpose_details', 'rental_date']);
        $this->rental_quantity = 1;

        // Notify all admins about the new request
        $admins = User::where('role', 'admin')->where('id', '!=', Auth::id())->get();
        $notifTitle = $isRental ? 'New Rental Service Request' : 'New Document Request';
        foreach ($admins as $admin) {
            $admin->notify(new SystemNotification(
                $notifTitle,
                Auth::user()->name.' submitted a request for: "'.$finalPurpose.'". Fee: ₱'.number_format($totalFee, 2),
                $isRental ? 'building-office' : 'document-text',
                route('appointments')
            ));
        }

        $toastText = $isRental
            ? __('Rental service request submitted successfully! Fee: ₱:fee (Pending Review)', ['fee' => number_format($totalFee, 2)])
            : __('Document request submitted successfully! Fee: ₱:fee (Pending Review)', ['fee' => number_format($totalFee, 2)]);

        Flux::toast(variant: 'success', text: $toastText);

        $this->dispatch('appointment-booked');
    }

    public function render()
    {
        $dateClosures = collect();

        // DB closures
        if (Schema::hasTable('appointment_date_closures')) {
            $dbClosures = AppointmentDateClosure::where('date', '>=', now()->toDateString())->orderBy('date')->get();
            $dateClosures = $dateClosures->merge($dbClosures->map(function ($c) {
                return (object) ['date' => Carbon::parse($c->date), 'reason' => $c->reason];
            }));
        }

        // Sort by date and return only DB-created closures to the booking UI
        $dateClosures = $dateClosures->sortBy(function ($c) {
            return $c->date->toDateString();
        })->values();

        // Also provide upcoming holidays separately for a toggleable UI element in the booking form
        $start = now()->startOfDay();
        $end = now()->addYear()->endOfDay();
        $holidays = HolidaysService::upcomingBetween($start, $end);

        return view('livewire.book-appointment', ['dateClosures' => $dateClosures, 'holidays' => $holidays]);
    }
}
