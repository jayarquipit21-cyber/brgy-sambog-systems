<?php

namespace App\Livewire;

use App\Models\Appointment;
// weekday-based closures removed; using date-based closures only
use App\Models\AppointmentDateClosure;
use App\Services\HolidaysService;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class BookAppointment extends Component
{
    public string $purpose = '';

    public function rules(): array
    {
        return [
            'purpose' => 'required|string|min:5|max:500',
        ];
    }

    public function book(): void
    {
        $this->validate();

        Appointment::create([
            'user_id' => Auth::id(),
            'purpose' => $this->purpose,
            'status' => 'approved-pending',
            'appointment_date' => null,
            'appointment_time' => null,
        ]);

        $this->reset(['purpose']);

        Flux::toast(variant: 'success', text: __('Document request submitted successfully! Your request is pending review and Kapitan\'s signature.'));

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
