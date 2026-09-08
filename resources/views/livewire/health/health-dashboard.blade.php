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
                    placeholder="Search name, condition, sector, blood type..."
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                />

                <select 
                    wire:model.live="nameLetter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                >
                    <option value="">First Name (A–Z)</option>
                    @foreach(range('A', 'Z') as $letter)
                        <option value="{{ $letter }}">First Name Starts with {{ $letter }}</option>
                    @endforeach
                </select>

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
                    <option value="">All Residents</option>
                    <option value="has_condition">With Health Condition</option>
                    <option value="none">No Health Condition</option>
                    <option value="Hypertension">Hypertension</option>
                    <option value="Diabetes">Diabetes</option>
                    <option value="Asthma">Asthma</option>
                    <option value="Arthritis">Arthritis</option>
                    <option value="Heart">Heart Conditions</option>
                    <option value="SAM">Malnutrition (SAM/MAM)</option>
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
                                <td class="py-3 px-4 font-semibold text-zinc-900 dark:text-white whitespace-nowrap">
                                    {{ $rec->last_name }}, {{ $rec->first_name }}
                                    @if($rec->middle_name) {{ substr($rec->middle_name, 0, 1) }}.@endif
                                    @if($rec->extension) {{ $rec->extension }}@endif
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
</div>
