<div class="space-y-8">
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Appointments & Rentals Registry</flux:heading>
                <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Review and manage all resident document requests and rental service bookings in dedicated registries.</flux:text>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search resident, purpose, code, OR#..."
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                />
                <select 
                    wire:model.live="typeFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                >
                    <option value="">All Registries</option>
                    <option value="document">Document Requests</option>
                    <option value="rental">Rental Services</option>
                </select>
                <select 
                    wire:model.live="statusFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                >
                    <option value="">All Statuses</option>
                    <option value="pending">Pending Review</option>
                    <option value="approved-pending">Approved-Pending</option>
                    <option value="approved">Approved</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <livewire:admin.manage-date-closures />
        </div>
    </div>

    @if($typeFilter === '' || $typeFilter === 'document')
    <!-- Dedicated Registry 1: Document Requests -->
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
        <div class="mb-4 flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl">
                    <flux:icon name="document-text" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Document Requests Registry</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Barangay clearance, indigency, residency, and official certificate requests</p>
                </div>
            </div>
            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-1 rounded-full">{{ $documentRequests->count() }} Requests</span>
        </div>

        @if($documentRequests->isEmpty())
            <div class="text-center py-8 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl border border-dashed border-zinc-200 dark:border-zinc-800 p-6">
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">No document requests found matching the current filter.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                            <th class="py-3 px-4">Resident</th>
                            <th class="py-3 px-4">Scheduled Slot</th>
                            <th class="py-3 px-4">Requested Document / Purpose</th>
                            <th class="py-3 px-4">Fee & Payment</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($documentRequests as $apt)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                <td class="py-3 px-4 text-zinc-900 dark:text-white font-medium">
                                    {{ $apt->user?->name ?? 'N/A' }}
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $apt->user?->email ?? '' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($apt->appointment_date)
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $apt->appointment_date->format('M d, Y') }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $apt->appointment_time }}</div>
                                    @elseif($apt->status === 'pending')
                                        <span class="text-xs text-zinc-500 dark:text-zinc-450 font-semibold bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">Pending Review</span>
                                    @elseif($apt->status === 'approved-pending')
                                        <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold bg-amber-50 dark:bg-amber-950/20 px-2 py-0.5 rounded">Pending Kapitan Signature</span>
                                    @elseif($apt->status === 'cancelled')
                                        <span class="text-xs text-red-500 dark:text-red-400 font-semibold bg-red-50 dark:bg-red-950/20 px-2 py-0.5 rounded">Cancelled</span>
                                    @else
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-semibold">—</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 max-w-sm whitespace-normal break-words font-medium">
                                    {{ $apt->purpose }}
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @php
                                        $txn = $apt->transaction;
                                        $amt = $txn ? $txn->total_amount : 0.00;
                                        $payStatus = $txn ? $txn->payment_status : 'pending';
                                    @endphp
                                    <div class="font-bold text-zinc-900 dark:text-white text-xs">
                                        @if($amt == 0)
                                            <span class="text-emerald-600 dark:text-emerald-400 font-bold">FREE</span>
                                        @else
                                            ₱{{ number_format($amt, 2) }}
                                        @endif
                                    </div>
                                    <div class="mt-0.5">
                                        @if($payStatus === 'paid')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-extrabold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300">
                                                Paid @if($txn?->official_receipt_number)({{ $txn->official_receipt_number }})@endif
                                            </span>
                                        @elseif($payStatus === 'waived')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                                Waived (Exempt)
                                            </span>
                                        @else
                                            <button 
                                                wire:click="startPayment({{ $apt->id }})"
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-extrabold bg-amber-100 hover:bg-amber-200 dark:bg-amber-900/40 dark:hover:bg-amber-900/60 text-amber-900 dark:text-amber-300 border border-amber-300/60 transition cursor-pointer"
                                                title="Record Payment"
                                            >
                                                <span>Unpaid</span>
                                                <flux:icon name="banknotes" class="size-2.5" />
                                            </button>
                                        @endif
                                    </div>
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
                                            Approved
                                        </span>
                                    @elseif($apt->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/30 dark:text-blue-400 dark:border-blue-900/50">
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-800 border border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    @if($apt->status === 'pending')
                                        <button 
                                            wire:click="markApprovedPending({{ $apt->id }})"
                                            class="text-xs text-amber-600 hover:text-amber-800 font-semibold cursor-pointer"
                                        >
                                            Send for Signature
                                        </button>
                                        <button 
                                            wire:click="startReject({{ $apt->id }})"
                                            class="text-xs text-red-500 hover:text-red-700 font-semibold cursor-pointer ml-2"
                                        >
                                            Reject
                                        </button>
                                    @elseif($apt->status === 'approved-pending')
                                        <button 
                                            wire:click="startApprove({{ $apt->id }})"
                                            class="text-xs text-emerald-500 hover:text-emerald-700 font-semibold cursor-pointer"
                                        >
                                            Approve & Schedule
                                        </button>
                                        <button 
                                            wire:click="startReject({{ $apt->id }})"
                                            class="text-xs text-red-500 hover:text-red-700 font-semibold cursor-pointer ml-2"
                                        >
                                            Reject
                                        </button>
                                    @elseif($apt->status === 'approved')
                                        <button 
                                            wire:click="complete({{ $apt->id }})"
                                            wire:loading.attr="disabled"
                                            class="text-xs text-blue-500 hover:text-blue-700 font-semibold cursor-pointer"
                                        >
                                            Mark Collected
                                        </button>
                                    @else
                                        <span class="text-xs text-zinc-400 dark:text-zinc-600">-</span>
                                    @endif
                                    @if(!in_array($apt->status, ['pending', 'approved-pending', 'approved']))
                                        <button 
                                            wire:click="delete({{ $apt->id }})"
                                            class="text-xs text-red-500 hover:text-red-700 font-semibold ml-2"
                                        >
                                            Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @if($apt->admin_notes)
                                <tr class="bg-zinc-50/50 dark:bg-zinc-800/20 border-t-0">
                                    <td colspan="5" class="px-4 py-2 text-xs text-zinc-600 dark:text-zinc-400">
                                        <strong class="text-zinc-800 dark:text-white">Admin Notes:</strong> {{ $apt->admin_notes }}
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

    @if($typeFilter === '' || $typeFilter === 'rental')
    <!-- Dedicated Registry 2: Facility & Equipment Rentals -->
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
        <div class="mb-4 flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl">
                    <flux:icon name="building-office" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Facility & Equipment Rentals Registry</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Barangay venue, covered court, chairs, tables, and sound system rental bookings</p>
                </div>
            </div>
            <span class="text-xs font-bold text-amber-700 dark:text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-full">{{ $rentalBookings->count() }} Rentals</span>
        </div>

        @if($rentalBookings->isEmpty())
            <div class="text-center py-8 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl border border-dashed border-zinc-200 dark:border-zinc-800 p-6">
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">No rental bookings found matching the current filter.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                            <th class="py-3 px-4">Resident</th>
                            <th class="py-3 px-4">Reserved Slot</th>
                            <th class="py-3 px-4">Rental Item / Venue</th>
                            <th class="py-3 px-4">Fee & Payment</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($rentalBookings as $apt)
                            @php
                                $displayRentalName = str_replace('[Rental Service] ', '', $apt->purpose);
                            @endphp
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                <td class="py-3 px-4 text-zinc-900 dark:text-white font-medium">
                                    {{ $apt->user?->name ?? 'N/A' }}
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $apt->user?->email ?? '' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($apt->appointment_date)
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $apt->appointment_date->format('M d, Y') }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $apt->appointment_time }}</div>
                                    @elseif($apt->status === 'pending')
                                        <span class="text-xs text-zinc-500 dark:text-zinc-450 font-semibold bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">Pending Review</span>
                                    @elseif($apt->status === 'approved-pending')
                                        <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold bg-amber-50 dark:bg-amber-950/20 px-2 py-0.5 rounded">Pending Approval</span>
                                    @elseif($apt->status === 'cancelled')
                                        <span class="text-xs text-red-500 dark:text-red-400 font-semibold bg-red-50 dark:bg-red-950/20 px-2 py-0.5 rounded">Cancelled</span>
                                    @else
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-semibold">—</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 max-w-sm whitespace-normal break-words font-bold text-amber-700 dark:text-amber-400">
                                    {{ $displayRentalName }}
                                    @if($apt->transaction && $apt->transaction->quantity > 1)
                                        <span class="inline-flex items-center ml-1.5 px-2 py-0.5 rounded text-[10px] font-black bg-amber-100 dark:bg-amber-900/50 text-amber-900 dark:text-amber-200 border border-amber-300/60">
                                            Qty: {{ $apt->transaction->quantity }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @php
                                        $txn = $apt->transaction;
                                        $amt = $txn ? $txn->total_amount : 0.00;
                                        $payStatus = $txn ? $txn->payment_status : 'pending';
                                    @endphp
                                    <div class="font-bold text-zinc-900 dark:text-white text-xs">
                                        ₱{{ number_format($amt, 2) }}
                                    </div>
                                    <div class="mt-0.5">
                                        @if($payStatus === 'paid')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-extrabold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300">
                                                Paid @if($txn?->official_receipt_number)({{ $txn->official_receipt_number }})@endif
                                            </span>
                                        @elseif($payStatus === 'waived')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                                Waived (Exempt)
                                            </span>
                                        @else
                                            <button 
                                                wire:click="startPayment({{ $apt->id }})"
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-extrabold bg-amber-100 hover:bg-amber-200 dark:bg-amber-900/40 dark:hover:bg-amber-900/60 text-amber-900 dark:text-amber-300 border border-amber-300/60 transition cursor-pointer"
                                                title="Record Payment"
                                            >
                                                <span>Unpaid</span>
                                                <flux:icon name="banknotes" class="size-2.5" />
                                            </button>
                                        @endif
                                    </div>
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
                                            Approved (Reserved)
                                        </span>
                                    @elseif($apt->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/30 dark:text-blue-400 dark:border-blue-900/50">
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-800 border border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    @if($apt->status === 'pending')
                                        <button 
                                            wire:click="markApprovedPending({{ $apt->id }})"
                                            class="text-xs text-amber-600 hover:text-amber-800 font-semibold cursor-pointer"
                                        >
                                            Send for Approval
                                        </button>
                                        <button 
                                            wire:click="startReject({{ $apt->id }})"
                                            class="text-xs text-red-500 hover:text-red-700 font-semibold cursor-pointer ml-2"
                                        >
                                            Reject
                                        </button>
                                    @elseif($apt->status === 'approved-pending')
                                        <button 
                                            wire:click="startApprove({{ $apt->id }})"
                                            class="text-xs text-emerald-500 hover:text-emerald-700 font-semibold cursor-pointer"
                                        >
                                            Approve & Schedule
                                        </button>
                                        <button 
                                            wire:click="startReject({{ $apt->id }})"
                                            class="text-xs text-red-500 hover:text-red-700 font-semibold cursor-pointer ml-2"
                                        >
                                            Reject
                                        </button>
                                    @elseif($apt->status === 'approved')
                                        <button 
                                            wire:click="complete({{ $apt->id }})"
                                            wire:loading.attr="disabled"
                                            class="text-xs text-blue-500 hover:text-blue-700 font-semibold cursor-pointer"
                                        >
                                            Mark Completed
                                        </button>
                                    @else
                                        <span class="text-xs text-zinc-400 dark:text-zinc-600">-</span>
                                    @endif
                                    @if(!in_array($apt->status, ['pending', 'approved-pending', 'approved']))
                                        <button 
                                            wire:click="delete({{ $apt->id }})"
                                            class="text-xs text-red-500 hover:text-red-700 font-semibold ml-2"
                                        >
                                            Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @if($apt->admin_notes)
                                <tr class="bg-zinc-50/50 dark:bg-zinc-800/20 border-t-0">
                                    <td colspan="5" class="px-4 py-2 text-xs text-zinc-600 dark:text-zinc-400">
                                        <strong class="text-zinc-800 dark:text-white">Admin Notes:</strong> {{ $apt->admin_notes }}
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

    <!-- Approval & Scheduling Modal -->
    <flux:modal name="approve-appointment-modal" class="max-w-md" wire:model="showApproveModal">
        <form wire:submit="confirmApprove" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Schedule Redemption / Pickup') }}</flux:heading>
                <flux:subheading>{{ __('Set the date and time when the resident can redeem their document or rental equipment.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="redemptionDate" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Redemption Date</label>
                    <input 
                        id="redemptionDate"
                        type="date" 
                        wire:model.live="redemptionDate"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                        required
                        min="{{ date('Y-m-d') }}"
                    />
                    @error('redemptionDate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="redemptionTime" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Time Slot</label>
                    <select 
                        id="redemptionTime"
                        wire:model="redemptionTime"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                        required
                    >
                        @php
                            $isToday = ($redemptionDate === date('Y-m-d'));
                            $now = now();
                        @endphp
                        @foreach(\App\Livewire\Admin\ManageAppointments::$defaultTimeSlots as $slot)
                            @php
                                $slotStart = \Carbon\Carbon::parse(date('Y-m-d') . ' ' . explode(' - ', $slot)[0]);
                                $hasPassed = $isToday && $slotStart->lt($now);
                            @endphp
                            <option value="{{ $slot }}" @disabled($hasPassed)>
                                {{ $slot }} @if($hasPassed)(Unavailable - Time passed)@endif
                            </option>
                        @endforeach
                    </select>
                    @error('redemptionTime') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="approvalNotes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Notes <span class="text-zinc-400 dark:text-zinc-500 font-normal">(optional)</span>
                    </label>
                    <textarea
                        id="approvalNotes"
                        wire:model="approvalNotes"
                        rows="3"
                        placeholder="e.g. Bring original copies for verification, or rental item quantity confirmed..."
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm resize-none"
                    ></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-2 border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit" wire:loading.attr="disabled">{{ __('Approve & Set Date') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Reject / Cancellation Reason Modal -->
    <flux:modal name="reject-appointment-modal" class="max-w-md" wire:model="showRejectModal">
        <form wire:submit="confirmReject" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Reject / Cancel Request') }}</flux:heading>
                <flux:subheading>{{ __('Provide a reason for rejecting this request. This will be saved as a note on the appointment.') }}</flux:subheading>
            </div>

            <div>
                <label for="rejectReason" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Reason for Cancellation</label>
                <textarea
                    id="rejectReason"
                    wire:model="rejectReason"
                    rows="4"
                    placeholder="e.g. Incomplete requirements, duplicate request, rental equipment unavailable..."
                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm resize-none"
                ></textarea>
                @error('rejectReason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-2 border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Go Back') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" type="submit" wire:loading.attr="disabled">{{ __('Confirm Rejection') }}</flux:button>
            </div>
        </form>
    </flux:modal>
    <!-- Record Payment & Issue Official Receipt Modal -->
    <flux:modal name="payment-appointment-modal" class="max-w-md" wire:model="showPaymentModal">
        <form wire:submit="confirmPayment" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Record Payment & Issue Receipt') }}</flux:heading>
                <flux:subheading>{{ __('Record official collection, assign OR Number, and log transaction into Sales Report.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Amount to Collect (₱)</label>
                    <input 
                        type="number" 
                        step="0.01"
                        wire:model="paymentAmount"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white font-bold text-sm"
                        required
                    />
                    @error('paymentAmount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Payment Method</label>
                    <select 
                        wire:model="paymentMethod"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white text-sm"
                        required
                    >
                        <option value="cash">Cash (Over-the-counter)</option>
                        <option value="gcash">GCash</option>
                        <option value="maya">Maya</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="free_exemption">Statutory Free Exemption / Indigent</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Official Receipt (OR) Number</label>
                    <input 
                        type="text" 
                        wire:model="paymentOrNumber"
                        placeholder="e.g. OR-2026-0042"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white text-sm font-mono"
                    />
                    @error('paymentOrNumber') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Payment Remarks (Optional)</label>
                    <input 
                        type="text" 
                        wire:model="paymentNotes"
                        placeholder="e.g. Paid at barangay treasury counter"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white text-sm"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" type="button" wire:click="$set('showPaymentModal', false)">{{ __('Cancel') }}</flux:button>
                <flux:button variant="primary" type="submit" wire:loading.attr="disabled" class="bg-emerald-600 hover:bg-emerald-700 font-bold text-white">{{ __('Save Payment & Issue Receipt') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Unpaid Document Claim Warning Modal -->
    <flux:modal name="unpaid-warning-modal" class="max-w-md" wire:model="showUnpaidWarningModal">
        <div class="space-y-5">
            <div class="flex items-start gap-3.5">
                <div class="p-3 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-2xl shrink-0 mt-0.5 border border-amber-500/20">
                    <flux:icon name="exclamation-triangle" class="size-6" />
                </div>
                <div>
                    <flux:heading size="lg" class="text-zinc-900 dark:text-white font-bold">{{ __('Unpaid Document Claim Warning') }}</flux:heading>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                        {{ __('This document claim has not been marked as paid yet.') }}
                    </p>
                </div>
            </div>

            @if($this->pendingCompleteAppointment)
                @php
                    $pendingApt = $this->pendingCompleteAppointment;
                    $pendingTxn = $pendingApt->transaction;
                    $isRentalItem = str_starts_with($pendingApt->purpose, '[Rental Service]');
                    $cleanPurpose = str_replace('[Rental Service] ', '', $pendingApt->purpose);
                @endphp
                <div class="rounded-xl border border-amber-200 dark:border-amber-900/40 bg-amber-50/60 dark:bg-amber-950/20 p-4 text-xs space-y-2.5">
                    <div class="flex justify-between items-center pb-2 border-b border-amber-200/60 dark:border-amber-900/40">
                        <span class="text-zinc-600 dark:text-zinc-400 font-medium">Claim Type:</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $isRentalItem ? 'Utility Rental' : 'Document Request' }}</span>
                    </div>
                    <div class="flex justify-between items-start pb-2 border-b border-amber-200/60 dark:border-amber-900/40">
                        <span class="text-zinc-600 dark:text-zinc-400 font-medium">Claim Details:</span>
                        <span class="font-semibold text-zinc-900 dark:text-white text-right max-w-[220px]">{{ $cleanPurpose }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-amber-200/60 dark:border-amber-900/40">
                        <span class="text-zinc-600 dark:text-zinc-400 font-medium">Resident:</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $pendingApt->user?->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-0.5">
                        <span class="text-amber-800 dark:text-amber-300 font-bold uppercase tracking-wider text-[11px]">Total Unpaid Fee:</span>
                        <span class="text-base font-extrabold text-amber-700 dark:text-amber-400">₱{{ number_format($pendingTxn?->total_amount ?? 0, 2) }}</span>
                    </div>
                </div>

                <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">
                    Warning: The official fee for this claim has not been collected. Are you sure you want to mark this claim as collected without payment? It is recommended to collect payment and issue a receipt first.
                </p>
            @endif

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-800">
                <flux:button variant="ghost" wire:click="$set('showUnpaidWarningModal', false)" class="text-xs">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button variant="primary" wire:click="payBeforeComplete" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs">
                    <flux:icon name="banknotes" class="size-3.5 mr-1" />
                    {{ __('Collect Payment First') }}
                </flux:button>
                <flux:button variant="danger" wire:click="confirmComplete" wire:loading.attr="disabled" class="text-xs">
                    {{ __('Mark Collected Anyway') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
