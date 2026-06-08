<?php

namespace Tests\Feature;

use App\Livewire\BookAppointment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class BookAppointmentTest extends TestCase
{
    public function test_weekend_date_is_invalid()
    {
        $component = new BookAppointment;
        $rules = $component->rules();

        $data = [
            'appointment_date' => Carbon::parse('next saturday')->toDateString(),
            'appointment_time' => '09:00',
            'purpose' => 'Valid purpose text',
        ];

        $v = Validator::make($data, $rules);

        $this->assertTrue($v->fails());
        $this->assertStringContainsString('Monday to Friday', $v->errors()->first('appointment_date'));
    }

    public function test_weekday_date_is_valid()
    {
        $component = new BookAppointment;
        $rules = $component->rules();

        $data = [
            'appointment_date' => Carbon::parse('next monday')->toDateString(),
            'appointment_time' => '09:00',
            'purpose' => 'Valid purpose text',
        ];

        $v = Validator::make($data, $rules);

        $this->assertFalse($v->fails());
    }
}
