<div>
    <flux:modal name="resident-profile-card-modal" class="max-w-4xl p-0 overflow-hidden" wire:model="showModal">
        @if($resident)
            <div class="space-y-6 max-h-[85vh] overflow-y-auto p-6 sm:p-8 font-sans">
                <!-- Top Header Profile Card -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-zinc-900 via-zinc-900 to-zinc-950 text-white p-6 border border-zinc-800 shadow-xl">
                    <div class="absolute -right-10 -top-10 w-60 h-60 bg-sky-500/15 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -left-10 -bottom-10 w-60 h-60 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative flex flex-col sm:flex-row items-center sm:items-start gap-5 z-10">
                        <!-- Profile Picture Area -->
                        <div class="relative shrink-0">
                            @if($resident->user?->avatar)
                                <img src="{{ $resident->user->avatar_url }}" alt="{{ $resident->full_name }}" class="size-24 rounded-2xl object-cover ring-4 ring-white/15 shadow-xl">
                            @else
                                <div class="size-24 rounded-2xl bg-gradient-to-tr from-sky-600 via-indigo-600 to-emerald-600 text-white font-black font-outfit text-3xl flex items-center justify-center ring-4 ring-white/15 shadow-xl">
                                    {{ strtoupper(substr($resident->first_name, 0, 1) . substr($resident->last_name, 0, 1)) }}
                                </div>
                            @endif

                            @if($resident->registration_status === 'approved')
                                <div class="absolute -bottom-1.5 -right-1.5 bg-emerald-500 text-white p-1 rounded-full ring-2 ring-zinc-900" title="Verified Resident">
                                    <flux:icon name="check" class="size-3.5" />
                                </div>
                            @endif
                        </div>

                        <!-- Name & Core Info -->
                        <div class="flex-1 text-center sm:text-left space-y-2">
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                                <h2 class="text-xl sm:text-2xl font-black font-outfit text-white tracking-tight">
                                    {{ $resident->full_name }}
                                </h2>

                                <!-- Role / Head Badge -->
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider
                                    @if(strtolower($resident->relationship_to_head) === 'household head' || strtolower($resident->relationship_to_head) === 'hh')
                                        bg-amber-500/20 text-amber-300 border border-amber-500/30
                                    @else
                                        bg-sky-500/20 text-sky-300 border border-sky-500/30
                                    @endif">
                                    {{ $resident->relationship_to_head ?: 'Resident Member' }}
                                </span>

                                @if($resident->registration_status === 'approved')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                        <flux:icon name="check-badge" class="size-3.5" />
                                        Approved
                                    </span>
                                @elseif($resident->registration_status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                        <flux:icon name="clock" class="size-3.5" />
                                        Pending Review
                                    </span>
                                @elseif($resident->registration_status === 'rejected')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-500/20 text-red-300 border border-red-500/30">
                                        <flux:icon name="x-mark" class="size-3.5" />
                                        Rejected
                                    </span>
                                @endif
                            </div>

                            <div class="text-xs text-zinc-400 flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-1">
                                @if($resident->email_address || $resident->user?->email)
                                    <span class="inline-flex items-center gap-1.5">
                                        <flux:icon name="envelope" class="size-3.5 text-zinc-500" />
                                        {{ $resident->email_address ?: $resident->user?->email }}
                                    </span>
                                @endif
                                @if($resident->mobile_number)
                                    <span class="inline-flex items-center gap-1.5">
                                        <flux:icon name="phone" class="size-3.5 text-zinc-500" />
                                        {{ $resident->mobile_number }}
                                    </span>
                                @endif
                                @if($resident->household)
                                    <span class="inline-flex items-center gap-1.5">
                                        <flux:icon name="home" class="size-3.5 text-zinc-500" />
                                        HH: {{ $resident->household->household_no }} (Purok {{ $resident->household->purok_no ?? '—' }})
                                    </span>
                                @endif
                            </div>

                            <div class="pt-1 flex flex-wrap items-center justify-center sm:justify-start gap-2">
                                @if($resident->age)
                                    <span class="text-[11px] bg-zinc-800 text-zinc-300 px-2.5 py-0.5 rounded-lg border border-zinc-700">
                                        Age: <strong class="text-white">{{ $resident->age }} yrs old</strong>
                                    </span>
                                @endif
                                @if($resident->sex)
                                    <span class="text-[11px] bg-zinc-800 text-zinc-300 px-2.5 py-0.5 rounded-lg border border-zinc-700">
                                        Sex: <strong class="text-white">{{ $resident->sex }}</strong>
                                    </span>
                                @endif
                                @if($resident->civil_status)
                                    <span class="text-[11px] bg-zinc-800 text-zinc-300 px-2.5 py-0.5 rounded-lg border border-zinc-700">
                                        Status: <strong class="text-white">{{ $resident->civil_status }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 1. Personal & Demographics -->
                <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                    <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                        <flux:icon name="user" class="size-4 text-sky-500" />
                        <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">1. Personal & Demographics</h4>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Full Legal Name</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->full_name }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Sex / Gender</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->sex ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Birthdate & Age</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                {{ $resident->birthdate ? date('M d, Y', strtotime($resident->birthdate)) : '—' }}
                                @if($resident->age) ({{ $resident->age }} yrs) @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Place of Birth</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->place_of_birth ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Civil Status</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->civil_status ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Citizenship</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->citizenship ?? 'Filipino' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Religion</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->religion ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Blood Type</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->blood_type ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Height & Weight</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                {{ $resident->height ? $resident->height . ' cm' : '—' }} / {{ $resident->weight ? $resident->weight . ' kg' : '—' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Mobile Number</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->mobile_number ?? '—' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Email Address</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->email_address ?: ($resident->user?->email ?? '—') }}</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Household & Housing Details -->
                <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                    <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                        <flux:icon name="home" class="size-4 text-amber-500" />
                        <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">2. Household & Housing Details</h4>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Household Number</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->household?->household_no ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Purok</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">Purok {{ $resident->household?->purok_no ?? '—' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Address / Street</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->household?->address ?? ($resident->household?->street ?? 'Barangay Sambog') }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Role in Household</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->relationship_to_head ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">House Ownership</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                @if($resident->is_house_owner === 'Y') Owned
                                @elseif($resident->is_renter === 'Y') Renting ({{ $resident->renter_months ?? 0 }} mos)
                                @else — @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Water Source</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->water_source ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Sanitary Toilet</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->sanitary_toilet ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Waste Management</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->waste_management ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Blind Drainage</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->has_blind_drainage === 'Y' ? 'Yes' : ($resident->has_blind_drainage === 'N' ? 'No' : '—') }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Is Farmer?</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->is_farmer === 'Y' ? 'Yes' : ($resident->is_farmer === 'N' ? 'No' : '—') }}</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Education, Skills & Employment -->
                <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                    <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                        <flux:icon name="academic-cap" class="size-4 text-emerald-500" />
                        <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">3. Education, Skills & Employment</h4>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Educational Status</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->educational_status ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Highest Attainment</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->highest_educational_attainment ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">School Attended</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->school_attended ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Course Completed</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->course_completed ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Work Status</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->work_status ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Occupation</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->occupation ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Monthly Income</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                {{ $resident->income ? 'PHP ' . number_format((float)$resident->income, 2) : '—' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Days Work/Week</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->days_work_per_week ?? '—' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Primary & Secondary Skills</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                {{ $resident->primary_skills ?? '—' }} {{ $resident->secondary_skills ? "/ {$resident->secondary_skills}" : '' }}
                            </span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Civil Service / Eligibility</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->eligibility ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Health, PhilHealth & COVID-19 -->
                <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                    <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                        <flux:icon name="heart" class="size-4 text-rose-500" />
                        <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">4. Health, PhilHealth & COVID-19</h4>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">PhilHealth Enrolled</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->has_philhealth ?? ($resident->philhealth_id ? 'Yes' : '—') }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">PhilHealth ID</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->philhealth_id ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Membership Type</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->philhealth_membership_type ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">COVID Vaccination</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                @if($resident->fully_vaccinated === 'Y') Fully Vaccinated ({{ $resident->covid_brand ?? 'Vaccine' }})
                                @elseif($resident->partially_vaccinated === 'Y') Partially Vaccinated
                                @else Unvaccinated / None @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Dose 1 Date</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->covid_dose_1_date ? date('M d, Y', strtotime($resident->covid_dose_1_date)) : '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Dose 2 Date</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->covid_dose_2_date ? date('M d, Y', strtotime($resident->covid_dose_2_date)) : '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Booster Received?</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                {{ $resident->has_booster === 'Y' ? 'Yes' : ($resident->has_booster === 'N' ? 'No' : '—') }}
                                @if($resident->booster_brand) ({{ $resident->booster_brand }}) @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Chronic Conditions</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->health_condition ?? 'None reported' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Vulnerable Sector</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->vulnerable_sector ?? 'None' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Social Welfare Availed</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->social_welfare_availed ?? 'None' }}</span>
                        </div>
                    </div>
                </div>

                <!-- 5. Voter & Civic Participation -->
                <div class="bg-zinc-50/70 dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-5 space-y-3">
                    <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-800 pb-2">
                        <flux:icon name="check-badge" class="size-4 text-violet-500" />
                        <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-900 dark:text-white">5. Voter & Civic Participation</h4>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">National Voter</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->registered_national_voter === 'Y' ? 'Registered' : 'No' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">SK Voter</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->registered_sk_voter === 'Y' ? 'Registered SK' : 'No' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Resident Voter</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->resident_voter === 'Y' ? 'Yes' : 'No' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Last Voted Year</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->last_voted_year ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">Attended KK Assembly</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->attended_kk_assembly === 'Y' ? 'Attended' : 'No' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 block font-semibold">KK Assembly Times</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $resident->kk_assembly_times ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <flux:modal.close>
                        <flux:button variant="ghost">Close Profile</flux:button>
                    </flux:modal.close>
                </div>
            </div>
        @endif
    </flux:modal>
</div>
