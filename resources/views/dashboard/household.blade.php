@if(auth()->user()->resident && !auth()->user()->resident->place_of_birth)
    <!-- Complete Profile Prompt — amber alert, accessible -->
    <div class="mb-6 relative overflow-hidden bg-amber-50/70 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/80 p-6 rounded-2xl shadow-sm" role="alert">
        <div class="flex items-start sm:items-center gap-4">
            <div class="p-3 bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-2xl shrink-0" aria-hidden="true">
                <flux:icon name="identification" class="size-6" />
            </div>
            <div class="flex-1">
                <h3 class="text-base font-bold text-amber-900 dark:text-amber-300">Complete Your Profile</h3>
                <p class="text-[11px] text-amber-800/80 dark:text-amber-400/80 mt-1">Please provide your extended personal details and household information to ensure the Barangay registry is accurate.</p>
            </div>
            <a href="{{ route('profile.complete') }}" wire:navigate class="shrink-0 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl shadow-sm transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500">
                Complete Now
            </a>
        </div>
    </div>
@endif

<!-- Top Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <!-- Family Members -->
    <div class="group relative overflow-hidden bg-amber-50/60 dark:bg-zinc-900/40 border border-amber-200/80 dark:border-zinc-800/80 hover:border-amber-400/50 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-household card-glow-household">
        <div class="absolute inset-0 bg-gradient-to-b from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div class="text-[10px] font-extrabold uppercase tracking-wider text-amber-800 dark:text-amber-450">Family Members</div>
                <div class="text-4xl font-black text-amber-950 dark:text-white font-outfit tracking-tight">{{ $householdMembersCount }}</div>
                <div class="text-[11px] text-amber-900/70 dark:text-zinc-400">Residents in your unit</div>
            </div>
            <div class="p-4 bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm" aria-hidden="true">
                <flux:icon name="users" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Purok Zone -->
    <div class="group relative overflow-hidden bg-emerald-50/60 dark:bg-zinc-900/40 border border-emerald-200/80 dark:border-zinc-800/80 hover:border-emerald-400/50 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-admin card-glow-admin">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Purok Zone</div>
                <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ $household ? $household->purok_no : '—' }}</div>
                <div class="text-[11px] text-emerald-900/70 dark:text-zinc-400">Registered purok number</div>
            </div>
            <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm" aria-hidden="true">
                <flux:icon name="map-pin" class="size-6" />
            </div>
        </div>
    </div>

    <!-- My Appointments -->
    <div class="group relative overflow-hidden bg-sky-50/60 dark:bg-zinc-900/40 border border-sky-200/80 dark:border-zinc-800/80 hover:border-sky-400/50 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-resident card-glow-resident">
        <div class="absolute inset-0 bg-gradient-to-b from-sky-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div class="text-[10px] font-extrabold uppercase tracking-wider text-sky-850 dark:text-sky-400">My Appointments</div>
                <div class="text-4xl font-black text-sky-950 dark:text-white font-outfit tracking-tight">{{ $upcomingAppointments->count() }}</div>
                <div class="text-[11px] text-sky-900/70 dark:text-zinc-400">Upcoming pickup slots</div>
            </div>
            <div class="p-4 bg-sky-500/20 text-sky-700 dark:text-sky-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm" aria-hidden="true">
                <flux:icon name="calendar" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Household No. -->
    <div class="group relative overflow-hidden bg-violet-50/60 dark:bg-zinc-900/40 border border-violet-200/80 dark:border-zinc-800/80 hover:border-violet-400/50 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-health card-glow-health">
        <div class="absolute inset-0 bg-gradient-to-b from-violet-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div class="text-[10px] font-extrabold uppercase tracking-wider text-violet-800 dark:text-violet-400">Household No.</div>
                <div class="text-4xl font-black text-violet-950 dark:text-white font-outfit tracking-tight">{{ $household ? $household->household_no : '—' }}</div>
                <div class="text-[11px] text-violet-900/70 dark:text-zinc-400">Official registry number</div>
            </div>
            <div class="p-4 bg-violet-500/20 text-violet-700 dark:text-violet-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm" aria-hidden="true">
                <flux:icon name="home" class="size-6" />
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    @php
        $headIconBgClass = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-500';
        $headItemIconClass = 'text-emerald-500';
        $cardBgSexClass = 'bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80';
        if ($residentProfile) {
            if (strtolower($residentProfile->sex) === 'male') {
                $headIconBgClass = 'bg-blue-500/10 text-blue-650 dark:text-blue-400';
                $headItemIconClass = 'text-blue-500';
                $cardBgSexClass = 'bg-blue-50/20 dark:bg-blue-950/10 border-blue-200/50 dark:border-blue-800/40';
            } elseif (strtolower($residentProfile->sex) === 'female') {
                $headIconBgClass = 'bg-pink-500/10 text-pink-650 dark:text-pink-400';
                $headItemIconClass = 'text-pink-500';
                $cardBgSexClass = 'bg-pink-50/20 dark:bg-pink-950/10 border-pink-200/50 dark:border-pink-800/40';
            }
        }
    @endphp

    <!-- Household Profile Card -->
    <div class="{{ $cardBgSexClass }} rounded-2xl p-6 shadow-lg flex flex-col card-glow-household">
        <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
            <div class="p-2 {{ $headIconBgClass }} rounded-xl" aria-hidden="true">
                <flux:icon name="identification" class="size-5" />
            </div>
            <div>
                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">My Profile</h3>
                <p class="text-[11px] text-zinc-500 font-light">Your registered resident information</p>
            </div>
        </div>

        @if($residentProfile)
            <dl class="flex-1 space-y-2.5 overflow-y-auto pr-0.5">
                @php
                    $profileItems = [
                        ['label' => 'Full Name', 'value' => $residentProfile->fullName, 'icon' => 'user'],
                        ['label' => 'Age', 'value' => $residentProfile->age ? $residentProfile->age . ' years old' : null, 'icon' => 'cake'],
                        ['label' => 'Sex', 'value' => $residentProfile->sex, 'icon' => 'heart'],
                        ['label' => 'Civil Status', 'value' => $residentProfile->civil_status, 'icon' => 'sparkles'],
                        ['label' => 'Blood Type', 'value' => $residentProfile->blood_type, 'icon' => 'beaker'],
                        ['label' => 'Religion', 'value' => $residentProfile->religion, 'icon' => 'sun'],
                        ['label' => 'Address', 'value' => $household?->address, 'icon' => 'map-pin'],
                        ['label' => 'Occupation', 'value' => $residentProfile->occupation, 'icon' => 'briefcase'],
                        ['label' => 'Work Status', 'value' => $residentProfile->work_status, 'icon' => 'building-office'],
                        ['label' => 'Education', 'value' => $residentProfile->highest_educational_attainment, 'icon' => 'academic-cap'],
                        ['label' => 'PhilHealth', 'value' => $residentProfile->has_philhealth === 'Yes' ? 'Enrolled' : ($residentProfile->has_philhealth ?: null), 'icon' => 'shield-check'],
                        ['label' => 'National Voter', 'value' => $residentProfile->registered_national_voter, 'icon' => 'check-badge'],
                    ];
                @endphp
                @foreach($profileItems as $item)
                    @if(!empty($item['value']))
                        <div class="flex items-start gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                            <flux:icon name="{{ $item['icon'] }}" class="size-3.5 {{ $headItemIconClass }} mt-0.5 shrink-0" aria-hidden="true" />
                            <div class="min-w-0">
                                <dt class="text-[9px] uppercase tracking-widest text-zinc-400 dark:text-zinc-500 font-bold">{{ $item['label'] }}</dt>
                                <dd class="text-xs font-bold text-zinc-800 dark:text-white truncate">{{ $item['value'] }}</dd>
                            </div>
                        </div>
                    @endif
                @endforeach
            </dl>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-center py-6">
                <flux:icon name="user-circle" class="size-12 text-zinc-300 dark:text-zinc-600 mb-2" aria-hidden="true" />
                <p class="text-xs text-zinc-500">No resident profile linked to your account.</p>
                <p class="text-[11px] text-zinc-400 mt-1">Contact the Barangay Admin to link your record.</p>
            </div>
        @endif

        <div class="pt-4 mt-4 border-t border-zinc-100 dark:border-zinc-800">
            <a href="{{ route('household') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-amber-400/30 text-xs font-semibold text-zinc-700 dark:text-zinc-300 rounded-xl transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500">
                <flux:icon name="home" class="size-3.5" aria-hidden="true" />
                View Household Details
            </a>
        </div>
    </div>

    <!-- Household Members List -->
    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg flex flex-col card-glow-household">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-500/10 text-amber-600 rounded-xl" aria-hidden="true">
                    <flux:icon name="users" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Household Members</h3>
                    <p class="text-[11px] text-zinc-500 font-light">Residents registered under your household</p>
                </div>
            </div>
            <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded-full" aria-label="{{ $householdMembersCount }} members">{{ $householdMembersCount }}</span>
        </div>

        <ul class="space-y-2 flex-1 overflow-y-auto pr-1" role="list" aria-label="Household member list">
            @forelse($householdMembers as $member)
                <li class="flex items-center gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                    @php
                        $avatarGradient = 'from-zinc-400 to-zinc-500';
                        if ($member->sex) {
                            if (strtolower($member->sex) === 'male') {
                                $avatarGradient = 'from-blue-400 to-blue-500';
                            } elseif (strtolower($member->sex) === 'female') {
                                $avatarGradient = 'from-pink-400 to-pink-500';
                            }
                        }
                    @endphp
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $avatarGradient }} flex items-center justify-center text-white text-[10px] font-black shrink-0" aria-hidden="true">
                        {{ strtoupper(substr($member->first_name ?? '?', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-bold text-zinc-900 dark:text-white truncate">{{ $member->fullName }}</div>
                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400">
                            {{ $member->relationship_to_head ?? 'Member' }}
                            @if($member->age) · {{ $member->age }} yrs @endif
                            @if($member->sex) · {{ $member->sex }} @endif
                        </div>
                    </div>
                    @if($member->health_condition && $member->health_condition !== 'None' && $member->health_condition !== '')
                        <span class="shrink-0 inline-flex items-center px-1.5 py-0.5 rounded text-[8px] font-bold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">Health</span>
                    @endif
                </li>
            @empty
                <li class="text-center py-8">
                    <flux:icon name="users" class="size-10 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" aria-hidden="true" />
                    <p class="text-xs text-zinc-500">No household members found.</p>
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Right Column: Appointments + Document History + Announcements -->
    <div class="flex flex-col gap-6">

        <!-- Upcoming Pickup Slots -->
        <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-4 card-glow-household">
            <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-sky-500/10 text-sky-600 rounded-xl" aria-hidden="true">
                        <flux:icon name="calendar" class="size-5" />
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900 dark:text-white font-outfit">My Pickup Slots</h3>
                        <p class="text-[10px] text-zinc-500 font-light">Upcoming document requests</p>
                    </div>
                </div>
                <a href="{{ route('appointments') }}" class="text-[10px] font-bold text-sky-600 dark:text-sky-400 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 rounded">View All</a>
            </div>

            <ul class="space-y-2" role="list" aria-label="Upcoming appointment slots">
                @forelse($upcomingAppointments as $apt)
                    <li class="flex items-start gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                        <div class="p-1.5 rounded-lg bg-sky-500/10 text-sky-600 shrink-0" aria-hidden="true">
                            <flux:icon name="document-text" class="size-3.5" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[11px] font-bold text-zinc-800 dark:text-white truncate">{{ $apt->purpose }}</div>
                            <div class="text-[10px] text-zinc-500 dark:text-zinc-400">
                                @if($apt->appointment_date)
                                    {{ $apt->appointment_date->format('M d, Y') }} @ {{ $apt->appointment_time }}
                                @elseif($apt->status === 'approved-pending')
                                    <span class="text-[9px] text-amber-600 dark:text-amber-400 font-semibold bg-amber-50 dark:bg-amber-950/20 px-2 py-0.5 rounded">Pending Signature</span>
                                @elseif($apt->status === 'cancelled')
                                    <span class="text-[9px] text-red-500 dark:text-red-400 font-semibold bg-red-50 dark:bg-red-950/20 px-2 py-0.5 rounded">Cancelled</span>
                                @else
                                    <span class="text-[9px] text-zinc-400 dark:text-zinc-500 font-semibold bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">Pending Review</span>
                                @endif
                            </div>
                        </div>
                        @if($apt->status === 'approved-pending')
                            <span class="shrink-0 text-[8px] font-bold px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20">Approved-Pending</span>
                        @elseif($apt->status === 'approved')
                            <span class="shrink-0 text-[8px] font-bold px-1.5 py-0.5 rounded bg-sky-500/10 text-sky-700 dark:text-sky-500 border border-sky-500/20">Approved (Ready)</span>
                        @else
                            <span class="shrink-0 text-[8px] font-bold px-1.5 py-0.5 rounded bg-zinc-100 text-zinc-500 border border-zinc-200">{{ ucfirst($apt->status) }}</span>
                        @endif
                    </li>
                @empty
                    <li class="text-center py-4">
                        <flux:icon name="calendar" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-1" aria-hidden="true" />
                        <p class="text-[11px] text-zinc-500">No upcoming pickups scheduled.</p>
                        <a href="{{ route('appointments') }}" class="text-[11px] font-bold text-sky-600 dark:text-sky-400 hover:underline mt-1 inline-block">Book one now →</a>
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Document Pickup History -->
        <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-4">
            <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-zinc-500/10 text-zinc-600 dark:text-zinc-500 rounded-xl" aria-hidden="true">
                        <flux:icon name="clock" class="size-5" />
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900 dark:text-white font-outfit">Pickup History</h3>
                        <p class="text-[10px] text-zinc-500 font-light">Past document requests</p>
                    </div>
                </div>
                <a href="{{ route('appointments') }}" class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">View All</a>
            </div>

            <ul class="space-y-2" role="list" aria-label="Past appointment history">
                @forelse($appointmentHistory as $apt)
                    <li class="flex items-start gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                        <div class="p-1.5 rounded-lg bg-zinc-500/10 text-zinc-600 dark:text-zinc-400 shrink-0" aria-hidden="true">
                            <flux:icon name="document-text" class="size-3.5" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[11px] font-bold text-zinc-800 dark:text-white truncate">{{ $apt->purpose }}</div>
                            <div class="text-[10px] text-zinc-500 dark:text-zinc-400">
                                @if($apt->appointment_date)
                                    {{ $apt->appointment_date->format('M d, Y') }} @ {{ $apt->appointment_time }}
                                @endif
                            </div>
                        </div>
                        @if($apt->status === 'completed')
                            <span class="shrink-0 text-[8px] font-bold px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">Completed</span>
                        @elseif($apt->status === 'cancelled')
                            <span class="shrink-0 text-[8px] font-bold px-1.5 py-0.5 rounded bg-red-500/10 text-red-700 dark:text-red-400 border border-red-500/20">Cancelled</span>
                        @else
                            <span class="shrink-0 text-[8px] font-bold px-1.5 py-0.5 rounded bg-zinc-100 text-zinc-500 border border-zinc-200">{{ ucfirst($apt->status) }}</span>
                        @endif
                    </li>
                @empty
                    <li class="text-center py-4">
                        <flux:icon name="clock" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-1" aria-hidden="true" />
                        <p class="text-[11px] text-zinc-500">No past pickups found.</p>
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Recent Barangay Announcements -->
        <div class="flex-1 flex flex-col bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3">
                <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 rounded-xl" aria-hidden="true">
                    <flux:icon name="megaphone" class="size-5" />
                </div>
                <div>
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-white font-outfit">Barangay Announcements</h3>
                    <p class="text-[10px] text-zinc-500 font-light">Latest from Brgy. Sambog</p>
                </div>
            </div>

            <ul class="flex-1 space-y-2 mt-4" role="list" aria-label="Barangay announcements">
                @forelse($recentAnnouncements as $ann)
                    <li>
                        <button
                            type="button"
                            onclick="openAnnouncementModal({{ $ann->id }}, {{ Js::from($ann->title) }}, {{ Js::from($ann->body) }}, {{ Js::from($ann->published_at ? $ann->published_at->diffForHumans() : 'Draft') }}, {{ Js::from($ann->type ?? 'General') }}, {{ $ann->is_pinned ? 'true' : 'false' }})"
                            class="w-full text-left p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40 cursor-pointer hover:border-emerald-400/50 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-all duration-200 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500"
                            aria-label="Read announcement: {{ $ann->title }}"
                        >
                            <div class="flex items-start gap-2">
                                @if($ann->is_pinned)
                                    <flux:icon name="bookmark" class="size-3 text-emerald-500 mt-0.5 shrink-0" aria-hidden="true" />
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="text-[11px] font-bold text-zinc-800 dark:text-white truncate group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $ann->title }}</div>
                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400 line-clamp-2 mt-0.5">{{ $ann->body }}</div>
                                    <div class="text-[9px] text-zinc-400 mt-1 flex items-center gap-1">
                                        {{ $ann->published_at ? $ann->published_at->diffForHumans() : 'Draft' }}
                                        <span class="text-emerald-500 font-bold">· Tap to read</span>
                                    </div>
                                </div>
                                <flux:icon name="arrow-right" class="size-3 text-zinc-300 group-hover:text-emerald-500 shrink-0 mt-0.5 transition-colors" aria-hidden="true" />
                            </div>
                        </button>
                    </li>
                @empty
                    <li class="text-center py-4">
                        <flux:icon name="megaphone" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-1" aria-hidden="true" />
                        <p class="text-[11px] text-zinc-500">No announcements posted yet.</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
