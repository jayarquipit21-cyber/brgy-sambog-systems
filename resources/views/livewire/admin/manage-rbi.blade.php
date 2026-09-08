<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-brand/10 text-brand rounded-lg">
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

    <!-- Population Management Dashboard Main Card -->
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
        <!-- Header & Action controls -->
        <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Population Management Dashboard</flux:heading>
                <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Manage resident registration requests and household heads directory.</flux:text>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 items-center">
                @if($activeTab === 'heads')
                    <flux:button variant="primary" icon="plus" wire:click="openCreateModal" class="cursor-pointer text-sm py-1.5 w-full sm:w-auto">{{ __('Add Household Head') }}</flux:button>
                @endif
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search name, phone, occupation, household, PhilHealth..."
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm w-full sm:w-80"
                />

                <select 
                    wire:model.live="purokFilter"
                    class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-1.5 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm w-full sm:w-auto"
                >
                    <option value="">All Puroks</option>
                    @for($i=1; $i<=8; $i++)
                        <option value="{{ $i }}">Purok {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Tab Controls -->
        <div class="flex border-b border-zinc-200 dark:border-zinc-800 mb-6">
            <button 
                wire:click="$set('activeTab', 'heads')"
                class="pb-3 px-4 font-medium text-sm border-b-2 transition-colors duration-150 {{ $activeTab === 'heads' ? 'border-brand text-brand font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300' }}"
            >
                Household Heads Registry
            </button>
            <button 
                wire:click="$set('activeTab', 'pending')"
                class="pb-3 px-4 font-medium text-sm border-b-2 transition-colors duration-150 flex items-center gap-2 {{ $activeTab === 'pending' ? 'border-brand text-brand font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300' }}"
            >
                <span>Pending Requests</span>
                @php
                    $pendingCount = \App\Models\Resident::where('registration_status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="relative flex h-2 w-2 mr-1">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400">{{ $pendingCount }}</span>
                @endif
            </button>
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
                    @if($activeTab === 'pending')
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                                <th class="py-3 px-4">Resident Name</th>
                                <th class="py-3 px-4">Relationship to Head</th>
                                <th class="py-3 px-4">Purok</th>
                                <th class="py-3 px-4 text-center">Age / Sex</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Contact</th>
                                <th class="py-3 px-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($residents as $res)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                    <td class="py-3 px-4">
                                        <span class="text-zinc-900 dark:text-white font-medium">{{ $res->full_name }}</span>
                                    </td>
                                    <td class="py-3 px-4 capitalize text-xs">
                                        {{ strtolower($res->relationship_to_head ?? 'Member') }}
                                    </td>
                                    <td class="py-3 px-4 text-zinc-900 dark:text-white">
                                        Purok {{ $res->household->purok_no ?? 'N/A' }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="text-zinc-900 dark:text-white font-medium">{{ $res->age ?? 'N/A' }}</span>
                                        <span class="text-zinc-400 dark:text-zinc-600 text-xs">/ {{ $res->sex }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-xs text-zinc-900 dark:text-white font-medium">
                                        {{ $res->email_address ?? '—' }}
                                    </td>
                                    <td class="py-3 px-4 text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $res->mobile_number ?? '—' }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button 
                                                wire:click="approveResident({{ $res->id }})"
                                                class="px-3 py-1 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded cursor-pointer transition shadow-sm"
                                            >
                                                Approve
                                            </button>
                                            <button 
                                                wire:click="startReject({{ $res->id }})"
                                                class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded cursor-pointer transition shadow-sm"
                                            >
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs font-semibold uppercase">
                                <th class="py-3 px-4">Household Head</th>
                                <th class="py-3 px-4">Purok</th>
                                <th class="py-3 px-4">Address</th>
                                <th class="py-3 px-4 text-center">Age / Sex</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Contact</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($residents as $res)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                    <td class="py-3 px-4">
                                        <span class="text-zinc-900 dark:text-white font-medium">{{ $res->full_name }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-zinc-900 dark:text-white">
                                        Purok {{ $res->household->purok_no ?? 'N/A' }}
                                    </td>
                                    <td class="py-3 px-4 text-xs">
                                        {{ $res->household->address ?? 'N/A' }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="text-zinc-900 dark:text-white font-medium">{{ $res->age ?? 'N/A' }}</span>
                                        <span class="text-zinc-400 dark:text-zinc-600 text-xs">/ {{ $res->sex }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-xs text-zinc-900 dark:text-white font-medium">
                                        {{ $res->email_address ?? '—' }}
                                    </td>
                                    <td class="py-3 px-4 text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $res->mobile_number ?? '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $residents->links() }}
            </div>
        @endif
    </div>

    <!-- Add Household Head Modal -->
    <flux:modal name="add-household-head" class="max-w-2xl" wire:model="showCreateModal">
        <form wire:submit="saveHouseholdHead" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Add New Household Head') }}</flux:heading>
                <flux:subheading>{{ __('Creates a new Household unit, Resident profile, and associated User login account.') }}</flux:subheading>
            </div>

            <!-- Household Details -->
            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Household Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <flux:input wire:model="household_no" label="Household Number" placeholder="e.g. 0001" required />
                    <flux:select wire:model="purok_no" label="Purok" required>
                        <option value="">Select Purok</option>
                        @for($i=1; $i<=8; $i++)
                            <option value="{{ $i }}">Purok {{ $i }}</option>
                        @endfor
                    </flux:select>
                    <flux:input wire:model="address" label="Address" placeholder="e.g. Sambog, Corella, Bohol" required />
                </div>
            </div>

            <!-- Personal Details -->
            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Personal Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <flux:input wire:model="first_name" label="First Name" required />
                    <flux:input wire:model="middle_name" label="Middle Name" />
                    <flux:input wire:model="last_name" label="Last Name" required />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-4">
                    <flux:input wire:model="extension" label="Extension (Jr/Sr/etc)" />
                    <flux:input wire:model="birthdate" type="date" label="Birthdate" required />
                    <flux:select wire:model="sex" label="Sex" required>
                        <option value="">Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </flux:select>
                    <flux:select wire:model="civil_status" label="Civil Status" required>
                        <option value="">Select Civil Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Separated">Separated</option>
                        <option value="Divorced">Divorced</option>
                    </flux:select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                    <flux:select wire:model="citizenship" label="Citizenship" required>
                        <option value="">Select Citizenship</option>
                        <option value="Filipino">Filipino</option>
                        <option value="Dual Citizen">Dual Citizen</option>
                        <option value="Foreign National">Foreign National</option>
                    </flux:select>
                    <flux:select wire:model="blood_type" label="Blood Type">
                        <option value="">Select Blood Type</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="Unknown">Unknown</option>
                    </flux:select>
                    <flux:select wire:model="religion" label="Religion">
                        <option value="">Select Religion</option>
                        <option value="Roman Catholic">Roman Catholic</option>
                        <option value="Islam">Islam</option>
                        <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                        <option value="Evangelical Christian">Evangelical Christian</option>
                        <option value="Other">Other</option>
                        <option value="None">None</option>
                    </flux:select>
                    <flux:input wire:model="mobile_number" label="Mobile Number" />
                </div>
            </div>

            <!-- Account Details -->
            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Account Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <flux:input wire:model="email" type="email" label="Email Address (Username)" placeholder="name@barangay.gov" required />
                    <flux:input wire:model="password" type="password" label="Password" required viewable />
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex justify-end gap-2 border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">{{ __('Save Household Head') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Reject Resident Modal -->
    <flux:modal name="reject-resident" class="max-w-md" wire:model="showRejectModal">
        <form wire:submit="saveRejection" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Reject Resident Registration') }}</flux:heading>
                <flux:subheading>{{ __('Please state the reason for rejecting this resident\'s registration.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <flux:textarea wire:model="rejectionReason" label="Rejection Reason" placeholder="e.g. Incomplete details, not part of household, etc." required />
            </div>

            <div class="flex justify-end gap-2 border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" type="submit">{{ __('Reject Registration') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
