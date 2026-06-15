<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Document Pickup Registry</flux:heading>
            <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Review and manage resident appointments for physical document pickups.</flux:text>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="Search resident name..."
                class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
            />
            <select 
                wire:model.live="statusFilter"
                class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
            >
                <option value="">All Statuses</option>
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

    @if($appointments->isEmpty())
        <div class="text-center py-12 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800 p-8">
            <svg class="mx-auto text-zinc-350 dark:text-zinc-700 mb-4" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">No pickup appointments found matching the filters.</p>
            <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Check back later or try adjusting the filters.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                        <th class="py-3 px-4">Resident</th>
                        <th class="py-3 px-4">Scheduled Slot</th>
                        <th class="py-3 px-4">Requested Document & Purpose</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($appointments as $apt)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="py-3 px-4 text-zinc-900 dark:text-white font-medium">
                                {{ $apt->user->name }}
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $apt->user->email }}</div>
                            </td>
                            <td class="py-3 px-4">
                                @if($apt->appointment_date)
                                    <div class="font-medium text-zinc-900 dark:text-white">{{ $apt->appointment_date->format('M d, Y') }}</div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $apt->appointment_time }}</div>
                                @else
                                    <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold bg-amber-50 dark:bg-amber-950/20 px-2 py-0.5 rounded">Pending Kapitan Signature</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 max-w-sm whitespace-normal break-words">
                                {{ $apt->purpose }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($apt->status === 'approved-pending')
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
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 border border-zinc-200 dark:bg-zinc-800/40 dark:text-zinc-400 dark:border-zinc-700/50">
                                        Cancelled
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right space-x-2">
                                @if($apt->status === 'approved-pending')
                                    <button 
                                        wire:click="startApprove({{ $apt->id }})"
                                        class="text-xs text-emerald-500 hover:text-emerald-700 font-semibold cursor-pointer"
                                    >
                                        Approve & Schedule
                                    </button>
                                    <button 
                                        wire:click="reject({{ $apt->id }})"
                                        class="text-xs text-red-500 hover:text-red-700 font-semibold cursor-pointer"
                                    >
                                        Reject
                                    </button>
                                @elseif($apt->status === 'approved')
                                    <button 
                                        wire:click="complete({{ $apt->id }})"
                                        class="text-xs text-blue-500 hover:text-blue-700 font-semibold cursor-pointer"
                                    >
                                        Mark Collected
                                    </button>
                                @else
                                    <span class="text-xs text-zinc-400 dark:text-zinc-600">-</span>
                                @endif
                                @if($apt->status !== 'approved-pending')
                                    <button 
                                        wire:click="delete({{ $apt->id }})"
                                        class="text-xs text-red-500 hover:text-red-700 font-semibold ml-2"
                                    >
                                        Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Approval & Scheduling Modal -->
    <flux:modal name="approve-appointment-modal" class="max-w-md" wire:model="showApproveModal">
        <form wire:submit="confirmApprove" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Schedule Document Redemption') }}</flux:heading>
                <flux:subheading>{{ __('Set the date and time when the resident can redeem their completely signed document.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="redemptionDate" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Redemption Date</label>
                    <input 
                        id="redemptionDate"
                        type="date" 
                        wire:model="redemptionDate"
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
                        <option value="09:00 AM - 10:00 AM">09:00 AM - 10:00 AM (Morning)</option>
                        <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM (Morning)</option>
                        <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM (Morning)</option>
                        <option value="01:00 PM - 02:00 PM">01:00 PM - 02:00 PM (Afternoon)</option>
                        <option value="02:00 PM - 03:00 PM">02:00 PM - 03:00 PM (Afternoon)</option>
                        <option value="03:00 PM - 04:00 PM">03:00 PM - 04:00 PM (Afternoon)</option>
                    </select>
                    @error('redemptionTime') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-2 border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">{{ __('Approve & Set Date') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
