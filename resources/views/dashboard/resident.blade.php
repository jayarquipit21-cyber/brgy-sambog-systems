@if(auth()->user()->resident && !auth()->user()->resident->place_of_birth)
    <!-- Complete Profile Prompt — amber alert, accessible -->
    <div class="mb-6 relative overflow-hidden bg-amber-50/70 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/80 p-6 rounded-2xl shadow-sm" role="alert">
        <div class="flex items-start sm:items-center gap-4">
            <div class="p-3 bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-2xl shrink-0" aria-hidden="true">
                <flux:icon name="identification" class="size-6" />
            </div>
            <div class="flex-1">
                <h3 class="text-base font-bold text-amber-900 dark:text-amber-300">Complete Your Profile</h3>
                <p class="text-[11px] text-amber-800/80 dark:text-amber-400/80 mt-1">Please provide your extended personal details to ensure the Barangay registry is accurate.</p>
            </div>
            <a href="{{ route('profile.complete') }}" wire:navigate class="shrink-0 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl shadow-sm transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500">
                Complete Now
            </a>
        </div>
    </div>
@endif

<!-- Quick Info Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
    <!-- Age -->
    <div class="group relative overflow-hidden bg-sky-50/60 dark:bg-zinc-900/40 border border-sky-200/80 dark:border-zinc-800/80 hover:border-sky-400/50 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-resident card-glow-resident">
        <div class="absolute inset-0 bg-gradient-to-b from-sky-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div class="text-[10px] font-extrabold uppercase tracking-wider text-sky-800 dark:text-sky-455">My Age</div>
                <div class="text-4xl font-black text-sky-950 dark:text-white font-outfit tracking-tight">{{ $residentProfile?->age ?? '—' }}</div>
                <div class="text-[11px] text-sky-900/70 dark:text-zinc-400">{{ $residentProfile?->age_classification ?? 'Age group' }}</div>
            </div>
            <div class="p-4 bg-sky-500/20 text-sky-700 dark:text-sky-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm" aria-hidden="true">
                <flux:icon name="cake" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Pending Slots -->
    <div class="group relative overflow-hidden bg-amber-50/60 dark:bg-zinc-900/40 border border-amber-200/80 dark:border-zinc-800/80 hover:border-amber-400/50 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-household card-glow-household">
        <div class="absolute inset-0 bg-gradient-to-b from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div class="text-[10px] font-extrabold uppercase tracking-wider text-amber-800 dark:text-amber-400">Pending Slots</div>
                <div class="text-4xl font-black text-amber-950 dark:text-white font-outfit tracking-tight">{{ $upcomingAppointments->count() }}</div>
                <div class="text-[11px] text-amber-900/70 dark:text-zinc-400">Document pickup requests</div>
            </div>
            <div class="p-4 bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm" aria-hidden="true">
                <flux:icon name="calendar" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Vaccination Status -->
    <div class="group relative overflow-hidden bg-emerald-50/60 dark:bg-zinc-900/40 border border-emerald-200/80 dark:border-zinc-800/80 hover:border-emerald-400/50 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-admin card-glow-admin">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Vaccination</div>
                <div class="text-xl font-black font-outfit tracking-tight mt-1 @if($residentProfile?->fully_vaccinated === 'Y') text-emerald-600 dark:text-emerald-450 @elseif($residentProfile?->partially_vaccinated === 'Y') text-amber-600 dark:text-amber-450 @else text-red-650 dark:text-red-400 @endif">
                    @if($residentProfile?->fully_vaccinated === 'Y')
                        Fully Vaccinated
                    @elseif($residentProfile?->partially_vaccinated === 'Y')
                        Partially Vaccinated
                    @elseif($residentProfile?->unvaccinated === 'Y')
                        Unvaccinated
                    @else
                        —
                    @endif
                </div>
                <div class="text-[11px] text-emerald-900/70 dark:text-zinc-400">COVID-19 immunization status</div>
            </div>
            <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm" aria-hidden="true">
                <flux:icon name="shield-check" class="size-6" />
            </div>
        </div>
    </div>
</div>

<!-- Main Content: Profile + Appointments + Announcements -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    @php
        $resIconBgClass = 'bg-violet-500/10 text-violet-650 dark:text-violet-400';
        $resItemIconClass = 'text-violet-500';
        $cardBgSexClass = 'bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80';
        if ($residentProfile) {
            if (strtolower($residentProfile->sex) === 'male') {
                $resIconBgClass = 'bg-blue-500/10 text-blue-650 dark:text-blue-400';
                $resItemIconClass = 'text-blue-500';
                $cardBgSexClass = 'bg-blue-50/20 dark:bg-blue-950/10 border-blue-200/50 dark:border-blue-800/40';
            } elseif (strtolower($residentProfile->sex) === 'female') {
                $resIconBgClass = 'bg-pink-500/10 text-pink-650 dark:text-pink-400';
                $resItemIconClass = 'text-pink-500';
                $cardBgSexClass = 'bg-pink-50/20 dark:bg-pink-950/10 border-pink-200/50 dark:border-pink-800/40';
            }
        }
    @endphp

    <!-- Resident Profile Card -->
    <div class="{{ $cardBgSexClass }} rounded-2xl p-6 shadow-lg flex flex-col card-glow-resident">
        <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
            <div class="p-2 {{ $resIconBgClass }} rounded-xl" aria-hidden="true">
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
                    $resItems = [
                        ['label' => 'Full Name', 'value' => $residentProfile->fullName, 'icon' => 'user'],
                        ['label' => 'Age', 'value' => $residentProfile->age ? $residentProfile->age . ' years old' : null, 'icon' => 'cake'],
                        ['label' => 'Sex', 'value' => $residentProfile->sex, 'icon' => 'heart'],
                        ['label' => 'Civil Status', 'value' => $residentProfile->civil_status, 'icon' => 'sparkles'],
                        ['label' => 'Blood Type', 'value' => $residentProfile->blood_type, 'icon' => 'beaker'],
                        ['label' => 'Religion', 'value' => $residentProfile->religion, 'icon' => 'sun'],
                        ['label' => 'Occupation', 'value' => $residentProfile->occupation, 'icon' => 'briefcase'],
                        ['label' => 'Work Status', 'value' => $residentProfile->work_status, 'icon' => 'building-office'],
                        ['label' => 'Education', 'value' => $residentProfile->highest_educational_attainment, 'icon' => 'academic-cap'],
                        ['label' => 'PhilHealth', 'value' => $residentProfile->has_philhealth === 'Yes' ? 'Enrolled' : ($residentProfile->has_philhealth ?: null), 'icon' => 'shield-check'],
                        ['label' => 'Health Condition', 'value' => ($residentProfile->health_condition && $residentProfile->health_condition !== 'None') ? $residentProfile->health_condition : null, 'icon' => 'heart'],
                        ['label' => 'Vulnerable Sector', 'value' => $residentProfile->vulnerable_sector, 'icon' => 'flag'],
                        ['label' => 'National Voter', 'value' => $residentProfile->registered_national_voter, 'icon' => 'check-badge'],
                    ];
                @endphp
                @foreach($resItems as $item)
                    @if(!empty($item['value']))
                        <div class="flex items-start gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                            <flux:icon name="{{ $item['icon'] }}" class="size-3.5 {{ $resItemIconClass }} mt-0.5 shrink-0" aria-hidden="true" />
                            <div class="min-w-0">
                                <dt class="text-[9px] uppercase tracking-widest text-zinc-400 dark:text-zinc-500 font-bold">{{ $item['label'] }}</dt>
                                <dd class="text-xs font-bold text-zinc-800 dark:text-white truncate">{{ $item['value'] }}</dd>
                            </div>
                        </div>
                    @endif
                @endforeach
            </dl>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-center py-8">
                <flux:icon name="user-circle" class="size-12 text-zinc-300 dark:text-zinc-600 mb-2" aria-hidden="true" />
                <p class="text-xs text-zinc-500">No resident profile linked to your account.</p>
                <p class="text-[11px] text-zinc-400 mt-1">Contact the Barangay Admin to link your record.</p>
            </div>
        @endif
    </div>

    <!-- Appointments + Announcements -->
    <div class="lg:col-span-2 flex flex-col gap-6">

        <!-- Document Request Component with Dropdown Selection -->
        <livewire:book-appointment />

        <!-- Upcoming Document Pickup Slots (Table) -->
        <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-4 card-glow-resident">
            <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-sky-500/10 text-sky-600 rounded-xl" aria-hidden="true">
                        <flux:icon name="calendar" class="size-5" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">My Document Pickup Slots</h3>
                        <p class="text-[11px] text-zinc-500 font-light">Pickup slots scheduled with the Barangay Hall</p>
                    </div>
                </div>
                <a href="{{ route('appointments') }}" class="text-xs font-bold text-sky-600 dark:text-sky-400 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 rounded">Book or View All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800 text-[10px] text-zinc-500 uppercase tracking-widest">
                            <th class="pb-3 font-bold" scope="col">Purpose / Document</th>
                            <th class="pb-3 font-bold" scope="col">Scheduled Pick up</th>
                            <th class="pb-3 font-bold text-right" scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 text-xs text-zinc-700 dark:text-zinc-300">
                        @forelse($upcomingAppointments as $apt)
                            <tr class="odd:bg-zinc-50/50 hover:bg-sky-50/50 dark:odd:bg-zinc-900/20 dark:hover:bg-sky-950/10 transition-colors">
                                <td class="py-3.5 font-bold text-zinc-900 dark:text-white font-outfit">{{ $apt->purpose }}</td>
                                <td class="py-3.5 font-semibold text-zinc-600 dark:text-zinc-400">
                                    @if($apt->appointment_date)
                                        {{ $apt->appointment_date->format('M d, Y') }} <span class="text-sky-500 mx-1">@</span> {{ $apt->appointment_time }}
                                    @elseif($apt->status === 'approved-pending')
                                        <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold bg-amber-50 dark:bg-amber-950/20 px-2 py-0.5 rounded">Pending Signature</span>
                                    @elseif($apt->status === 'cancelled')
                                        <span class="text-xs text-red-500 dark:text-red-400 font-semibold bg-red-50 dark:bg-red-950/20 px-2 py-0.5 rounded">N/A</span>
                                    @else
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-semibold bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">Pending Review</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right">
                                    @if($apt->status === 'approved-pending')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-amber-500/10 text-amber-700 dark:text-amber-500 border border-amber-500/25">Approved-Pending</span>
                                    @elseif($apt->status === 'approved')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-sky-500/10 text-sky-700 dark:text-sky-500 border border-sky-500/25">Approved (Ready)</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">{{ ucfirst($apt->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center">
                                    <flux:icon name="calendar" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" aria-hidden="true" />
                                    <p class="text-xs text-zinc-500">No upcoming pickup slots found.</p>
                                    <a href="{{ route('appointments') }}" class="text-xs font-bold text-sky-600 dark:text-sky-400 hover:underline mt-1 inline-block">Book one now →</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pickup History (Table) -->
        <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-4 card-glow-resident">
            <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-zinc-500/10 text-zinc-600 dark:text-zinc-500 rounded-xl" aria-hidden="true">
                        <flux:icon name="clock" class="size-5" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Pickup History</h3>
                        <p class="text-[11px] text-zinc-500 font-light">Past document requests</p>
                    </div>
                </div>
                <a href="{{ route('appointments') }}" class="text-xs font-bold text-sky-600 dark:text-sky-400 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 rounded">View All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800 text-[10px] text-zinc-500 uppercase tracking-widest">
                            <th class="pb-3 font-bold" scope="col">Purpose / Document</th>
                            <th class="pb-3 font-bold" scope="col">Date Picked up</th>
                            <th class="pb-3 font-bold text-right" scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 text-xs text-zinc-700 dark:text-zinc-300">
                        @forelse($appointmentHistory as $apt)
                            <tr class="odd:bg-zinc-50/50 hover:bg-sky-50/50 dark:odd:bg-zinc-900/20 dark:hover:bg-sky-950/10 transition-colors">
                                <td class="py-3.5 font-bold text-zinc-900 dark:text-white font-outfit">{{ $apt->purpose }}</td>
                                <td class="py-3.5 font-semibold text-zinc-600 dark:text-zinc-400">
                                    @if($apt->appointment_date)
                                        {{ $apt->appointment_date->format('M d, Y') }} <span class="text-sky-500 mx-1">@</span> {{ $apt->appointment_time }}
                                    @else
                                        <span class="text-xs text-zinc-400">N/A</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right">
                                    @if($apt->status === 'completed')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-sky-500/10 text-sky-700 dark:text-sky-400 border border-sky-500/25">Completed</span>
                                    @elseif($apt->status === 'cancelled')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-red-500/10 text-red-700 dark:text-red-500 border border-red-500/25">Cancelled</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">{{ ucfirst($apt->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center">
                                    <flux:icon name="clock" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" aria-hidden="true" />
                                    <p class="text-xs text-zinc-500">No past pickups found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Barangay Announcements Grid -->
        <div class="flex-1 flex flex-col bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg card-glow-resident">
            <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3">
                <div class="p-2 bg-sky-500/10 text-sky-600 rounded-xl" aria-hidden="true">
                    <flux:icon name="megaphone" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Barangay Announcements</h3>
                    <p class="text-[11px] text-zinc-500 font-light">Latest updates from Brgy. Sambog</p>
                </div>
            </div>

            <ul class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4 content-start" role="list" aria-label="Barangay announcements">
                @forelse($recentAnnouncements as $ann)
                    <li>
                        <button
                            type="button"
                            onclick="openAnnouncementModal({{ $ann->id }}, {{ Js::from($ann->title) }}, {{ Js::from($ann->body) }}, {{ Js::from($ann->published_at ? $ann->published_at->diffForHumans() : 'Draft') }}, {{ Js::from($ann->type ?? 'General') }}, {{ $ann->is_pinned ? 'true' : 'false' }})"
                            class="w-full text-left p-4 rounded-2xl bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-800/40 dark:to-zinc-900/40 border border-zinc-100 dark:border-zinc-700/40 space-y-2 cursor-pointer hover:border-sky-400/50 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500"
                            aria-label="Read announcement: {{ $ann->title }}"
                        >
                            <div class="flex items-center gap-2">
                                @php
                                    $annColor = 'text-zinc-400';
                                    $typeBadgeColor = 'text-emerald-600 dark:text-emerald-400';
                                    if ($ann->type) {
                                        if (strtolower($ann->type) === 'alert') {
                                            $annColor = 'text-red-500';
                                            $typeBadgeColor = 'text-red-650 dark:text-red-400';
                                        } elseif (strtolower($ann->type) === 'event') {
                                            $annColor = 'text-violet-500';
                                            $typeBadgeColor = 'text-violet-650 dark:text-violet-400';
                                        } elseif (strtolower($ann->type) === 'general') {
                                            $annColor = 'text-emerald-500';
                                            $typeBadgeColor = 'text-emerald-650 dark:text-emerald-400';
                                        }
                                    }
                                @endphp
                                @if($ann->is_pinned)
                                    <flux:icon name="bookmark" class="size-3.5 text-amber-500 shrink-0" aria-hidden="true" />
                                @else
                                    <flux:icon name="megaphone" class="size-3.5 {{ $annColor }} shrink-0" aria-hidden="true" />
                                @endif
                                <span class="text-[9px] uppercase tracking-widest font-bold {{ $typeBadgeColor }}">{{ $ann->type ?? 'General' }}</span>
                            </div>
                            <div class="text-xs font-bold text-zinc-800 dark:text-white line-clamp-2 group-hover:text-sky-700 dark:group-hover:text-sky-400 transition-colors">{{ $ann->title }}</div>
                            <div class="text-[10px] text-zinc-500 dark:text-zinc-400 line-clamp-3">{{ $ann->body }}</div>
                            <div class="text-[9px] text-zinc-400 pt-1 border-t border-zinc-100 dark:border-zinc-700/50 flex items-center justify-between">
                                <span>{{ $ann->published_at ? $ann->published_at->diffForHumans() : 'Draft' }}</span>
                                <span class="text-sky-600 dark:text-sky-400 font-bold">Read more →</span>
                            </div>
                        </button>
                    </li>
                @empty
                    <li class="col-span-3 text-center py-8">
                        <flux:icon name="megaphone" class="size-10 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" aria-hidden="true" />
                        <p class="text-xs text-zinc-500">No announcements posted yet.</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
