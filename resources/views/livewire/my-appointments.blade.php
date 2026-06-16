<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-4 flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">My Document Requests</flux:heading>
            <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">View your booked pickup slots and status.</flux:text>
        </div>
    </div>

    @if($appointments->isEmpty())
        <div class="text-center py-12 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800 p-8">
            <svg class="mx-auto text-zinc-350 dark:text-zinc-700 mb-4" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">You have not requested any documents yet.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                        <th class="py-3 px-4">Scheduled Date</th>
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
                                @if($apt->appointment_date)
                                    {{ $apt->appointment_date->format('F d, Y') }}
                                @elseif($apt->status === 'pending')
                                    <span class="text-xs text-zinc-500 dark:text-zinc-450 font-semibold bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">Pending Review</span>
                                @elseif($apt->status === 'approved-pending')
                                    <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold bg-amber-50 dark:bg-amber-950/20 px-2 py-0.5 rounded">Pending Kapitan Signature</span>
                                @elseif($apt->status === 'cancelled')
                                    <span class="text-xs text-red-500 dark:text-red-400 font-semibold bg-red-50 dark:bg-red-950/20 px-2 py-0.5 rounded">Cancelled</span>
                                @else
                                    <span class="text-xs text-zinc-400 dark:text-zinc-500 font-semibold">&mdash;</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($apt->status === 'cancelled')
                                    <span class="text-xs text-zinc-400 dark:text-zinc-500 font-medium">N/A</span>
                                @else
                                    {{ $apt->appointment_time ?? 'To be scheduled' }}
                                @endif
                            </td>
                            <td class="py-3 px-4 max-w-xs truncate" title="{{ $apt->purpose }}">
                                {{ $apt->purpose }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($apt->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 border border-zinc-200 dark:bg-zinc-850/40 dark:text-zinc-300 dark:border-zinc-700/50">
                                        Pending Review
                                    </span>
                                @elseif($apt->status === 'approved-pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/30 dark:text-amber-400 dark:border-amber-900/50">
                                        Approved-Pending
                                    </span>
                                @elseif($apt->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-400 dark:border-emerald-900/50">
                                        Approved (Ready)
                                    </span>
                                @elseif($apt->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/30 dark:text-blue-400 dark:border-blue-900/50">
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50">
                                        Cancelled
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                @if(in_array($apt->status, ['pending', 'approved-pending']))
                                    <button 
                                        wire:click="cancel({{ $apt->id }})"
                                        wire:confirm="Are you sure you want to cancel this request?"
                                        class="text-xs text-red-500 hover:text-red-700 font-medium transition cursor-pointer"
                                    >
                                        Cancel Request
                                    </button>
                                @else
                                    <span class="text-xs text-zinc-400 dark:text-zinc-600">-</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Sub-row: Cancellation Reason or Admin Notes --}}
                        @if($apt->status === 'cancelled' && $apt->admin_notes)
                            <tr class="bg-red-50/50 dark:bg-red-950/10 border-t-0">
                                <td colspan="5" class="px-4 py-2">
                                    <div class="flex items-start gap-2">
                                        <span class="shrink-0 mt-0.5 inline-flex items-center justify-center w-4 h-4 rounded-full bg-red-100 dark:bg-red-900/40">
                                            <svg class="w-2.5 h-2.5 text-red-500 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </span>
                                        <div>
                                            <span class="text-[10px] font-bold uppercase tracking-wide text-red-600 dark:text-red-400">Reason for Cancellation</span>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-0.5">{{ $apt->admin_notes }}</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @elseif(in_array($apt->status, ['approved', 'completed']) && $apt->admin_notes)
                            <tr class="bg-emerald-50/50 dark:bg-emerald-950/10 border-t-0">
                                <td colspan="5" class="px-4 py-2">
                                    <div class="flex items-start gap-2">
                                        <span class="shrink-0 mt-0.5 inline-flex items-center justify-center w-4 h-4 rounded-full bg-emerald-100 dark:bg-emerald-900/40">
                                            <svg class="w-2.5 h-2.5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </span>
                                        <div>
                                            <span class="text-[10px] font-bold uppercase tracking-wide text-emerald-600 dark:text-emerald-400">Admin Notes</span>
                                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-0.5">{{ $apt->admin_notes }}</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif

                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
