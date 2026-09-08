<?php

use App\Livewire\CompleteProfile;
use App\Models\Announcement;
use App\Models\Appointment;
use App\Models\Household;
use App\Models\Resident;
use App\Services\HolidaysService;
use Illuminate\Support\Facades\DB;
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
            $data['pendingAppointments'] = Appointment::where('status', 'pending')->count();
            $data['recentAppointments'] = Appointment::with('user')->latest()->take(5)->get();

            // Compute residents per purok ensuring all standard Puroks 1-8 are initialized
            $existingPuroks = DB::table('households')
                ->whereNotNull('purok_no')
                ->where('purok_no', '!=', '')
                ->distinct()
                ->pluck('purok_no')
                ->toArray();
            $defaultPuroks = [1, 2, 3, 4, 5, 6, 7, 8];
            $allPuroks = array_unique(array_merge($defaultPuroks, $existingPuroks));
            sort($allPuroks, SORT_NATURAL);

            $purokCounts = array_fill_keys($allPuroks, 0);

            $dbPurokCounts = DB::table('households')
                ->join('residents', function ($join) {
                    $join->on('households.id', '=', 'residents.household_id')
                        ->where('residents.registration_status', '=', 'approved');
                })
                ->select('households.purok_no', DB::raw('count(residents.id) as cnt'))
                ->groupBy('households.purok_no')
                ->pluck('cnt', 'purok_no')
                ->toArray();

            foreach ($dbPurokCounts as $pNo => $cnt) {
                $purokCounts[$pNo] = (int) $cnt;
            }

            // Compute gender distribution
            $rawGenderCounts = Resident::approved()->select('sex', DB::raw('count(id) as cnt'))
                ->groupBy('sex')
                ->pluck('cnt', 'sex')
                ->toArray();

            $formattedCounts = [];
            foreach ($rawGenderCounts as $key => $count) {
                $label = ucfirst(strtolower(trim($key ?? '')));
                if (empty($label)) {
                    $label = 'Not Specified';
                }
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
                if ($age === null) {
                    continue;
                }
                if ($age <= 12) {
                    $ageGroups['Children (0-12)']++;
                } elseif ($age <= 19) {
                    $ageGroups['Teens (13-19)']++;
                } elseif ($age <= 35) {
                    $ageGroups['Young Adults (20-35)']++;
                } elseif ($age <= 59) {
                    $ageGroups['Adults (36-59)']++;
                } else {
                    $ageGroups['Seniors (60+)']++;
                }
            }

            $data['purokLabels'] = array_map(function ($n) {
                return 'Purok '.$n;
            }, array_keys($purokCounts));
            $data['purokValues'] = array_values($purokCounts);

            $data['genderLabels'] = array_keys($formattedCounts);
            $data['genderValues'] = array_values($formattedCounts);

            $data['ageLabels'] = array_keys($ageGroups);
            $data['ageValues'] = array_values($ageGroups);
        } elseif ($user->isHealthAdmin()) {
            $data['totalResidents'] = Resident::approved()->count();
            $data['totalVaccinated'] = Resident::approved()->where('fully_vaccinated', 'Y')->count();

            // Compute gender distribution for Health Admin too
            $rawGenderCounts = Resident::approved()->select('sex', DB::raw('count(id) as cnt'))
                ->groupBy('sex')
                ->pluck('cnt', 'sex')
                ->toArray();

            $formattedCounts = [];
            foreach ($rawGenderCounts as $key => $count) {
                $label = ucfirst(strtolower(trim($key ?? '')));
                if (empty($label)) {
                    $label = 'Not Specified';
                }
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
                if ($age === null) {
                    continue;
                }
                if ($age <= 12) {
                    $ageGroups['Children (0-12)']++;
                } elseif ($age <= 19) {
                    $ageGroups['Teens (13-19)']++;
                } elseif ($age <= 35) {
                    $ageGroups['Young Adults (20-35)']++;
                } elseif ($age <= 59) {
                    $ageGroups['Adults (36-59)']++;
                } else {
                    $ageGroups['Seniors (60+)']++;
                }
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

            // Compute family demographics for Household Head
            $hhGenderCounts = [];
            $hhAgeGroups = [
                'Children (0-12)' => 0,
                'Teens (13-19)' => 0,
                'Young Adults (20-35)' => 0,
                'Adults (36-59)' => 0,
                'Seniors (60+)' => 0,
            ];
            foreach ($data['householdMembers'] as $m) {
                $s = ucfirst(strtolower(trim($m->sex ?? '')));
                if (empty($s)) {
                    $s = 'Not Specified';
                }
                $hhGenderCounts[$s] = ($hhGenderCounts[$s] ?? 0) + 1;

                $age = $m->age;
                if ($age !== null) {
                    if ($age <= 12) {
                        $hhAgeGroups['Children (0-12)']++;
                    } elseif ($age <= 19) {
                        $hhAgeGroups['Teens (13-19)']++;
                    } elseif ($age <= 35) {
                        $hhAgeGroups['Young Adults (20-35)']++;
                    } elseif ($age <= 59) {
                        $hhAgeGroups['Adults (36-59)']++;
                    } else {
                        $hhAgeGroups['Seniors (60+)']++;
                    }
                }
            }
            $data['householdGenderLabels'] = array_keys($hhGenderCounts);
            $data['householdGenderValues'] = array_values($hhGenderCounts);
            $data['householdAgeLabels'] = array_keys($hhAgeGroups);
            $data['householdAgeValues'] = array_values($hhAgeGroups);

            $data['upcomingAppointments'] = Appointment::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'approved-pending', 'approved'])
                ->orderByRaw('CASE WHEN appointment_date IS NULL THEN 0 ELSE 1 END')
                ->orderBy('appointment_date')
                ->take(5)
                ->get();
            $data['recentAnnouncements'] = Announcement::orderByDesc('is_pinned')
                ->orderByDesc('published_at')
                ->take(3)
                ->get();
            $data['appointmentHistory'] = Appointment::where('user_id', $user->id)
                ->whereIn('status', ['completed', 'cancelled'])
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get();
        } else {
            $resident = $user->resident;
            $data['residentProfile'] = $resident;

            // Compute service activity & appointments distribution for Resident
            $userAppointments = Appointment::where('user_id', $user->id)->get();
            $activityCounts = [
                'Ready / Approved' => $userAppointments->whereIn('status', ['approved', 'approved-pending'])->count(),
                'Pending Review' => $userAppointments->where('status', 'pending')->count(),
                'Completed' => $userAppointments->where('status', 'completed')->count(),
                'Cancelled' => $userAppointments->where('status', 'cancelled')->count(),
            ];
            $data['residentActivityLabels'] = array_keys($activityCounts);
            $data['residentActivityValues'] = array_values($activityCounts);
            $data['totalAppointmentsCount'] = $userAppointments->count();

            $data['upcomingAppointments'] = Appointment::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'approved-pending', 'approved'])
                ->orderByRaw('CASE WHEN appointment_date IS NULL THEN 0 ELSE 1 END')
                ->orderBy('appointment_date')
                ->take(5)
                ->get();
            $data['recentAnnouncements'] = Announcement::orderByDesc('is_pinned')
                ->orderByDesc('published_at')
                ->take(3)
                ->get();
            $data['appointmentHistory'] = Appointment::where('user_id', $user->id)
                ->whereIn('status', ['completed', 'cancelled'])
                ->orderBy('updated_at', 'desc')
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

    Route::get('admin/blotters', function () {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        return view('pages.blotters');
    })->name('admin.blotters');

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

    Route::get('health/edit', function () {
        if (! auth()->user()->isHealthAdmin() && ! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        return view('pages.health-edit');
    })->name('health.edit');

    // Household Head routes
    Route::get('household', function () {
        if (! auth()->user()->isHouseholdHead() && ! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        return view('pages.household');
    })->name('household');

    // Admin Services & Sales Registry routes
    Route::prefix('admin/services')->group(function () {
        Route::get('documents', function () {
            if (! auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized.');
            }

            return view('pages.admin.services-documents');
        })->name('admin.services.documents');

        Route::get('rentals', function () {
            if (! auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized.');
            }

            return view('pages.admin.services-rentals');
        })->name('admin.services.rentals');
    });

    Route::get('admin/sales', function () {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        return view('pages.admin.sales-report');
    })->name('admin.sales');

    // Resident / Household Services routes (Document Requests & Utility Rentals)
    Route::prefix('services')->group(function () {
        Route::get('documents', function () {
            return view('pages.services-documents');
        })->name('services.documents');

        Route::get('rentals', function () {
            return view('pages.services-rentals');
        })->name('services.rentals');
    });

    // Backward-compatibility aliases for appointments & my-appointments
    Route::get('appointments', function () {
        if (auth()->user()?->isAdmin()) {
            return redirect()->route('admin.services.documents');
        }

        return redirect()->route('services.documents');
    })->name('appointments');

    Route::get('my-appointments', function () {
        return redirect()->route('services.documents');
    })->name('my-appointments');

    // Complete My Profile (resident self-service)
    Route::livewire('profile/complete', CompleteProfile::class)->name('profile.complete');
});

require __DIR__.'/settings.php';
