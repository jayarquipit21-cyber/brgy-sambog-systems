<div class="space-y-6">
    <!-- Mini Stats Widgets -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-brand/10 text-brand rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <flux:text variant="subtle" class="text-xs font-semibold uppercase text-zinc-500">Total Residents</flux:text>
                <flux:heading size="xl" class="font-bold text-zinc-900 dark:text-white">{{ number_format($stats['total']) }}</flux:heading>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-blue-50 dark:bg-blue-950/20 text-blue-500 rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <div>
                <flux:text variant="subtle" class="text-xs font-semibold uppercase text-zinc-500">Total Households</flux:text>
                <flux:heading size="xl" class="font-bold text-zinc-900 dark:text-white">{{ number_format($stats['households']) }}</flux:heading>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-500 rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <flux:text variant="subtle" class="text-xs font-semibold uppercase text-zinc-500">Voters</flux:text>
                <flux:heading size="xl" class="font-bold text-zinc-900 dark:text-white">{{ number_format($stats['voters']) }}</flux:heading>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-amber-50 dark:bg-amber-950/20 text-amber-500 rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-5.618 2.04M12 2.944v18.056m0 0a11.955 11.955 0 01-5.618-2.04M12 21a11.955 11.955 0 005.618-2.04" />
                </svg>
            </div>
            <div>
                <flux:text variant="subtle" class="text-xs font-semibold uppercase text-zinc-500">Fully Vaccinated</flux:text>
                <flux:heading size="xl" class="font-bold text-zinc-900 dark:text-white">{{ number_format($stats['fully_vaccinated']) }}</flux:heading>
            </div>
        </div>
    </div>

    <!-- Filter Controls Card -->
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Comprehensive RBI Data Grid</flux:heading>
                <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">View all details from the Registry of Barangay Inhabitants. Scroll horizontally to explore categories.</flux:text>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-3">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search name, phone, occupation, household, address..."
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-xs"
                />
                
                <select 
                    wire:model.live="nameLetter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-xs"
                >
                    <option value="">All Names (A–Z)</option>
                    @foreach(range('A', 'Z') as $letter)
                        <option value="{{ $letter }}">Name Starts with {{ $letter }}</option>
                    @endforeach
                </select>

                <select 
                    wire:model.live="purokFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-xs"
                >
                    <option value="">All Puroks</option>
                    @for($i=1; $i<=8; $i++)
                        <option value="{{ $i }}">Purok {{ $i }}</option>
                    @endfor
                </select>

                <select 
                    wire:model.live="sexFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-xs"
                >
                    <option value="">All Sexes</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <select 
                    wire:model.live="voterFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-xs"
                >
                    <option value="">All Voters</option>
                    <option value="national">National Voter</option>
                    <option value="sk">SK Voter</option>
                    <option value="resident">Resident Voter</option>
                    <option value="unregistered">Not Registered</option>
                </select>
                <select 
                    wire:model.live="ageGroup"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-xs"
                >
                    <option value="">All Ages</option>
                    <option value="infant">Infant (0–5)</option>
                    <option value="child">Child (6–12)</option>
                    <option value="teen">Teen (13–17)</option>
                    <option value="young_adult">Young Adult (18–30)</option>
                    <option value="adult">Adult (31–59)</option>
                    <option value="senior">Senior (60+)</option>
                </select>
            </div>
        </div>

        @if($residents->isEmpty())
            <div class="text-center py-12 text-zinc-400 dark:text-zinc-500">
                <svg class="mx-auto h-12 w-12 text-zinc-300 dark:text-zinc-700 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-sm">No inhabitant records match your query.</p>
            </div>
        @else
            <!-- Horizontally Scrollable Grid View -->
            <div class="overflow-x-auto border border-zinc-200 dark:border-zinc-800 rounded-lg">
                <table class="w-full text-left text-xs text-zinc-700 dark:text-zinc-300 whitespace-nowrap min-w-[3000px]">
                    <thead>
                        <!-- Category Header Row -->
                        <tr class="bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 font-bold uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                            <th class="sticky left-0 bg-zinc-100 dark:bg-zinc-800 py-3 px-4 z-20 border-r border-zinc-200 dark:border-zinc-700 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">Resident Name</th>
                            <th colspan="11" class="py-3 px-4 text-center bg-blue-500/10 dark:bg-blue-500/5 text-blue-600 dark:text-blue-400 border-r border-zinc-200 dark:border-zinc-700">Basic & Family Information</th>
                            <th colspan="5" class="py-3 px-4 text-center bg-purple-500/10 dark:bg-purple-500/5 text-purple-600 dark:text-purple-400 border-r border-zinc-200 dark:border-zinc-700">Education & Skills</th>
                            <th colspan="5" class="py-3 px-4 text-center bg-amber-500/10 dark:bg-amber-500/5 text-amber-600 dark:text-amber-400 border-r border-zinc-200 dark:border-zinc-700">Employment & Income</th>
                            <th colspan="5" class="py-3 px-4 text-center bg-emerald-500/10 dark:bg-emerald-500/5 text-emerald-600 dark:text-emerald-400 border-r border-zinc-200 dark:border-zinc-700">Voter Status</th>
                            <th colspan="12" class="py-3 px-4 text-center bg-rose-500/10 dark:bg-rose-500/5 text-rose-600 dark:text-rose-400 border-r border-zinc-200 dark:border-zinc-700">Health & Vaccination Details</th>
                            <th colspan="4" class="py-3 px-4 text-center bg-sky-500/10 dark:bg-sky-500/5 text-sky-600 dark:text-sky-400">Water, Toilet & Waste</th>
                        </tr>
                        <!-- Individual Columns Row -->
                        <tr class="bg-zinc-50 dark:bg-zinc-800/40 text-zinc-500 dark:text-zinc-400 font-semibold uppercase text-[9px] border-b border-zinc-200 dark:border-zinc-800">
                            <!-- Resident Name -->
                            <th class="sticky left-0 bg-zinc-50 dark:bg-zinc-800 py-2.5 px-4 z-20 border-r border-zinc-200 dark:border-zinc-700 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">Full Name</th>
                            
                            <!-- Basic & Family -->
                            <th class="py-2.5 px-3">HH No.</th>
                            <th class="py-2.5 px-3">Purok</th>
                            <th class="py-2.5 px-3">Address</th>
                            <th class="py-2.5 px-3">Relationship to Head</th>
                            <th class="py-2.5 px-3">Age</th>
                            <th class="py-2.5 px-3">Sex</th>
                            <th class="py-2.5 px-3">Birthdate</th>
                            <th class="py-2.5 px-3">Place of Birth</th>
                            <th class="py-2.5 px-3">Civil Status</th>
                            <th class="py-2.5 px-3">Citizenship</th>
                            <th class="py-2.5 px-3 border-r border-zinc-200 dark:border-zinc-700">Contact / Email</th>

                            <!-- Education & Skills -->
                            <th class="py-2.5 px-3">Edu Status</th>
                            <th class="py-2.5 px-3">Highest Attainment</th>
                            <th class="py-2.5 px-3">School Attended</th>
                            <th class="py-2.5 px-3">Eligibility</th>
                            <th class="py-2.5 px-3 border-r border-zinc-200 dark:border-zinc-700">Skills</th>

                            <!-- Employment & Income -->
                            <th class="py-2.5 px-3">Work Status</th>
                            <th class="py-2.5 px-3">Occupation</th>
                            <th class="py-2.5 px-3">Is Farmer?</th>
                            <th class="py-2.5 px-3">Monthly Income</th>
                            <th class="py-2.5 px-3 border-r border-zinc-200 dark:border-zinc-700">Days Work/Week</th>

                            <!-- Voter Status -->
                            <th class="py-2.5 px-3">National Voter</th>
                            <th class="py-2.5 px-3">SK Voter</th>
                            <th class="py-2.5 px-3">Resident Voter</th>
                            <th class="py-2.5 px-3">Last Voted Year</th>
                            <th class="py-2.5 px-3 border-r border-zinc-200 dark:border-zinc-700">KK Assembly Attendance</th>

                            <!-- Health & Vaccine -->
                            <th class="py-2.5 px-3">PhilHealth ID</th>
                            <th class="py-2.5 px-3">PhilHealth Type</th>
                            <th class="py-2.5 px-3">Dose 1 Date</th>
                            <th class="py-2.5 px-3">Dose 2 Date</th>
                            <th class="py-2.5 px-3">Brand</th>
                            <th class="py-2.5 px-3">Booster?</th>
                            <th class="py-2.5 px-3">Booster Brand</th>
                            <th class="py-2.5 px-3">Booster Date</th>
                            <th class="py-2.5 px-3">Medical Conditions</th>
                            <th class="py-2.5 px-3">Nutritional Class</th>
                            <th class="py-2.5 px-3">Vulnerable Sector</th>
                            <th class="py-2.5 px-3 border-r border-zinc-200 dark:border-zinc-700">Welfare Availed</th>

                            <!-- Water Toilet Waste -->
                            <th class="py-2.5 px-3">Water Source</th>
                            <th class="py-2.5 px-3">Sanitary Toilet</th>
                            <th class="py-2.5 px-3">Waste Management</th>
                            <th class="py-2.5 px-3">Blind Drainage?</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/80">
                        @foreach($residents as $res)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition">
                                <!-- Sticky Name Column -->
                                <td class="sticky left-0 bg-white dark:bg-zinc-900 py-3 px-4 font-medium text-zinc-900 dark:text-white border-r border-zinc-200 dark:border-zinc-800 z-10 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)]">
                                    {{ $res->full_name }}
                                </td>

                                <!-- Basic & Family -->
                                <td class="py-3 px-3 font-mono text-zinc-500 dark:text-zinc-400">{{ $res->household->household_no ?? 'N/A' }}</td>
                                <td class="py-3 px-3">Purok {{ $res->household->purok_no ?? 'N/A' }}</td>
                                <td class="py-3 px-3 max-w-[200px] truncate" title="{{ $res->household->address ?? '' }}">{{ $res->household->address ?? 'N/A' }}</td>
                                <td class="py-3 px-3 capitalize text-zinc-600 dark:text-zinc-400">{{ strtolower($res->relationship_to_head ?? 'Member') }}</td>
                                <td class="py-3 px-3 font-semibold">{{ $res->age ?? 'N/A' }}</td>
                                <td class="py-3 px-3">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ $res->sex === 'Male' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-300' }}">
                                        {{ $res->sex ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->birthdate ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 max-w-[150px] truncate" title="{{ $res->place_of_birth ?? '' }}">{{ $res->place_of_birth ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 capitalize">{{ strtolower($res->civil_status ?? 'N/A') }}</td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->citizenship ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 border-r border-zinc-200 dark:border-zinc-800">
                                    <div class="text-[11px] font-medium">{{ $res->mobile_number ?? 'N/A' }}</div>
                                    <div class="text-[9px] text-zinc-400">{{ $res->email_address ?? '' }}</div>
                                </td>

                                <!-- Education & Skills -->
                                <td class="py-3 px-3 text-zinc-600 dark:text-zinc-400 capitalize">{{ strtolower($res->educational_status ?? 'N/A') }}</td>
                                <td class="py-3 px-3 text-zinc-500 max-w-[150px] truncate" title="{{ $res->highest_educational_attainment ?? '' }}">{{ $res->highest_educational_attainment ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 max-w-[150px] truncate" title="{{ $res->school_attended ?? '' }}">{{ $res->school_attended ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->eligibility ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 border-r border-zinc-200 dark:border-zinc-800">
                                    {{ $res->primary_skills ?? $res->secondary_skills ?? 'None' }}
                                </td>

                                <!-- Employment & Income -->
                                <td class="py-3 px-3">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ $res->work_status === 'Employed' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' }}">
                                        {{ $res->work_status ?? 'Unemployed' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->occupation ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500">{{ strtoupper($res->is_farmer ?? 'N') === 'Y' ? 'Yes' : 'No' }}</td>
                                <td class="py-3 px-3 text-zinc-600 dark:text-zinc-400 font-medium">{{ $res->income ? '₱' . number_format((float)$res->income) : 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 border-r border-zinc-200 dark:border-zinc-800 text-center">{{ $res->days_work_per_week ?? '0' }}</td>

                                <!-- Voter Status -->
                                <td class="py-3 px-3 text-center">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ strtoupper($res->registered_national_voter ?? '') === 'Y' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                        {{ strtoupper($res->registered_national_voter ?? '') === 'Y' ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ strtoupper($res->registered_sk_voter ?? '') === 'Y' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                        {{ strtoupper($res->registered_sk_voter ?? '') === 'Y' ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ strtoupper($res->resident_voter ?? '') === 'Y' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                        {{ strtoupper($res->resident_voter ?? '') === 'Y' ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center text-zinc-500 font-mono">{{ $res->last_voted_year ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 border-r border-zinc-200 dark:border-zinc-800 max-w-[120px] truncate">{{ $res->attended_kk_assembly ?? 'N/A' }}</td>

                                <!-- Health & Vaccine -->
                                <td class="py-3 px-3 font-mono text-[10px]">{{ $res->philhealth_id ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 text-[10px] max-w-[120px] truncate">{{ $res->philhealth_membership_type ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->covid_dose_1_date ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->covid_dose_2_date ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->covid_brand ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-center">
                                    <span class="px-1.5 py-0.5 rounded text-[10px] {{ strtoupper($res->has_booster ?? '') === 'Y' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                        {{ strtoupper($res->has_booster ?? '') === 'Y' ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->booster_brand ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->booster_date ?? 'N/A' }}</td>
                                <td class="py-3 px-3 border-r border-zinc-200 dark:border-zinc-800 text-zinc-500">
                                    @if($res->health_condition && $res->health_condition !== 'None')
                                        <span class="text-rose-600 dark:text-rose-400 font-medium bg-rose-50 dark:bg-rose-950/20 px-1.5 py-0.5 rounded">{{ $res->health_condition }}</span>
                                    @else
                                        <span class="text-zinc-400">None</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-zinc-500">{{ $res->nutritional_classification ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 max-w-[120px] truncate">{{ $res->vulnerable_sector ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 border-r border-zinc-200 dark:border-zinc-800 max-w-[120px] truncate">{{ $res->social_welfare_availed ?? 'N/A' }}</td>

                                <!-- Water Toilet Waste -->
                                <td class="py-3 px-3 text-zinc-500 max-w-[120px] truncate">{{ $res->water_source ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 max-w-[120px] truncate">{{ $res->sanitary_toilet ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500 max-w-[120px] truncate">{{ $res->waste_management ?? 'N/A' }}</td>
                                <td class="py-3 px-3 text-zinc-500">{{ strtoupper($res->has_blind_drainage ?? '') === 'Y' ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $residents->links() }}
            </div>
        @endif
    </div>
</div>
