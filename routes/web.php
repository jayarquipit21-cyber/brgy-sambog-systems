<?php

use App\Models\Announcement;
use App\Models\Appointment;
use App\Models\Household;
use App\Models\Resident;
use App\Services\HolidaysService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stats = [
        'totalResidents' => Resident::approved()->count(),
        'totalHouseholds' => Household::count(),
        'seniorCitizens' => Resident::approved()->where('age', '>=', 60)->count(),
        'vaccinatedCount' => Resident::approved()->where('fully_vaccinated', 'Y')->count(),
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
                $data['totalResidents'] = Resident::approved()->count();
                $data['pendingAppointments'] = Appointment::where('status', 'approved-pending')->count();
                $data['recentAppointments'] = Appointment::with('user')->latest()->take(5)->get();

                // Compute residents per purok (joins households -> residents)
                $purokCounts = \Illuminate\Support\Facades\DB::table('households')
                    ->join('residents', function ($join) {
                        $join->on('households.id', '=', 'residents.household_id')
                             ->where('residents.registration_status', '=', 'approved');
                    })
                    ->select('households.purok_no', \Illuminate\Support\Facades\DB::raw('count(residents.id) as cnt'))
                    ->groupBy('households.purok_no')
                    ->pluck('cnt', 'purok_no')
                    ->toArray();

                // Compute gender distribution
                $rawGenderCounts = Resident::approved()->select('sex', \Illuminate\Support\Facades\DB::raw('count(id) as cnt'))
                    ->groupBy('sex')
                    ->pluck('cnt', 'sex')
                    ->toArray();

                $formattedCounts = [];
                foreach ($rawGenderCounts as $key => $count) {
                    $label = ucfirst(strtolower(trim($key ?? '')));
                    if (empty($label)) $label = 'Not Specified';
                    $formattedCounts[$label] = ($formattedCounts[$label] ?? 0) + $count;
                }

                // Compute age demographics
                $ages = Resident::approved()->pluck('age')->toArray();
                $ageGroups = [
                    'Children (0-12)' => 0,
                    'Teens (13-19)' => 0,
                    'Young Adults (20-35)' => 0,
                    'Adults (36-59)' => 0,
                    'Seniors (60+)' => 0,
                ];
                foreach ($ages as $age) {
                    if ($age === null) continue;
                    if ($age <= 12) $ageGroups['Children (0-12)']++;
                    elseif ($age <= 19) $ageGroups['Teens (13-19)']++;
                    elseif ($age <= 35) $ageGroups['Young Adults (20-35)']++;
                    elseif ($age <= 59) $ageGroups['Adults (36-59)']++;
                    else $ageGroups['Seniors (60+)']++;
                }

                // Normalize labels (sort by purok number)
                ksort($purokCounts);
                $data['purokLabels'] = array_map(function ($n) { return 'Purok ' . $n; }, array_keys($purokCounts));
                $data['purokValues'] = array_values($purokCounts);
                
                $data['genderLabels'] = array_keys($formattedCounts);
                $data['genderValues'] = array_values($formattedCounts);

                $data['ageLabels'] = array_keys($ageGroups);
                $data['ageValues'] = array_values($ageGroups);
            } elseif ($user->isHealthAdmin()) {
            $data['totalResidents'] = Resident::approved()->count();
            $data['totalVaccinated'] = Resident::approved()->where('fully_vaccinated', 'Y')->count();
            
            // Compute gender distribution for Health Admin too
            $rawGenderCounts = Resident::approved()->select('sex', \Illuminate\Support\Facades\DB::raw('count(id) as cnt'))
                ->groupBy('sex')
                ->pluck('cnt', 'sex')
                ->toArray();

            $formattedCounts = [];
            foreach ($rawGenderCounts as $key => $count) {
                $label = ucfirst(strtolower(trim($key ?? '')));
                if (empty($label)) $label = 'Not Specified';
                $formattedCounts[$label] = ($formattedCounts[$label] ?? 0) + $count;
            }
            $data['genderLabels'] = array_keys($formattedCounts);
            $data['genderValues'] = array_values($formattedCounts);

            // Compute age demographics for Health Admin
            $ages = Resident::approved()->pluck('age')->toArray();
            $ageGroups = [
                'Children (0-12)' => 0,
                'Teens (13-19)' => 0,
                'Young Adults (20-35)' => 0,
                'Adults (36-59)' => 0,
                'Seniors (60+)' => 0,
            ];
            foreach ($ages as $age) {
                if ($age === null) continue;
                if ($age <= 12) $ageGroups['Children (0-12)']++;
                elseif ($age <= 19) $ageGroups['Teens (13-19)']++;
                elseif ($age <= 35) $ageGroups['Young Adults (20-35)']++;
                elseif ($age <= 59) $ageGroups['Adults (36-59)']++;
                else $ageGroups['Seniors (60+)']++;
            }
            $data['ageLabels'] = array_keys($ageGroups);
            $data['ageValues'] = array_values($ageGroups);

            $data['totalWithConditions'] = Resident::approved()->whereNotNull('health_condition')
                ->where('health_condition', '!=', '')
                ->where('health_condition', '!=', 'None')
                ->count();
            $data['pediatricCases'] = Resident::approved()->where('age', '<=', 12)
                ->whereNotNull('health_condition')
                ->where('health_condition', '!=', '')
                ->where('health_condition', '!=', 'None')
                ->count();
            $data['seniorCases'] = Resident::approved()->where('age', '>=', 60)
                ->whereNotNull('health_condition')
                ->where('health_condition', '!=', '')
                ->where('health_condition', '!=', 'None')
                ->count();
        } elseif ($user->isHouseholdHead()) {
            $resident = $user->resident;
            $data['residentProfile'] = $resident;
            $data['household'] = $resident ? $resident->household : null;
            $data['householdMembersCount'] = $data['household'] ? $data['household']->residents()->count() : 0;
            $data['householdMembers'] = $data['household']
                ? $data['household']->residents()->orderBy('relationship_to_head')->get()
                : collect();
            $data['upcomingAppointments'] = Appointment::where('user_id', $user->id)
                ->whereIn('status', ['approved-pending', 'approved'])
                ->orderByRaw("CASE WHEN appointment_date IS NULL THEN 0 ELSE 1 END")
                ->orderBy('appointment_date')
                ->take(5)
                ->get();
            $data['recentAnnouncements'] = Announcement::orderByDesc('is_pinned')
                ->orderByDesc('published_at')
                ->take(3)
                ->get();
        } else {
            $resident = $user->resident;
            $data['residentProfile'] = $resident;
            $data['upcomingAppointments'] = Appointment::where('user_id', $user->id)
                ->whereIn('status', ['approved-pending', 'approved'])
                ->orderByRaw("CASE WHEN appointment_date IS NULL THEN 0 ELSE 1 END")
                ->orderBy('appointment_date')
                ->take(5)
                ->get();
            $data['recentAnnouncements'] = Announcement::orderByDesc('is_pinned')
                ->orderByDesc('published_at')
                ->take(3)
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
