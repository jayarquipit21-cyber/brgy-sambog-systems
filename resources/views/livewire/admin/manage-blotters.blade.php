<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Blotter & Lupon Management</flux:heading>
            <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Manage incident reports, complaints, and hearing schedules.</flux:text>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="Search names..."
                class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
            />
            <select 
                wire:model.live="statusFilter"
                class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
            >
                <option value="">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="Scheduled">Scheduled for Hearing</option>
                <option value="Settled">Settled</option>
                <option value="Unsettled">Unsettled</option>
                <option value="Forwarded">Forwarded to PNP/Court</option>
            </select>
            <flux:button variant="primary" wire:click="create" icon="plus">New Record</flux:button>
        </div>
    </div>

    @if($blotters->isEmpty())
        <div class="text-center py-12 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800 p-8">
            <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">No blotter records found.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                        <th class="py-3 px-4">Complainant / Respondent</th>
                        <th class="py-3 px-4">Incident Details</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4">Hearing Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($blotters as $blotter)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="py-3 px-4">
                                <div class="font-medium text-zinc-900 dark:text-white">{{ $blotter->complainant_name }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">vs. {{ $blotter->respondent_name }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-zinc-900 dark:text-white">{{ $blotter->incident_type }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $blotter->incident_date ? $blotter->incident_date->format('M d, Y') : 'N/A' }}</div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 border border-zinc-200 dark:bg-zinc-850/40 dark:text-zinc-300 dark:border-zinc-700/50">
                                    {{ $blotter->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($blotter->hearing_date)
                                    <div class="text-sm text-zinc-900 dark:text-white">{{ $blotter->hearing_date->format('M d, Y') }}</div>
                                    <div class="text-xs text-zinc-500">{{ $blotter->hearing_date->format('h:i A') }}</div>
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button wire:click="edit({{ $blotter->id }})" class="text-xs text-blue-600 hover:text-blue-800 font-semibold mr-2">Edit</button>
                                <button wire:click="delete({{ $blotter->id }})" class="text-xs text-red-500 hover:text-red-700 font-semibold" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <flux:modal name="blotter-form-modal" class="max-w-2xl" wire:model="showFormModal">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editingId ? 'Edit Blotter Record' : 'New Blotter Record' }}</flux:heading>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Complainant Name <span class="text-xs text-zinc-400 font-normal">(Type to search RBI records)</span>
                    </label>
                    <input 
                        type="text" 
                        wire:model.live.debounce.250ms="complainant_name" 
                        wire:focus="$set('showComplainantSuggestions', true)"
                        placeholder="Type complainant name..."
                        autocomplete="off"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm" 
                        required 
                    />
                    @if($this->complainantSuggestions->isNotEmpty())
                        <div class="absolute z-50 left-0 right-0 mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-xl overflow-hidden max-h-48 overflow-y-auto divide-y divide-zinc-100 dark:divide-zinc-700">
                            <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-zinc-400 bg-zinc-50 dark:bg-zinc-900/50">
                                Matching RBI Inhabitants
                            </div>
                            @foreach($this->complainantSuggestions as $res)
                                <button
                                    type="button"
                                    wire:click="selectComplainant({{ $res->id }})"
                                    class="w-full text-left px-3 py-2 text-xs hover:bg-emerald-50 dark:hover:bg-emerald-950/30 flex items-center justify-between transition cursor-pointer"
                                >
                                    <div>
                                        <span class="font-bold text-zinc-900 dark:text-white">{{ $res->full_name }}</span>
                                        <span class="text-[11px] text-zinc-500 dark:text-zinc-400 ml-1.5">
                                            Purok {{ $res->household?->purok_no ?? 'N/A' }}
                                            @if($res->household?->address) • {{ $res->household->address }} @endif
                                        </span>
                                    </div>
                                    <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-500/10 px-2 py-0.5 rounded">Select</span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Respondent Name</label>
                    <input type="text" wire:model="respondent_name" class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Incident Type</label>
                    <input type="text" wire:model="incident_type" placeholder="e.g. Physical Injury, Theft, Noise Complaint" class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Incident Date</label>
                    <input type="date" wire:model="incident_date" class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm" />
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Location of Incident</label>
                    <input type="text" wire:model="incident_location" class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm" />
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Narrative / Details</label>
                    <textarea wire:model="narrative" rows="3" class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                    <select wire:model="status" class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm">
                        <option value="Pending">Pending</option>
                        <option value="Scheduled">Scheduled for Hearing</option>
                        <option value="Settled">Settled</option>
                        <option value="Unsettled">Unsettled</option>
                        <option value="Forwarded">Forwarded to PNP/Court</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Hearing Date</label>
                        <input type="date" wire:model="hearing_date" class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Time</label>
                        <input type="time" wire:model="hearing_time" class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2 border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit" wire:loading.attr="disabled">{{ __('Save Record') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
