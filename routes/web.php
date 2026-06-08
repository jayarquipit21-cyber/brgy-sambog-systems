<?php

use App\Models\Appointment;
use App\Models\Household;
use App\Models\Resident;
use App\Services\HolidaysService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stats = [
        'totalResidents' => Resident::count(),
        'totalHouseholds' => Household::count(),
        'seniorCitizens' => Resident::where('age', '>=', 60)->count(),
        'vaccinatedCount' => Resident::where('fully_vaccinated', 'Y')->count(),
    ];

    return view('welcome', $stats);
})->name('home');

// Public holidays page (lists upcoming national holidays)
Route::get('holidays', function () {
    $start = now()->startOfDay();
    $end = now()->addYear()->endOfDay();
    $holidays = HolidaysService::upcomingBetween($start, $end);

    return view('pages.holidays', ['holidays' => $holidays]);
})->name('holidays');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $user = auth()->user();
        $data = [];

        if ($user->isAdmin()) {
            $data['totalHouseholds'] = Household::count();
            $data['totalResidents'] = Resident::count();
            $data['pendingAppointments'] = Appointment::where('status', 'pending')->count();
            $data['recentAppointments'] = Appointment::with('user')->latest()->take(5)->get();
        } elseif ($user->isHealthAdmin()) {
            $data['totalResidents'] = Resident::count();
            $data['totalVaccinated'] = Resident::where('fully_vaccinated', 'Y')->count();
            $data['totalWithConditions'] = Resident::whereNotNull('health_condition')
                ->where('health_condition', '!=', '')
                ->where('health_condition', '!=', 'None')
                ->count();
            $data['pediatricCases'] = Resident::where('age', '<=', 12)
                ->whereNotNull('health_condition')
                ->where('health_condition', '!=', '')
                ->where('health_condition', '!=', 'None')
                ->count();
            $data['seniorCases'] = Resident::where('age', '>=', 60)
                ->whereNotNull('health_condition')
                ->where('health_condition', '!=', '')
                ->where('health_condition', '!=', 'None')
                ->count();
        } elseif ($user->isHouseholdHead()) {
            $resident = $user->resident;
            $data['household'] = $resident ? $resident->household : null;
            $data['householdMembersCount'] = $data['household'] ? $data['household']->residents()->count() : 0;
            $data['upcomingAppointments'] = Appointment::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'approved'])
                ->orderBy('appointment_date')
                ->take(5)
                ->get();
        } else {
            $data['upcomingAppointments'] = Appointment::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'approved'])
                ->orderBy('appointment_date')
                ->take(5)
                ->get();
        }

        return view('dashboard', $data);
    })->name('dashboard');

    // Admin routes
    Route::get('rbi', function () {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        return view('pages.rbi');
    })->name('rbi');

    Route::get('admin/announcements', function () {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        return view('admin.announcements');
    })->name('admin.announcements');

    Route::get('rbi-data', function () {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        return view('pages.rbi-data');
    })->name('rbi-data');

    // Health officer routes
    Route::get('health', function () {
        if (! auth()->user()->isHealthAdmin() && ! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        return view('pages.health');
    })->name('health');

    // Household Head routes
    Route::get('household', function () {
        if (! auth()->user()->isHouseholdHead() && ! auth()->user()->isAdmin()) {
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
