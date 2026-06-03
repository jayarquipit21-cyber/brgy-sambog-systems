<div>
    <!-- Age-Dynamic Health Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-zinc-500">All Health Cases</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['total_cases'] }}</flux:heading>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm border-l-4 border-l-blue-500">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-blue-500">Pediatric (0-12)</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['pediatric_cases'] }}</flux:heading>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm border-l-4 border-l-emerald-500">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-emerald-500">Youth (13-24)</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['youth_cases'] }}</flux:heading>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm border-l-4 border-l-amber-500">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-amber-500">Adult (25-59)</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['adult_cases'] }}</flux:heading>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm border-l-4 border-l-red-500">
            <flux:text variant="subtle" class="text-[10px] font-semibold uppercase text-red-500">Senior (60+)</flux:text>
            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['senior_cases'] }}</flux:heading>
        </div>
    </div>

    <!-- Main Health Registry Card -->
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
        <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Barangay Health Registry</flux:heading>
                <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Strictly health-related records with dynamic age group analytics. Non-health variables are secured at query level.</flux:text>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Search name or concern..."
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
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
                    <option value="">All Health Concerns</option>
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
                <p class="text-sm">No health concerns found matching the filters.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                            <th class="py-3 px-4">Patient Profile</th>
                            <th class="py-3 px-4 text-center">Age / Sex</th>
                            <th class="py-3 px-4">Dynamic Age Group</th>
                            <th class="py-3 px-4">Health Condition</th>
                            <th class="py-3 px-4">Nutritional Status</th>
                            <th class="py-3 px-4">Vaccine Status</th>
                            <th class="py-3 px-4">Vulnerable Sector</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($healthRecords as $rec)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                <td class="py-3 px-4 font-semibold text-zinc-900 dark:text-white">
                                    {{ $rec->first_name }} {{ $rec->last_name }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="text-zinc-900 dark:text-white font-medium">{{ $rec->age ?? 'N/A' }}</span>
                                    <span class="text-zinc-400 dark:text-zinc-600 text-xs">/ {{ $rec->sex }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($rec->age <= 12)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/20 dark:text-blue-400 dark:border-blue-900/50">
                                            Pediatric (0-12)
                                        </span>
                                    @elseif($rec->age <= 24)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-900/50">
                                            Youth (13-24)
                                        </span>
                                    @elseif($rec->age <= 59)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/20 dark:text-amber-400 dark:border-amber-900/50">
                                            Adult (25-59)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-red-50 text-red-800 border border-red-200 dark:bg-red-950/20 dark:text-red-400 dark:border-red-900/50">
                                            Senior (60+)
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-zinc-900 dark:text-white font-medium">
                                    {{ $rec->health_condition }}
                                </td>
                                <td class="py-3 px-4 text-xs">
                                    {{ $rec->nutritional_classification ?: 'Normal' }}
                                </td>
                                <td class="py-3 px-4 text-xs">
                                    @if($rec->fully_vaccinated === 'Y')
                                        <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Fully Vaccinated</span>
                                    @elseif($rec->partially_vaccinated === 'Y')
                                        <span class="text-amber-600 dark:text-amber-400">Partially Vaccinated</span>
                                    @else
                                        <span class="text-red-500">Unvaccinated</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-xs italic">
                                    {{ $rec->vulnerable_sector ?: 'None' }}
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
