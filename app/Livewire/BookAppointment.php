<?php

namespace App\Livewire;

use App\Models\Appointment;
// weekday-based closures removed; using date-based closures only
use App\Models\AppointmentDateClosure;
use App\Services\HolidaysService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Flux\Flux;

class BookAppointment extends Component
{
    public string $appointment_date = '';
    public string $appointment_time = '';
    public string $purpose = '';

    public function rules(): array
    {
        return [
            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $dayOfWeek = date('N', strtotime($value));
                    // Prefer explicit date closures when present
                        // Prefer explicit date closures when present in DB
                        if (Schema::hasTable('appointment_date_closures')) {
                            $dateClosure = AppointmentDateClosure::where('date', $value)->first();
                            if ($dateClosure) {
                                $reason = $dateClosure->reason ? ' ' . $dateClosure->reason : '';
                                $fail(__('Appointments are not available on this date. :reason', ['reason' => $reason]));
                                return;
                            }
                        }

                        // Check national holidays (closed by default). These are NOT stored in the manage closures table.
                        $holidayName = HolidaysService::isHoliday($value);
                        if ($holidayName) {
                            $fail(__('Appointments are not available on this date. :reason', ['reason' => 'Holiday: ' . $holidayName]));
                            return;
                        }

                        // If there is no date closure or holiday, fall back to weekend-only rule.
                        if ($dayOfWeek >= 6) {
                            $fail(__('Appointments are only available from Monday to Friday.'));
                        }
                },
            ],
            'appointment_time' => 'required|string',
            'purpose' => 'required|string|min:5|max:500',
        ];
    }

    public function book(): void
    {
        $this->validate();

        Appointment::create([
            'user_id' => Auth::id(),
            'appointment_date' => $this->appointment_date,
            'appointment_time' => $this->appointment_time,
            'purpose' => $this->purpose,
            'status' => 'pending',
        ]);

        $this->reset(['appointment_date', 'appointment_time', 'purpose']);

        Flux::toast(variant: 'success', text: __('Appointment booked successfully! Your request is pending review.'));

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
        $dateClosures = $dateClosures->sortBy(function ($c) { return $c->date->toDateString(); })->values();

        // Also provide upcoming holidays separately for a toggleable UI element in the booking form
        $start = now()->startOfDay();
        $end = now()->addYear()->endOfDay();
        $holidays = HolidaysService::upcomingBetween($start, $end);

        return view('livewire.book-appointment', ['dateClosures' => $dateClosures, 'holidays' => $holidays]);
    }
}
