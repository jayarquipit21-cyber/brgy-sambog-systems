<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use App\Models\Announcement;
use App\Models\AppointmentDateClosure;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    AppointmentDateClosure::where('date', '<', now()->startOfDay()->toDateString())->delete();

    Announcement::where('type', 'event')
        ->where('event_date', '<', now()->startOfDay())
        ->where(function ($query) {
            $query->whereNull('event_end_date')
                ->orWhere('event_end_date', '<', now()->startOfDay());
        })
        ->delete();
})->daily();
