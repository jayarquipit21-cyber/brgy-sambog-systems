<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stats = [
        'totalResidents' => \App\Models\Resident::count(),
        'totalHouseholds' => \App\Models\Household::count(),
        'seniorCitizens' => \App\Models\Resident::where('age', '>=', 60)->count(),
        'vaccinatedCount' => \App\Models\Resident::where('fully_vaccinated', 'Y')->count(),
    ];
    return view('welcome', $stats);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $user = auth()->user();
        $data = [];

        if ($user->isAdmin()) {
            $data['totalHouseholds'] = \App\Models\Household::count();
            $data['totalResidents'] = \App\Models\Resident::count();
            $data['pendingAppointments'] = \App\Models\Appointment::where('status', 'pending')->count();
            $data['recentAppointments'] = \App\Models\Appointment::with('user')->latest()->take(5)->get();
        } elseif ($user->isHealthAdmin()) {
            $data['totalResidents'] = \App\Models\Resident::count();
            $data['totalVaccinated'] = \App\Models\Resident::where('fully_vaccinated', 'Y')->count();
            $data['totalWithConditions'] = \App\Models\Resident::whereNotNull('health_condition')
                ->where('health_condition', '!=', '')
                ->where('health_condition', '!=', 'None')
                ->count();
            $data['pediatricCases'] = \App\Models\Resident::where('age', '<=', 12)
                ->whereNotNull('health_condition')
                ->where('health_condition', '!=', '')
                ->where('health_condition', '!=', 'None')
                ->count();
            $data['seniorCases'] = \App\Models\Resident::where('age', '>=', 60)
                ->whereNotNull('health_condition')
                ->where('health_condition', '!=', '')
                ->where('health_condition', '!=', 'None')
                ->count();
        } elseif ($user->isHouseholdHead()) {
            $resident = $user->resident;
            $data['household'] = $resident ? $resident->household : null;
            $data['householdMembersCount'] = $data['household'] ? $data['household']->residents()->count() : 0;
            $data['upcomingAppointments'] = \App\Models\Appointment::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'approved'])
                ->orderBy('appointment_date')
                ->take(5)
                ->get();
        } else {
            $data['upcomingAppointments'] = \App\Models\Appointment::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'approved'])
                ->orderBy('appointment_date')
                ->take(5)
                ->get();
        }

        return view('dashboard', $data);
    })->name('dashboard');

    // Admin routes
    Route::get('rbi', function () {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }
        return view('pages.rbi');
    })->name('rbi');

    // Health officer routes
    Route::get('health', function () {
        if (!auth()->user()->isHealthAdmin() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }
        return view('pages.health');
    })->name('health');

    // Household Head routes
    Route::get('household', function () {
        if (!auth()->user()->isHouseholdHead() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }
        return view('pages.household');
    })->name('household');

    // Shared Appointments route
    Route::get('appointments', function () {
        return view('pages.appointments');
    })->name('appointments');
});

require __DIR__.'/settings.php';

