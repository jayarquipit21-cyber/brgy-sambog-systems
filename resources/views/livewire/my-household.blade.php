<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    @if(!$resident)
        <div class="text-center py-8 text-zinc-400 dark:text-zinc-500">
            <svg class="mx-auto h-12 w-12 text-zinc-300 dark:text-zinc-700 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="text-sm">We couldn't find a resident profile linked to your user account.</p>
            <flux:text variant="subtle" class="text-xs mt-1 text-zinc-500 dark:text-zinc-400">Please contact the Barangay Admin to link your profile.</flux:text>
        </div>
    @elseif(!$household)
        <div class="text-center py-8 text-zinc-400 dark:text-zinc-500">
            <svg class="mx-auto h-12 w-12 text-zinc-300 dark:text-zinc-700 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <p class="text-sm">Your resident profile is not linked to a Household registry yet.</p>
            <flux:text variant="subtle" class="text-xs mt-1 text-zinc-500 dark:text-zinc-400">Please contact the Barangay Admin to update your Household No.</flux:text>
        </div>
    @else
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between border-b border-zinc-100 dark:divide-zinc-800 dark:border-zinc-800 pb-4">
            <div>
                <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">My Household Registry</flux:heading>
                <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">View official members and details registered for your household.</flux:text>
            </div>
            <div class="mt-4 md:mt-0 flex flex-wrap gap-4 text-sm text-zinc-600 dark:text-zinc-400">
                <div class="bg-zinc-50 dark:bg-zinc-800 px-3 py-1.5 rounded-lg border border-zinc-100 dark:border-zinc-800">
                    <span class="font-semibold text-zinc-500 dark:text-zinc-400">Household No:</span>
                    <span class="text-zinc-900 dark:text-white font-medium">{{ $household->household_no }}</span>
                </div>
                <div class="bg-zinc-50 dark:bg-zinc-800 px-3 py-1.5 rounded-lg border border-zinc-100 dark:border-zinc-800">
                    <span class="font-semibold text-zinc-500 dark:text-zinc-400">Purok:</span>
                    <span class="text-zinc-900 dark:text-white font-medium">{{ $household->purok_no }}</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                        <th class="py-3 px-4">Full Name</th>
                        <th class="py-3 px-4">Relationship</th>
                        <th class="py-3 px-4 text-center">Sex</th>
                        <th class="py-3 px-4 text-center">Age</th>
                        <th class="py-3 px-4">Birthdate</th>
                        <th class="py-3 px-4">Education Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($members as $member)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition {{ $member->id === $resident->id ? 'bg-[#f53003]/5 dark:bg-[#f53003]/10 font-medium' : '' }}">
                            <td class="py-3 px-4 text-zinc-900 dark:text-white">
                                {{ $member->full_name }}
                                @if($member->id === $resident->id)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-[#f53003] text-white">
                                        You
                                    </span>
                                @endif
                                @if(in_array(strtolower($member->relationship_to_head ?? ''), ['hh', 'household head']))
                                    <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-zinc-900 dark:bg-zinc-750 text-white">
                                        Head
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 capitalize">
                                {{ strtolower($member->relationship_to_head ?? 'Member') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                {{ $member->sex }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                {{ $member->age ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-4">
                                {{ $member->birthdate ? date('M d, Y', strtotime($member->birthdate)) : 'N/A' }}
                            </td>
                            <td class="py-3 px-4 truncate max-w-[200px]" title="{{ $member->educational_status }}">
                                {{ $member->educational_status ?? 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
