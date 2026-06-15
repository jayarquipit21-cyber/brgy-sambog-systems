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
            <div class="mt-4 md:mt-0 flex flex-wrap items-center gap-4 text-sm text-zinc-600 dark:text-zinc-400">
                <flux:button variant="primary" icon="plus" wire:click="openCreateModal" class="cursor-pointer">{{ __('Add Household Member') }}</flux:button>
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
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($members as $member)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition {{ $member->id === $resident->id ? 'bg-brand/5 dark:bg-brand/10 font-medium' : '' }}">
                            <td class="py-3 px-4 text-zinc-900 dark:text-white">
                                {{ $member->full_name }}
                                @if($member->id === $resident->id)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-brand text-white">
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
                            <td class="py-3 px-4 text-center">
                                @if(($member->registration_status ?? 'approved') === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-400 dark:border-emerald-900/50">
                                        Approved
                                    </span>
                                @elseif($member->registration_status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/30 dark:text-amber-400 dark:border-amber-900/50">
                                        Pending
                                    </span>
                                @elseif($member->registration_status === 'rejected')
                                    <div class="inline-flex flex-col items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-800 border border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50">
                                            Rejected
                                        </span>
                                        @if($member->rejection_reason)
                                            <span class="text-[10px] text-red-500 dark:text-red-400 mt-1 max-w-[150px] truncate" title="{{ $member->rejection_reason }}">
                                                Reason: {{ $member->rejection_reason }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    <!-- Add Resident Modal -->
    <flux:modal name="add-member-modal" class="max-w-3xl" wire:model="showCreateModal">
        <form wire:submit="saveResident" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Add Household Member') }}</flux:heading>
                <flux:subheading>{{ __('Fill out the details of the family/household member to register them under your household unit.') }}</flux:subheading>
            </div>

            <!-- Basic Information -->
            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Basic Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <flux:input wire:model="first_name" label="First Name" required />
                    <flux:input wire:model="middle_name" label="Middle Name" />
                    <flux:input wire:model="last_name" label="Last Name" required />
                    <flux:input wire:model="extension" label="Extension (Jr/Sr/etc)" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-4">
                    <flux:input wire:model="relationship_to_head" label="Relationship to Head" placeholder="e.g. Spouse, Son, Daughter" required />
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
                    <flux:input wire:model="citizenship" label="Citizenship" required />
                    <flux:input wire:model="mobile_number" label="Mobile Number" />
                    <flux:input wire:model="email_address" type="email" label="Email Address" />
                </div>
            </div>

            <!-- Education & Employment -->
            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Education & Employment</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <flux:select wire:model="educational_status" label="Educational Status" required>
                        <option value="">Select Educational Status</option>
                        <option value="Enrolled">Enrolled</option>
                        <option value="Not Enrolled">Not Enrolled</option>
                        <option value="Graduated">Graduated</option>
                        <option value="N/A">Not Applicable</option>
                    </flux:select>
                    <flux:select wire:model="work_status" label="Work / Employment Status" required>
                        <option value="">Select Work Status</option>
                        <option value="Employed">Employed</option>
                        <option value="Unemployed">Unemployed</option>
                        <option value="Underemployed">Underemployed</option>
                        <option value="Student">Student</option>
                        <option value="Retired">Retired</option>
                        <option value="N/A">Not Applicable</option>
                    </flux:select>
                </div>
            </div>

            <!-- Voter Information -->
            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Voter Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <flux:select wire:model="registered_national_voter" label="Registered National Voter?" required>
                        <option value="">Select Option</option>
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </flux:select>
                    <flux:select wire:model="registered_sk_voter" label="Registered SK Voter?" required>
                        <option value="">Select Option</option>
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </flux:select>
                    <flux:select wire:model="resident_voter" label="Resident Voter?" required>
                        <option value="">Select Option</option>
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </flux:select>
                </div>
            </div>

            <!-- Health & Vaccination Info -->
            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Health & Vaccination Info</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <flux:select wire:model="fully_vaccinated" label="Fully Vaccinated (COVID-19)?" required>
                        <option value="">Select Option</option>
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </flux:select>
                    <flux:select wire:model="has_philhealth" label="Has PhilHealth?" required>
                        <option value="">Select Option</option>
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </flux:select>
                    <flux:input wire:model="health_condition" label="Chronic Health Conditions" placeholder="e.g. Hypertension, Diabetes, None" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2 border-t border-zinc-200 dark:border-zinc-800 pt-4">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">{{ __('Save Member') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
