<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-4 flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">My Appointments</flux:heading>
            <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">View your booked pickup slots and status.</flux:text>
        </div>
    </div>

    @if($appointments->isEmpty())
        <div class="text-center py-12 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800 p-8">
            <svg class="mx-auto text-zinc-350 dark:text-zinc-700 mb-4" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">You have not booked any appointments yet.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Time Slot</th>
                        <th class="py-3 px-4">Purpose</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($appointments as $apt)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="py-3 px-4 font-medium text-zinc-900 dark:text-white">
                                {{ $apt->appointment_date->format('F d, Y') }}
                            </td>
                            <td class="py-3 px-4">{{ $apt->appointment_time }}</td>
                            <td class="py-3 px-4 max-w-xs truncate" title="{{ $apt->purpose }}">
                                {{ $apt->purpose }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($apt->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/30 dark:text-amber-400 dark:border-amber-900/50">
                                        Pending
                                    </span>
                                @elseif($apt->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-400 dark:border-emerald-900/50">
                                        Approved
                                    </span>
                                @elseif($apt->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/30 dark:text-blue-400 dark:border-blue-900/50">
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 border border-zinc-200 dark:bg-zinc-800/40 dark:text-zinc-400 dark:border-zinc-700/50">
                                        Cancelled
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                @if($apt->status === 'pending')
                                    <button 
                                        wire:click="cancel({{ $apt->id }})"
                                        wire:confirm="Are you sure you want to cancel this appointment?"
                                        class="text-xs text-red-500 hover:text-red-700 font-medium transition cursor-pointer"
                                    >
                                        Cancel Booking
                                    </button>
                                @else
                                    <span class="text-xs text-zinc-400 dark:text-zinc-600">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
