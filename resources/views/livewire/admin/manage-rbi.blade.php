<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-red-50 dark:bg-red-950/20 text-[#f53003] rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <flux:text variant="subtle" class="text-xs font-semibold uppercase text-zinc-500">Total Population</flux:text>
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
                <flux:text variant="subtle" class="text-xs font-semibold uppercase text-zinc-500">Registered Voters</flux:text>
                <flux:heading size="xl" class="font-bold text-zinc-900 dark:text-white">{{ number_format($stats['voters']) }}</flux:heading>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-amber-50 dark:bg-amber-950/20 text-amber-500 rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <flux:text variant="subtle" class="text-xs font-semibold uppercase text-zinc-500">Senior Citizens</flux:text>
                <flux:heading size="xl" class="font-bold text-zinc-900 dark:text-white">{{ number_format($stats['seniors']) }}</flux:heading>
            </div>
        </div>
    </div>

    <!-- RBI Registry Main Card -->
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
        <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Registry of Barangay Inhabitants (RBI)</flux:heading>
                <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Search and filter dynamic resident registries parsed from the RBI workbook.</flux:text>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Search name, email, household..."
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm"
                />
                
                <select 
                    wire:model.live="purokFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm"
                >
                    <option value="">All Puroks</option>
                    @for($i=1; $i<=8; $i++)
                        <option value="{{ $i }}">Purok {{ $i }}</option>
                    @endfor
                </select>

                <select 
                    wire:model.live="voterFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm"
                >
                    <option value="">All Voters</option>
                    <option value="registered">Registered</option>
                    <option value="unregistered">Not Registered</option>
                </select>
            </div>
        </div>

        @if($residents->isEmpty())
            <div class="text-center py-8 text-zinc-400 dark:text-zinc-500">
                <svg class="mx-auto h-12 w-12 text-zinc-300 dark:text-zinc-700 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-sm">No residents found matching the search criteria.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                            <th class="py-3 px-4">Resident</th>
                            <th class="py-3 px-4">Purok</th>
                            <th class="py-3 px-4">Household No.</th>
                            <th class="py-3 px-4">Relationship</th>
                            <th class="py-3 px-4 text-center">Age / Sex</th>
                            <th class="py-3 px-4 text-center">Voter?</th>
                            <th class="py-3 px-4">Email</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($residents as $res)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                <td class="py-3 px-4">
                                    <span class="text-zinc-900 dark:text-white font-medium">{{ $res->full_name }}</span>
                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400">Pop. No: {{ $res->population_no ?? 'N/A' }}</div>
                                </td>
                                <td class="py-3 px-4 text-zinc-900 dark:text-white">
                                    Purok {{ $res->household->purok_no ?? 'N/A' }}
                                </td>
                                <td class="py-3 px-4 font-mono text-xs">
                                    {{ $res->household->household_no ?? 'N/A' }}
                                </td>
                                <td class="py-3 px-4 capitalize text-xs">
                                    {{ strtolower($res->relationship_to_head ?? 'Member') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="text-zinc-900 dark:text-white font-medium">{{ $res->age ?? 'N/A' }}</span>
                                    <span class="text-zinc-400 dark:text-zinc-600 text-xs">/ {{ $res->sex }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if(strtoupper($res->registered_national_voter ?? '') === 'Y' || strtoupper($res->resident_voter ?? '') === 'Y')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-900/50">
                                            Yes
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-zinc-50 text-zinc-500 border border-zinc-200 dark:bg-zinc-800/40 dark:text-zinc-400 dark:border-zinc-700/50">
                                            No
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-xs">
                                    {{ $res->email_address ?? 'N/A' }}
                                </td>
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
