<div class="space-y-8 pb-12">

    @if(!$resident)
        {{-- No profile linked yet --}}
        <div class="relative overflow-hidden rounded-3xl border border-amber-300/40 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-zinc-900 dark:to-amber-950/20 p-8 shadow-lg">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="p-3 bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-2xl shrink-0">
                    <flux:icon name="exclamation-triangle" class="size-8" />
                </div>
                <div>
                    <h2 class="text-lg font-bold text-amber-900 dark:text-amber-300 font-outfit">No Resident Profile Linked</h2>
                    <p class="text-sm text-amber-700 dark:text-amber-400 mt-1">Your account is not yet linked to a resident profile. Please ask your Household Head to add you to their household list using your registered email address, or contact the Barangay Admin.</p>
                </div>
            </div>
        </div>
    @else

        {{-- Header Banner --}}
        <div class="relative overflow-hidden rounded-3xl border border-emerald-300/30 dark:border-emerald-700/40 bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 dark:from-zinc-950 dark:via-emerald-950 dark:to-zinc-900 p-8 shadow-2xl">
            <div class="absolute -right-16 -bottom-16 h-56 w-56 rounded-full bg-emerald-400/30 blur-3xl"></div>
            <div class="absolute -left-10 -top-10 h-48 w-48 rounded-full bg-emerald-300/20 blur-3xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 border border-white/30 text-white rounded-full text-[10px] font-extrabold tracking-wider uppercase">
                        <flux:icon name="identification" class="size-3" />
                        Resident Self-Service
                    </span>
                    <h1 class="text-3xl font-black font-outfit text-white tracking-tight">Complete Your Profile</h1>
                    <p class="text-white/80 text-sm max-w-xl">
                        Fill in your personal extended information below. This data helps the Barangay maintain accurate records in the official RBI registry.
                    </p>
                </div>
                {{-- Completion indicator --}}
                @php
                    $fields = ['place_of_birth','highest_educational_attainment','school_attended','occupation','income','last_voted_year','philhealth_id','covid_dose_1_date','nutritional_classification','vulnerable_sector'];
                    $filled = collect($fields)->filter(fn($f) => !empty($resident->$f))->count();
                    $pct = (int)(($filled / count($fields)) * 100);
                @endphp
                <div class="bg-white/10 backdrop-blur-md border border-white/20 dark:bg-zinc-950/80 dark:border-emerald-800/60 px-5 py-4 rounded-2xl w-fit shrink-0 space-y-2 min-w-[160px]">
                    <div class="text-[10px] uppercase tracking-widest text-emerald-100 dark:text-zinc-400 font-extrabold">Profile Completion</div>
                    <div class="text-3xl font-black text-white font-outfit">{{ $pct }}%</div>
                    <div class="w-full bg-white/20 rounded-full h-1.5">
                        <div class="bg-white rounded-full h-1.5 transition-all duration-500" style="width: {{ $pct }}%"></div>
                    </div>
                    <div class="text-[10px] text-emerald-100/70">{{ $filled }} of {{ count($fields) }} key fields</div>
                </div>
            </div>
        </div>

        <form wire:submit="save" class="space-y-8">

            {{-- SECTION 1: Personal Info --}}
            <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-5">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                    <div class="p-2 bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-xl">
                        <flux:icon name="user" class="size-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Personal Information</h2>
                        <p class="text-[11px] text-zinc-500">Extended personal details only you can verify</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <flux:input wire:model="place_of_birth" label="Place of Birth" placeholder="e.g. Corella, Bohol" />
                </div>
            </div>

            {{-- SECTION 2: Education & Skills --}}
            <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-5">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                    <div class="p-2 bg-purple-500/10 text-purple-600 dark:text-purple-400 rounded-xl">
                        <flux:icon name="academic-cap" class="size-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Education & Skills</h2>
                        <p class="text-[11px] text-zinc-500">Schooling history and personal competencies</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <flux:select wire:model="highest_educational_attainment" label="Highest Educational Attainment">
                        <option value="">Select Attainment</option>
                        <option value="No Formal Education">No Formal Education</option>
                        <option value="Elementary Level">Elementary Level</option>
                        <option value="Elementary Graduate">Elementary Graduate</option>
                        <option value="High School Level">High School Level</option>
                        <option value="High School Graduate">High School Graduate</option>
                        <option value="Senior High School Level">Senior High School Level</option>
                        <option value="Senior High School Graduate">Senior High School Graduate</option>
                        <option value="College Level">College Level</option>
                        <option value="College Graduate">College Graduate</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Vocational / Technical">Vocational / Technical</option>
                    </flux:select>
                    <flux:input wire:model="school_attended" label="School / University Attended" placeholder="e.g. Bohol Island State University" />
                    <flux:input wire:model="eligibility" label="Civil Service Eligibility" placeholder="e.g. PD 907, Career Service" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <flux:input wire:model="primary_skills" label="Primary Skills" placeholder="e.g. Carpentry, Cooking" />
                    <flux:input wire:model="secondary_skills" label="Secondary Skills" placeholder="e.g. Driving, Gardening" />
                    <flux:input wire:model="other_skills" label="Other Skills" placeholder="e.g. Computer, Welding" />
                </div>
            </div>

            {{-- SECTION 3: Employment & Income --}}
            <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-5">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                    <div class="p-2 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl">
                        <flux:icon name="briefcase" class="size-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Employment & Income</h2>
                        <p class="text-[11px] text-zinc-500">Your current employment details and earnings</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <flux:input wire:model="occupation" label="Occupation / Job Title" placeholder="e.g. Farmer, Teacher, Driver" />
                    <flux:input wire:model="income" label="Monthly Income (₱)" type="number" min="0" placeholder="e.g. 5000" />
                    <flux:input wire:model="days_work_per_week" label="Days of Work Per Week" type="number" min="0" max="7" placeholder="0–7" />
                </div>
            </div>

            {{-- SECTION 4: Voter Extended --}}
            <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-5">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                    <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl">
                        <flux:icon name="check-badge" class="size-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Voter & Civic Participation</h2>
                        <p class="text-[11px] text-zinc-500">Your voting history and Katipunan ng Kabataan assembly attendance</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <flux:input wire:model="last_voted_year" label="Last Year Voted" type="number" min="1990" max="{{ date('Y') }}" placeholder="e.g. 2022" />
                    <flux:select wire:model="attended_kk_assembly" label="Attended KK Assembly?">
                        <option value="">Select Option</option>
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </flux:select>
                    <flux:input wire:model="kk_assembly_times" label="KK Assembly Times Attended" placeholder="e.g. 3 times" />
                    <flux:input wire:model="kk_assembly_no_reason" label="Reason for Not Attending" placeholder="e.g. Work conflict" />
                </div>
            </div>

            {{-- SECTION 5: PhilHealth --}}
            <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-5">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                    <div class="p-2 bg-rose-500/10 text-rose-600 dark:text-rose-400 rounded-xl">
                        <flux:icon name="shield-check" class="size-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">PhilHealth & COVID Vaccination</h2>
                        <p class="text-[11px] text-zinc-500">Your insurance details and vaccination record</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <flux:input wire:model="philhealth_id" label="PhilHealth ID Number" placeholder="e.g. 01-234567890-1" />
                    <flux:select wire:model="philhealth_membership_type" label="PhilHealth Membership Type">
                        <option value="">Select Type</option>
                        <option value="Employed">Employed Member</option>
                        <option value="Self-Employed">Self-Employed</option>
                        <option value="Individually Paying">Individually Paying</option>
                        <option value="Lifetime">Lifetime Member</option>
                        <option value="Sponsored">Sponsored (4Ps / indigent)</option>
                        <option value="OFW">OFW</option>
                    </flux:select>
                </div>

                <div class="border-t border-zinc-100 dark:border-zinc-800 pt-4">
                    <h3 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-4">COVID-19 Vaccination Record</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <flux:input wire:model="covid_dose_1_date" label="1st Dose Date" type="date" />
                        <flux:input wire:model="covid_dose_2_date" label="2nd Dose Date" type="date" />
                        <flux:input wire:model="covid_brand" label="Vaccine Brand" placeholder="e.g. Sinovac, Pfizer" />
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-4">
                        <flux:select wire:model="has_booster" label="Has Booster?">
                            <option value="">Select Option</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </flux:select>
                        <flux:input wire:model="booster_date" label="Booster Date" type="date" />
                        <flux:input wire:model="booster_brand" label="Booster Brand" placeholder="e.g. Moderna, J&J" />
                    </div>
                </div>
            </div>

            {{-- SECTION 6: Welfare & Social --}}
            <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-5">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                    <div class="p-2 bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-xl">
                        <flux:icon name="heart" class="size-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Health, Welfare & Social Classification</h2>
                        <p class="text-[11px] text-zinc-500">Nutritional status, vulnerable sector affiliation, and welfare programs availed</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <flux:select wire:model="nutritional_classification" label="Nutritional Classification">
                        <option value="">Select Classification</option>
                        <option value="Normal">Normal</option>
                        <option value="Underweight">Underweight</option>
                        <option value="Overweight">Overweight</option>
                        <option value="Obese">Obese</option>
                        <option value="Severely Underweight">Severely Underweight</option>
                    </flux:select>
                    <flux:select wire:model="vulnerable_sector" label="Vulnerable Sector">
                        <option value="">Select Sector</option>
                        <option value="Senior Citizen">Senior Citizen (60+)</option>
                        <option value="PWD">Person with Disability (PWD)</option>
                        <option value="Solo Parent">Solo Parent</option>
                        <option value="Indigent">Indigent / 4Ps Beneficiary</option>
                        <option value="Pregnant">Pregnant / Lactating</option>
                        <option value="OFW">OFW / Migrant Worker</option>
                        <option value="None">None</option>
                    </flux:select>
                    <flux:select wire:model="social_welfare_availed" label="Social Welfare Program Availed">
                        <option value="">Select Program</option>
                        <option value="4Ps">4Ps (Pantawid Pamilyang Pilipino)</option>
                        <option value="AICS">AICS (Assistance to Individuals in Crisis)</option>
                        <option value="SLP">SLP (Sustainable Livelihood Program)</option>
                        <option value="PhilHealth Indigent">PhilHealth Indigent Program</option>
                        <option value="None">None</option>
                    </flux:select>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-zinc-600 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl hover:border-zinc-300 transition">
                    Cancel
                </a>
                <flux:button type="submit" variant="primary" icon="check" class="px-6">
                    Save Profile
                </flux:button>
            </div>

        </form>

    @endif

</div>
