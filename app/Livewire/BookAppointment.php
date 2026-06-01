<?php

namespace App\Livewire;

use App\Models\Appointment;
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
        return view('livewire.book-appointment');
    }
}
