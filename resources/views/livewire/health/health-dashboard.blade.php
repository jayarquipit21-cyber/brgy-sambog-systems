<div>
    <!-- Age-Dynamic Health Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-zinc-500">All Health Cases</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ number_format($stats['total_cases']) }}</flux:heading>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm border-l-4 border-l-blue-500">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-blue-500">Pediatric (0-12)</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ number_format($stats['pediatric_cases']) }}</flux:heading>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm border-l-4 border-l-emerald-500">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-emerald-500">Youth (13-24)</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ number_format($stats['youth_cases']) }}</flux:heading>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm border-l-4 border-l-amber-500">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-amber-500">Adult (25-59)</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ number_format($stats['adult_cases']) }}</flux:heading>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm border-l-4 border-l-red-500">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-red-500">Senior (60+)</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ number_format($stats['senior_cases']) }}</flux:heading>
        </div>
    </div>

    <!-- Main Health & Medical History Registry Card -->
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
        <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Health & Medical History Registry</flux:heading>
                <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Complete health profiles, vaccination records, and medical history of all registered residents.</flux:text>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search name, condition, PhilHealth, blood type, sector..."
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm w-full sm:w-72"
                />

                <select 
                    wire:model.live="ageGroupFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                >
                    <option value="">All Age Groups</option>
                    <option value="pediatric">Pediatric (0-12 y/o)</option>
                    <option value="youth">Youth (13-24 y/o)</option>
                    <option value="adult">Adult (25-59 y/o)</option>
                    <option value="senior">Senior (60+ y/o)</option>
                </select>

                <select 
                    wire:model.live="healthFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                >
                    <option value="">All Health Statuses</option>
                    <option value="has_condition">With Health Condition</option>
                    <option value="none">No Health Condition</option>
                </select>
            </div>
        </div>

        @if($healthRecords->isEmpty())
            <div class="text-center py-8 text-zinc-400 dark:text-zinc-500">
                <svg class="mx-auto h-12 w-12 text-zinc-300 dark:text-zinc-700 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm">No records found matching the filters.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                            <th class="py-3 px-4">Resident Name</th>
                            <th class="py-3 px-4 text-center">Age / Sex</th>
                            <th class="py-3 px-4">Age Group</th>
                            <th class="py-3 px-4">Blood Type</th>
                            <th class="py-3 px-4">Health Condition</th>
                            <th class="py-3 px-4">Nutritional Status</th>
                            <th class="py-3 px-4">Vaccine Status</th>
                            <th class="py-3 px-4">COVID Vaccination</th>
                            <th class="py-3 px-4">Booster</th>
                            <th class="py-3 px-4">PhilHealth</th>
                            <th class="py-3 px-4">Vulnerable Sector</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($healthRecords as $rec)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                {{-- Resident Name --}}
                                <td class="py-3 px-4 font-semibold whitespace-nowrap">
                                    <button type="button" 
                                            wire:click="openResidentHealthCard({{ $rec->id }})"
                                            class="group inline-flex items-center gap-2 text-left cursor-pointer hover:text-emerald-600 dark:hover:text-emerald-400 transition"
                                            title="Click to view comprehensive health card & profile">
                                        <span class="text-zinc-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 font-semibold group-hover:underline">
                                            {{ $rec->last_name }}, {{ $rec->first_name }}
                                            @if($rec->middle_name) {{ substr($rec->middle_name, 0, 1) }}.@endif
                                            @if($rec->extension) {{ $rec->extension }}@endif
                                        </span>
                                        <span class="inline-flex items-center justify-center size-5 rounded-full bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400 opacity-60 group-hover:opacity-100 group-hover:scale-110 transition shadow-xs">
                                            <flux:icon name="heart" class="size-3" />
                                        </span>
                                    </button>
                                </td>

                                {{-- Age / Sex --}}
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <span class="text-zinc-900 dark:text-white font-medium">{{ $rec->age ?? 'N/A' }}</span>
                                    <span class="text-zinc-400 dark:text-zinc-600 text-xs">/ {{ $rec->sex ?? '—' }}</span>
                                </td>

                                {{-- Age Group Badge --}}
                                <td class="py-3 px-4">
                                    @if($rec->age !== null && $rec->age <= 12)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/20 dark:text-blue-400 dark:border-blue-900/50">
                                            Pediatric
                                        </span>
                                    @elseif($rec->age !== null && $rec->age <= 24)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-900/50">
                                            Youth
                                        </span>
                                    @elseif($rec->age !== null && $rec->age <= 59)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/20 dark:text-amber-400 dark:border-amber-900/50">
                                            Adult
                                        </span>
                                    @elseif($rec->age !== null)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-red-50 text-red-800 border border-red-200 dark:bg-red-950/20 dark:text-red-400 dark:border-red-900/50">
                                            Senior
                                        </span>
                                    @else
                                        <span class="text-zinc-400 text-xs">—</span>
                                    @endif
                                </td>

                                {{-- Blood Type --}}
                                <td class="py-3 px-4 text-center">
                                    @if($rec->blood_type)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/20 dark:text-rose-400 dark:border-rose-900/50">
                                            {{ $rec->blood_type }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400 text-xs">—</span>
                                    @endif
                                </td>

                                {{-- Health Condition --}}
                                <td class="py-3 px-4">
                                    @if($rec->health_condition && $rec->health_condition !== 'None')
                                        <span class="text-zinc-900 dark:text-white font-medium">{{ $rec->health_condition }}</span>
                                    @else
                                        <span class="text-emerald-600 dark:text-emerald-400 text-xs font-medium">No condition</span>
                                    @endif
                                </td>

                                {{-- Nutritional Status --}}
                                <td class="py-3 px-4 text-xs">
                                    {{ $rec->nutritional_classification ?: 'Normal' }}
                                </td>

                                {{-- Vaccine Status --}}
                                <td class="py-3 px-4 text-xs whitespace-nowrap">
                                    @if($rec->fully_vaccinated === 'Y')
                                        <span class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            Fully
                                        </span>
                                    @elseif($rec->partially_vaccinated === 'Y')
                                        <span class="text-amber-600 dark:text-amber-400 font-medium">Partial</span>
                                    @else
                                        <span class="text-red-500 font-medium">Unvaccinated</span>
                                    @endif
                                </td>

                                {{-- COVID Vaccination Details --}}
                                <td class="py-3 px-4 text-xs whitespace-nowrap">
                                    @if($rec->covid_dose_1_date || $rec->covid_dose_2_date)
                                        <div class="space-y-0.5">
                                            @if($rec->covid_dose_1_date)
                                                <div><span class="text-zinc-500">D1:</span> <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $rec->covid_dose_1_date }}</span></div>
                                            @endif
                                            @if($rec->covid_dose_2_date)
                                                <div><span class="text-zinc-500">D2:</span> <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $rec->covid_dose_2_date }}</span></div>
                                            @endif
                                            @if($rec->covid_brand)
                                                <div class="text-zinc-500 italic">{{ $rec->covid_brand }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-zinc-400">—</span>
                                    @endif
                                </td>

                                {{-- Booster --}}
                                <td class="py-3 px-4 text-xs whitespace-nowrap">
                                    @if($rec->has_booster === 'Y')
                                        <div class="space-y-0.5">
                                            <span class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-semibold">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                Yes
                                            </span>
                                            @if($rec->booster_date)
                                                <div class="text-zinc-500">{{ $rec->booster_date }}</div>
                                            @endif
                                            @if($rec->booster_brand)
                                                <div class="text-zinc-500 italic">{{ $rec->booster_brand }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-zinc-400">—</span>
                                    @endif
                                </td>

                                {{-- PhilHealth --}}
                                <td class="py-3 px-4 text-xs whitespace-nowrap">
                                    @if($rec->has_philhealth === 'Y')
                                        <div>
                                            <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Enrolled</span>
                                            @if($rec->philhealth_no)
                                                <div class="text-zinc-500 text-[10px] mt-0.5">{{ $rec->philhealth_no }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-red-500 font-medium">Not enrolled</span>
                                    @endif
                                </td>

                                {{-- Vulnerable Sector --}}
                                <td class="py-3 px-4 text-xs">
                                    @if($rec->vulnerable_sector && $rec->vulnerable_sector !== 'None')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-violet-50 text-violet-800 border border-violet-200 dark:bg-violet-950/20 dark:text-violet-400 dark:border-violet-900/50">
                                            {{ $rec->vulnerable_sector }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400 italic">None</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $healthRecords->links() }}
            </div>
        @endif
    </div>

    <!-- Resident Health Card & Comprehensive Profile Modal -->
    <flux:modal name="resident-health-card-modal" class="max-w-4xl p-0 overflow-hidden" wire:model="showHealthCardModal">
        @if($selectedResident)
            <div class="space-y-6 max-h-[85vh] overflow-y-auto p-6 sm:p-8 font-sans">
                <!-- Top Header: Health-Themed Hero Banner -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-zinc-950 via-slate-900 to-emerald-950 text-white p-6 border border-emerald-900/40 shadow-xl">
                    <div class="absolute -right-10 -top-10 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -left-10 -bottom-10 w-64 h-64 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative flex flex-col sm:flex-row items-center sm:items-start gap-5 z-10">
                        <!-- Profile Avatar -->
                        <div class="relative shrink-0">
                            @if($selectedResident->user?->avatar)
                                <img src="{{ $selectedResident->user->avatar_url }}" alt="{{ $selectedResident->full_name }}" class="size-24 rounded-2xl object-cover ring-4 ring-emerald-500/30 shadow-xl">
                            @else
                                <div class="size-24 rounded-2xl bg-gradient-to-tr from-emerald-600 via-teal-600 to-cyan-600 text-white font-black font-outfit text-3xl flex items-center justify-center ring-4 ring-emerald-500/30 shadow-xl">
                                    {{ strtoupper(substr($selectedResident->first_name, 0, 1) . substr($selectedResident->last_name, 0, 1)) }}
                                </div>
                            @endif

                            @if($selectedResident->registration_status === 'approved')
                                <div class="absolute -bottom-1.5 -right-1.5 bg-emerald-500 text-white p-1 rounded-full ring-2 ring-zinc-900 shadow-sm" title="Verified Resident">
                                    <flux:icon name="check" class="size-3.5" />
                                </div>
                            @endif
                        </div>

                        <!-- Core Profile & Key Health Status -->
                        <div class="flex-1 text-center sm:text-left space-y-2">
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                                <h2 class="text-xl sm:text-2xl font-black font-outfit text-white tracking-tight">
                                    {{ $selectedResident->full_name }}
                                </h2>

                                <!-- Relationship Badge -->
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider
                                    @if(strtolower($selectedResident->relationship_to_head) === 'household head' || strtolower($selectedResident->relationship_to_head) === 'hh')
                                        bg-amber-500/20 text-amber-300 border border-amber-500/30
                                    @else
                                        bg-sky-500/20 text-sky-300 border border-sky-500/30
                                    @endif">
                                    {{ $selectedResident->relationship_to_head ?: 'Resident Member' }}
                                </span>

                                <!-- Age Category Badge -->
                                @if($selectedResident->age !== null && $selectedResident->age <= 12)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                        Pediatric
                                    </span>
                                @elseif($selectedResident->age !== null && $selectedResident->age <= 24)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                        Youth
                                    </span>
                                @elseif($selectedResident->age !== null && $selectedResident->age <= 59)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                        Adult
                                    </span>
                                @elseif($selectedResident->age !== null)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-500/20 text-red-300 border border-red-500/30">
                                        Senior Citizen
                                    </span>
                                @endif
                            </div>

                            <div class="text-xs text-zinc-300 flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-1">
                                @if($selectedResident->household)
                                    <span class="inline-flex items-center gap-1.5 text-zinc-300">
                                        <flux:icon name="home" class="size-3.5 text-emerald-400" />
                                        HH #{{ $selectedResident->household->household_no }} (Purok {{ $selectedResident->household->purok_no ?? '—' }})
                                    </span>
                                @endif
                                @if($selectedResident->mobile_number)
                                    <span class="inline-flex items-center gap-1.5 text-zinc-300">
                                        <flux:icon name="phone" class="size-3.5 text-emerald-400" />
                                        {{ $selectedResident->mobile_number }}
                                    </span>
                                @endif
                                @if($selectedResident->email_address || $selectedResident->user?->email)
                                    <span class="inline-flex items-center gap-1.5 text-zinc-300">
                                        <flux:icon name="envelope" class="size-3.5 text-emerald-400" />
                                        {{ $selectedResident->email_address ?: $selectedResident->user?->email }}
                                    </span>
                                @endif
                            </div>

                            <!-- Quick Health Highlight Tags -->
                            <div class="pt-2 flex flex-wrap items-center justify-center sm:justify-start gap-2">
                                @if($selectedResident->blood_type)
                                    <span class="inline-flex items-center gap-1 text-[11px] bg-rose-500/20 text-rose-200 border border-rose-500/30 px-2.5 py-0.5 rounded-lg font-semibold">
                                        <flux:icon name="heart" class="size-3 text-rose-400" />
                                        Blood: <strong class="text-white">{{ $selectedResident->blood_type }}</strong>
                                    </span>
                                @endif

                                @if($selectedResident->fully_vaccinated === 'Y')
                                    <span class="inline-flex items-center gap-1 text-[11px] bg-emerald-500/20 text-emerald-200 border border-emerald-500/30 px-2.5 py-0.5 rounded-lg font-semibold">
                                        <flux:icon name="check-circle" class="size-3 text-emerald-400" />
                                        Fully Vaccinated
                                    </span>
                                @elseif($selectedResident->partially_vaccinated === 'Y')
                                    <span class="inline-flex items-center gap-1 text-[11px] bg-amber-500/20 text-amber-200 border border-amber-500/30 px-2.5 py-0.5 rounded-lg font-semibold">
                                        Partially Vaccinated
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] bg-red-500/20 text-red-200 border border-red-500/30 px-2.5 py-0.5 rounded-lg font-semibold">
                                        Unvaccinated
                                    </span>
                                @endif

                                @if($selectedResident->has_philhealth === 'Y')
                                    <span class="inline-flex items-center gap-1 text-[11px] bg-blue-500/20 text-blue-200 border border-blue-500/30 px-2.5 py-0.5 rounded-lg font-semibold">
                                        <flux:icon name="shield-check" class="size-3 text-blue-400" />
                                        PhilHealth: {{ $selectedResident->philhealth_id ?: 'Enrolled' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4 Quick Health Stat Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <!-- 1. Blood & Vitals -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Vitals & Body Stats</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-sm font-bold text-zinc-900 dark:text-white">
                                {{ $selectedResident->blood_type ? 'Type ' . $selectedResident->blood_type : 'Type —' }}
                            </span>
                            @if($this->bmi)
                                <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-{{ $this->bmi['color'] }}-100 text-{{ $this->bmi['color'] }}-800 dark:bg-{{ $this->bmi['color'] }}-900/30 dark:text-{{ $this->bmi['color'] }}-300">
                                    BMI {{ $this->bmi['value'] }}
                                </span>
                            @endif
                        </div>
                        <div class="text-[11px] text-zinc-500 dark:text-zinc-400">
                            {{ $selectedResident->height ? $selectedResident->height . ' cm' : '— cm' }} / {{ $selectedResident->weight ? $selectedResident->weight . ' kg' : '— kg' }}
                            @if($this->bmi) ({{ $this->bmi['label'] }}) @endif
                        </div>
                    </div>

                    <!-- 2. Medical Condition -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Medical Condition</span>
                        <div class="text-sm font-bold truncate {{ ($selectedResident->health_condition && $selectedResident->health_condition !== 'None') ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                            {{ $selectedResident->health_condition ?: 'No Condition' }}
                        </div>
                        <div class="text-[11px] text-zinc-500 dark:text-zinc-400 truncate">
                            Nutritional: {{ $selectedResident->nutritional_classification ?: 'Normal' }}
                        </div>
                    </div>

                    <!-- 3. Immunization & Booster -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">COVID & Booster</span>
                        <div class="text-sm font-bold text-zinc-900 dark:text-white truncate">
                            {{ $selectedResident->covid_brand ?: ($selectedResident->fully_vaccinated === 'Y' ? 'Vaccinated' : 'Unvaccinated') }}
                        </div>
                        <div class="text-[11px] text-zinc-500 dark:text-zinc-400">
                            Booster: {{ $selectedResident->has_booster === 'Y' ? 'Received (' . ($selectedResident->booster_brand ?: 'Yes') . ')' : 'None' }}
                        </div>
                    </div>

                    <!-- 4. PhilHealth & Welfare -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-3.5 space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">PhilHealth & Welfare</span>
                        <div class="text-sm font-bold text-zinc-900 dark:text-white truncate">
                            {{ $selectedResident->has_philhealth === 'Y' ? 'PhilHealth Member' : 'Not Enrolled' }}
                        </div>
                        <div class="text-[11px] text-zinc-500 dark:text-zinc-400 truncate">
                            Sector: {{ $selectedResident->vulnerable_sector ?: 'General' }}
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation Buttons -->
                <div class="flex border-b border-zinc-200 dark:border-zinc-800 gap-6 text-sm font-medium">
                    <button type="button" 
                            wire:click="$set('cardActiveTab', 'health')"
                            class="pb-2.5 transition border-b-2 cursor-pointer inline-flex items-center gap-1.5 {{ $cardActiveTab === 'health' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200' }}">
                        <flux:icon name="heart" class="size-4" />
                        Health & Medical Record
                    </button>
                    <button type="button" 
                            wire:click="$set('cardActiveTab', 'profile')"
                            class="pb-2.5 transition border-b-2 cursor-pointer inline-flex items-center gap-1.5 {{ $cardActiveTab === 'profile' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200' }}">
                        <flux:icon name="user" class="size-4" />
                        Personal & Demographics
                    </button>
                    <button type="button" 
                            wire:click="$set('cardActiveTab', 'household')"
                            class="pb-2.5 transition border-b-2 cursor-pointer inline-flex items-center gap-1.5 {{ $cardActiveTab === 'household' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200' }}">
                        <flux:icon name="home" class="size-4" />
                        Household & Living Condition
                    </button>
                </div>

                <!-- Tab 1: Health & Medical Record -->
                @if($cardActiveTab === 'health')
                    <div class="space-y-4">
                        <!-- Medical Condition & Clinical Notes -->
                        <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                            <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                                <flux:icon name="clipboard-document-list" class="size-4 text-emerald-500" />
                                <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">Clinical & Medical History</h4>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs">
                                <div class="sm:col-span-2">
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Diagnosed Condition / Chronic Illness</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200 text-sm">
                                        {{ $selectedResident->health_condition ?: 'None reported (Healthy)' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Blood Type</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->blood_type ? 'Type ' . $selectedResident->blood_type : 'Not recorded' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Nutritional Classification</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->nutritional_classification ?: 'Normal' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Height & Weight</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->height ? $selectedResident->height . ' cm' : '—' }} / {{ $selectedResident->weight ? $selectedResident->weight . ' kg' : '—' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Body Mass Index (BMI)</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        @if($this->bmi)
                                            {{ $this->bmi['value'] }} ({{ $this->bmi['label'] }})
                                        @else
                                            Not enough data
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Vulnerable Sector</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->vulnerable_sector ?: 'None' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Social Welfare Availed</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->social_welfare_availed ?: 'None' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Immunization Tracker -->
                        <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                            <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                                <flux:icon name="shield-check" class="size-4 text-teal-500" />
                                <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">Vaccination & Immunization Record</h4>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs">
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">COVID Vaccine Status</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        @if($selectedResident->fully_vaccinated === 'Y') Fully Vaccinated
                                        @elseif($selectedResident->partially_vaccinated === 'Y') Partially Vaccinated
                                        @else Unvaccinated @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Vaccine Brand</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->covid_brand ?: '—' }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Dose 1 Administration</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->covid_dose_1_date ? date('M d, Y', strtotime($selectedResident->covid_dose_1_date)) : '—' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Dose 2 Administration</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->covid_dose_2_date ? date('M d, Y', strtotime($selectedResident->covid_dose_2_date)) : '—' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Booster Received?</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->has_booster === 'Y' ? 'Yes' : ($selectedResident->has_booster === 'N' ? 'No' : '—') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Booster Date</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->booster_date ? date('M d, Y', strtotime($selectedResident->booster_date)) : '—' }}
                                    </span>
                                </div>
                                <div class="sm:col-span-2">
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Booster Brand</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->booster_brand ?: '—' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- PhilHealth & Insurance -->
                        <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                            <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                                <flux:icon name="identification" class="size-4 text-blue-500" />
                                <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">PhilHealth & Health Insurance</h4>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Enrollment Status</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->has_philhealth === 'Y' ? 'Enrolled / Active' : 'Not Enrolled' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">PhilHealth Identification No.</span>
                                    <span class="font-mono font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->philhealth_id ?: '—' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Membership Type</span>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                        {{ $selectedResident->philhealth_membership_type ?: 'Not specified' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tab 2: Personal & Demographics -->
                @if($cardActiveTab === 'profile')
                    <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                        <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                            <flux:icon name="user" class="size-4 text-sky-500" />
                            <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">Personal Identity & Demographics</h4>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs">
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Full Legal Name</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->full_name }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Sex</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->sex ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Birthdate & Age</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                    {{ $selectedResident->birthdate ? date('M d, Y', strtotime($selectedResident->birthdate)) : '—' }}
                                    @if($selectedResident->age) ({{ $selectedResident->age }} yrs old) @endif
                                </span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Place of Birth</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->place_of_birth ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Civil Status</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->civil_status ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Citizenship</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->citizenship ?? 'Filipino' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Religion</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->religion ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Mobile Number</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->mobile_number ?? '—' }}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Email Address</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->email_address ?: ($selectedResident->user?->email ?? '—') }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Occupation</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->occupation ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Work Status</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->work_status ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tab 3: Household & Living Condition -->
                @if($cardActiveTab === 'household')
                    <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                        <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                            <flux:icon name="home" class="size-4 text-amber-500" />
                            <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">Household & Environmental Health</h4>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs">
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Household Number</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->household?->household_no ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Purok</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">Purok {{ $selectedResident->household?->purok_no ?? '—' }}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Address / Street</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->household?->address ?? 'Barangay Sambog, Corella' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Role in Household</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->relationship_to_head ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">House Ownership</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                    @if($selectedResident->is_house_owner === 'Y') Owned
                                    @elseif($selectedResident->is_renter === 'Y') Renting
                                    @else — @endif
                                </span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Water Source</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->water_source ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Sanitary Toilet</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->sanitary_toilet ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Waste Management</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedResident->waste_management ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Blind Drainage</span>
                                <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                    {{ $selectedResident->has_blind_drainage === 'Y' ? 'Yes' : ($selectedResident->has_blind_drainage === 'N' ? 'No' : '—') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Modal Actions Footer -->
                <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <a href="{{ route('health.edit') }}" 
                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300">
                        <flux:icon name="pencil-square" class="size-4" />
                        Go to Health Records Editor
                    </a>

                    <div class="flex items-center gap-2">
                        <flux:button variant="ghost" wire:click="closeResidentHealthCard">Close</flux:button>
                    </div>
                </div>
            </div>
        @endif
    </flux:modal>
</div>
