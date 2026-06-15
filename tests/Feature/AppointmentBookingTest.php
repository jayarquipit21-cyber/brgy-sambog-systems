<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AppointmentBookingTest extends TestCase
{
    /** Booking form only requires a purpose (min 5, max 500 chars). */
    private function purposeRules(): array
    {
        return ['purpose' => 'required|string|min:5|max:500'];
    }

    public function test_short_purpose_fails_validation()
    {
        $v = Validator::make(['purpose' => 'Shor'], $this->purposeRules());

        $this->assertTrue($v->fails(), 'Expected validation to fail for short purpose');
        $this->assertArrayHasKey('purpose', $v->errors()->toArray());
    }

    public function test_valid_purpose_passes_validation()
    {
        $v = Validator::make(['purpose' => 'Valid document request purpose.'], $this->purposeRules());

        $this->assertFalse($v->fails());
    }

    public function test_empty_purpose_fails_validation()
    {
        $v = Validator::make(['purpose' => ''], $this->purposeRules());

        $this->assertTrue($v->fails());
        $this->assertArrayHasKey('purpose', $v->errors()->toArray());
    }
}
