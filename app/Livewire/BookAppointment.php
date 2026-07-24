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
    public string $document_type = '';
    public string $purpose_details = '';
    public string $purpose = '';

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
        ];
    }

    public function updatedAppointmentCategory(): void
    {
        $this->document_type = '';
    }

    public function book(): void
    {
        $this->validate();

        $selectedItem = $this->document_type;
        $details = trim($this->purpose_details);
        $isRental = ($this->appointment_category === 'rental');

        if ($selectedItem === 'Other / Custom Barangay Document' || $selectedItem === 'Other Facility / Equipment Rental') {
            if (empty($details)) {
                $this->addError('purpose_details', $isRental ? 'Please describe your equipment or facility rental request.' : 'Please describe your required document or custom request.');
                return;
            }
            $finalPurpose = $isRental ? "[Rental Service] {$details}" : $details;
        } else {
            $prefix = $isRental ? "[Rental Service] {$selectedItem}" : $selectedItem;
            $finalPurpose = !empty($details) ? "{$prefix} — {$details}" : $prefix;
        }

        Appointment::create([
            'user_id' => Auth::id(),
            'purpose' => $finalPurpose,
            'status' => 'pending',
            'appointment_date' => null,
            'appointment_time' => null,
        ]);

        $this->reset(['document_type', 'purpose_details', 'purpose']);

        // Notify all admins about the new request
        $admins = User::where('role', 'admin')->where('id', '!=', Auth::id())->get();
        $notifTitle = $isRental ? 'New Rental Service Request' : 'New Document Request';
        foreach ($admins as $admin) {
            $admin->notify(new SystemNotification(
                $notifTitle,
                Auth::user()->name . ' submitted a request for: "' . $finalPurpose . '".',
                $isRental ? 'building-office' : 'document-text',
                route('appointments')
            ));
        }

        $toastText = $isRental
            ? __('Rental service request submitted successfully! Your request is pending review.')
            : __('Document request submitted successfully! Your request is pending review.');

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
