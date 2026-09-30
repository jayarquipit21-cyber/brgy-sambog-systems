<div class="space-y-8">
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-2xl p-4 sm:p-5 border border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row gap-3 items-center justify-between">
        <div class="w-full sm:w-auto flex-1">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search purpose, notes, OR#, code..."
                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-xs"
            />
        </div>
        <div class="w-full sm:w-auto flex gap-2">
            <select 
                wire:model.live="statusFilter"
                class="w-full sm:w-auto rounded-xl border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-xs font-medium"
            >
                <option value="">All Statuses</option>
                <option value="pending">Pending Review</option>
                <option value="approved-pending">Pending Signature</option>
                <option value="approved">Approved / Ready</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    @if($type === '' || $type === 'document')
    <!-- Dedicated Table 1: Document Requests -->
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-2xl p-6 border border-zinc-200 dark:border-zinc-800 card-glow-admin">
        <div class="mb-6 flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl">
                    <flux:icon name="document-text" class="size-5" />
                </div>
                <div>
                    <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-extrabold font-outfit">My Document Requests</flux:heading>
                    <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">View requested official barangay certificates and pickup slots.</flux:text>
                </div>
            </div>
            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-1 rounded-full">{{ $documentRequests->count() }} Requests</span>
        </div>

        @if($documentRequests->isEmpty())
            <div class="text-center py-8 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800 p-6">
                <flux:icon name="document-text" class="size-10 text-zinc-300 dark:text-zinc-700 mx-auto mb-2" />
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">No document requests found.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300 border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-[10px] font-bold uppercase tracking-widest">
                            <th class="py-3 px-4">Scheduled Date</th>
                            <th class="py-3 px-4">Time Slot</th>
                            <th class="py-3 px-4">Requested Document / Purpose</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @foreach($documentRequests as $apt)
                            <tr class="odd:bg-zinc-50/40 hover:bg-emerald-50/30 dark:odd:bg-zinc-900/10 dark:hover:bg-emerald-950/10 transition-colors">
                                <td class="py-4 px-4 font-bold text-zinc-900 dark:text-white font-outfit">
                                    @if($apt->appointment_date)
                                        {{ $apt->appointment_date->format('F d, Y') }}
                                    @elseif($apt->status === 'pending')
                                        <span class="text-[10px] text-zinc-500 dark:text-zinc-400 font-bold bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-lg">Pending Review</span>
                                    @elseif($apt->status === 'approved-pending')
                                        <span class="text-[10px] text-amber-700 dark:text-amber-400 font-bold bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-lg">Pending Signature</span>
                                    @elseif($apt->status === 'cancelled')
                                        <span class="text-[10px] text-red-600 dark:text-red-400 font-bold bg-red-500/10 border border-red-500/20 px-2.5 py-1 rounded-lg">Cancelled</span>
                                    @else
                                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500 font-bold">&mdash;</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 font-semibold text-zinc-600 dark:text-zinc-300">
                                    @if($apt->status === 'cancelled')
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-medium">N/A</span>
                                    @else
                                        {{ $apt->appointment_time ?? 'To be scheduled' }}
                                    @endif
                                </td>
                                <td class="py-4 px-4 max-w-xs truncate font-medium text-zinc-800 dark:text-zinc-200" title="{{ $apt->purpose }}">
                                    {{ $apt->purpose }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($apt->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-800 border border-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700">
                                            Pending Review
                                        </span>
                                    @elseif($apt->status === 'approved-pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/30 dark:text-amber-400 dark:border-amber-900/50">
                                            Approved-Pending
                                        </span>
                                    @elseif($apt->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-450 dark:border-emerald-900/50">
                                            Approved (Ready)
                                        </span>
                                    @elseif($apt->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/30 dark:text-blue-450 dark:border-blue-900/50">
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-right">
                                    @if(in_array($apt->status, ['pending', 'approved-pending']))
                                        <button 
                                            wire:click="cancel({{ $apt->id }})"
                                            wire:confirm="Are you sure you want to cancel this request?"
                                            class="px-3 py-1.5 rounded-lg border border-red-200 bg-red-50/50 hover:bg-red-50 hover:text-red-700 hover:border-red-300 text-red-650 dark:border-red-950/50 dark:bg-red-950/20 dark:text-red-400 dark:hover:bg-red-950/40 text-xs font-bold transition-all focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer"
                                        >
                                            Cancel Request
                                        </button>
                                    @elseif($apt->status === 'cancelled')
                                        <button 
                                            wire:click="deleteCancelled({{ $apt->id }})"
                                            wire:confirm="Are you sure you want to delete this cancelled request?"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-900/50 bg-red-50/60 dark:bg-red-950/30 hover:bg-red-100 dark:hover:bg-red-950/60 text-red-700 dark:text-red-400 text-xs font-bold transition-all focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer"
                                            title="Delete Cancelled Request"
                                        >
                                            <flux:icon name="trash" class="size-3.5" />
                                            <span>Delete</span>
                                        </button>
                                    @else
                                        <span class="text-xs text-zinc-400 dark:text-zinc-600 font-semibold">-</span>
                                    @endif
                                </td>
                            </tr>

                            @if($apt->admin_notes)
                                <tr class="bg-zinc-50/30 dark:bg-zinc-800/10 border-t-0">
                                    <td colspan="5" class="px-4 py-2.5">
                                        <div class="text-xs text-zinc-600 dark:text-zinc-400">
                                            <strong class="text-zinc-800 dark:text-white">Admin Notes:</strong> {{ $apt->admin_notes }}
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
    @endif

    @if($type === '' || $type === 'rental')
    <!-- Dedicated Table 2: Facility & Equipment Rentals -->
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-2xl p-6 border border-zinc-200 dark:border-zinc-800 card-glow-household">
        <div class="mb-6 flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl">
                    <flux:icon name="building-office" class="size-5" />
                </div>
                <div>
                    <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-extrabold font-outfit">My Facility & Equipment Rentals</flux:heading>
                    <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">View booked barangay venues, chairs, tables, and equipment rentals.</flux:text>
                </div>
            </div>
            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-full">{{ $rentalBookings->count() }} Rentals</span>
        </div>

        @if($rentalBookings->isEmpty())
            <div class="text-center py-8 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800 p-6">
                <flux:icon name="building-office" class="size-10 text-zinc-300 dark:text-zinc-700 mx-auto mb-2" />
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">No rental service bookings found.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300 border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-[10px] font-bold uppercase tracking-widest">
                            <th class="py-3 px-4">Reserved Date</th>
                            <th class="py-3 px-4">Time Slot</th>
                            <th class="py-3 px-4">Rental Facility / Item</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @foreach($rentalBookings as $apt)
                            @php
                                $displayRentalName = str_replace('[Rental Service] ', '', $apt->purpose);
                            @endphp
                            <tr class="odd:bg-zinc-50/40 hover:bg-amber-50/30 dark:odd:bg-zinc-900/10 dark:hover:bg-amber-950/10 transition-colors">
                                <td class="py-4 px-4 font-bold text-zinc-900 dark:text-white font-outfit">
                                    @if($apt->appointment_date)
                                        {{ $apt->appointment_date->format('F d, Y') }}
                                    @elseif($apt->status === 'pending')
                                        <span class="text-[10px] text-zinc-500 dark:text-zinc-400 font-bold bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-lg">Pending Review</span>
                                    @elseif($apt->status === 'approved-pending')
                                        <span class="text-[10px] text-amber-700 dark:text-amber-400 font-bold bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-lg">Pending Kapitan Approval</span>
                                    @elseif($apt->status === 'cancelled')
                                        <span class="text-[10px] text-red-600 dark:text-red-400 font-bold bg-red-500/10 border border-red-500/20 px-2.5 py-1 rounded-lg">Cancelled</span>
                                    @else
                                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500 font-bold">&mdash;</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 font-semibold text-zinc-600 dark:text-zinc-300">
                                    @if($apt->status === 'cancelled')
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-medium">N/A</span>
                                    @else
                                        {{ $apt->appointment_time ?? 'To be scheduled' }}
                                    @endif
                                </td>
                                <td class="py-4 px-4 max-w-xs truncate font-bold text-amber-700 dark:text-amber-400" title="{{ $displayRentalName }}">
                                    {{ $displayRentalName }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($apt->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-800 border border-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700">
                                            Pending Review
                                        </span>
                                    @elseif($apt->status === 'approved-pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/30 dark:text-amber-400 dark:border-amber-900/50">
                                            Approved-Pending
                                        </span>
                                    @elseif($apt->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-450 dark:border-emerald-900/50">
                                            Approved (Reserved)
                                        </span>
                                    @elseif($apt->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/30 dark:text-blue-450 dark:border-blue-900/50">
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-right">
                                    @if(in_array($apt->status, ['pending', 'approved-pending']))
                                        <button 
                                            wire:click="cancel({{ $apt->id }})"
                                            wire:confirm="Are you sure you want to cancel this rental booking?"
                                            class="px-3 py-1.5 rounded-lg border border-red-200 bg-red-50/50 hover:bg-red-50 hover:text-red-700 hover:border-red-300 text-red-650 dark:border-red-950/50 dark:bg-red-950/20 dark:text-red-400 dark:hover:bg-red-950/40 text-xs font-bold transition-all focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer"
                                        >
                                            Cancel Booking
                                        </button>
                                    @elseif($apt->status === 'cancelled')
                                        <button 
                                            wire:click="deleteCancelled({{ $apt->id }})"
                                            wire:confirm="Are you sure you want to delete this cancelled rental booking?"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-900/50 bg-red-50/60 dark:bg-red-950/30 hover:bg-red-100 dark:hover:bg-red-950/60 text-red-700 dark:text-red-400 text-xs font-bold transition-all focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer"
                                            title="Delete Cancelled Request"
                                        >
                                            <flux:icon name="trash" class="size-3.5" />
                                            <span>Delete</span>
                                        </button>
                                    @else
                                        <span class="text-xs text-zinc-400 dark:text-zinc-600 font-semibold">-</span>
                                    @endif
                                </td>
                            </tr>

                            @if($apt->admin_notes)
                                <tr class="bg-zinc-50/30 dark:bg-zinc-800/10 border-t-0">
                                    <td colspan="5" class="px-4 py-2.5">
                                        <div class="text-xs text-zinc-600 dark:text-zinc-400">
                                            <strong class="text-zinc-800 dark:text-white">Admin Notes:</strong> {{ $apt->admin_notes }}
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
    @endif
</div>
