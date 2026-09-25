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
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

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

    <!-- Household Demographics Chart -->
    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg flex flex-col card-glow-household font-outfit">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-500/10 text-amber-600 rounded-xl" aria-hidden="true">
                    <flux:icon name="chart-pie" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Household Demographics</h3>
                    <p class="text-[11px] text-zinc-500 font-light">Age and family breakdown of members</p>
                </div>
            </div>
            <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded-full">{{ $householdMembersCount }} registered</span>
        </div>

        <div class="relative flex-1 w-full flex flex-col gap-4" data-chart-init="initHouseholdChart" data-chart-labels="{{ json_encode($householdAgeLabels ?? []) }}" data-chart-values="{{ json_encode($householdAgeValues ?? []) }}">
            <div class="w-full h-44 relative">
                <canvas id="householdAgeChart" class="w-full h-full" aria-label="Bar chart showing Household Age Demographics" role="img"></canvas>
            </div>

            <div id="household-legend" class="grid grid-cols-2 gap-2 text-xs pt-2 border-t border-zinc-100 dark:border-zinc-800"></div>
        </div>

        <script data-navigate-eval>
            window.initHouseholdChart = function (containerEl) {
                const el = containerEl || document.querySelector('[data-chart-init="initHouseholdChart"]');
                const labels = el && el.dataset.chartLabels ? JSON.parse(el.dataset.chartLabels) : @json($householdAgeLabels ?? []);
                const values = el && el.dataset.chartValues ? JSON.parse(el.dataset.chartValues) : @json($householdAgeValues ?? []);

                window.renderChartWhenReady('householdAgeChart', function () {
                    const isDark = document.documentElement.classList.contains('dark');
                    const labelColor = isDark ? '#a1a1aa' : '#71717a';
                    const gridColor = isDark ? 'rgba(63, 63, 70, 0.4)' : 'rgba(228, 228, 231, 0.6)';
                    const total = values.reduce((a, b) => a + b, 0);

                    const colors = ['bg-amber-500', 'bg-emerald-500', 'bg-blue-500', 'bg-violet-500', 'bg-pink-500'];
                    let legendHtml = '';
                    if (total === 0 || labels.length === 0) {
                        legendHtml = `
                            <div class="col-span-full text-center py-2 text-xs text-zinc-400 font-medium">
                                No registered household members yet
                            </div>
                        `;
                    } else {
                        labels.forEach((label, i) => {
                            const val = values[i] || 0;
                            if (val > 0) {
                                const colorClass = colors[i % colors.length];
                                legendHtml += `
                                    <div class="flex items-center justify-between p-2 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                                        <div class="flex items-center gap-1.5 min-w-0 truncate">
                                            <span class="w-2 h-2 rounded-full ${colorClass} shrink-0"></span>
                                            <span class="text-[10px] font-bold text-zinc-700 dark:text-zinc-300 truncate">${label}</span>
                                        </div>
                                        <span class="text-xs font-black text-zinc-900 dark:text-white shrink-0 ml-1">${val}</span>
                                    </div>
                                `;
                            }
                        });
                        if (!legendHtml) {
                            legendHtml = `<div class="col-span-full text-center py-2 text-xs text-zinc-400 font-medium">No age data recorded</div>`;
                        }
                    }
                    const legendEl = document.getElementById('household-legend');
                    if (legendEl) legendEl.innerHTML = legendHtml;

                    return {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Family Members',
                                data: values,
                                backgroundColor: [
                                    'rgba(245, 158, 11, 0.85)',
                                    'rgba(16, 185, 129, 0.85)',
                                    'rgba(59, 130, 246, 0.85)',
                                    'rgba(139, 92, 246, 0.85)',
                                    'rgba(236, 72, 153, 0.85)'
                                ],
                                borderColor: [
                                    'rgba(217, 119, 6, 0.9)',
                                    'rgba(5, 150, 105, 0.9)',
                                    'rgba(37, 99, 235, 0.9)',
                                    'rgba(124, 58, 237, 0.9)',
                                    'rgba(219, 39, 119, 0.9)'
                                ],
                                borderWidth: 1,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: gridColor },
                                    ticks: { color: labelColor, font: { family: 'Instrument Sans' }, precision: 0 }
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { color: labelColor, font: { family: 'Instrument Sans' } }
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const val = context.raw || 0;
                                            return ` Members: ${val.toLocaleString()}`;
                                        }
                                    }
                                }
                            }
                        }
                    };
                });
            };
            window.initHouseholdChart();
        </script>
    </div>

    <!-- Row 2: Announcements + Appointments + Document History (spans full 2 cols) -->
    <div class="lg:col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Barangay Announcements -->
        <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-4 card-glow-household">
            <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3">
                <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 rounded-xl" aria-hidden="true">
                    <flux:icon name="megaphone" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Barangay Announcements</h3>
                    <p class="text-[11px] text-zinc-500 font-light">Latest updates from Brgy. Sambog</p>
                </div>
            </div>

            <ul class="space-y-3" role="list" aria-label="Barangay announcements">
                @forelse($recentAnnouncements as $ann)
                    @php
                        $eventSchedule = '';
                        if (($ann->type === 'event' || $ann->event_date) && $ann->event_date) {
                            if ($ann->event_end_date) {
                                $eventSchedule = $ann->event_date->isSameDay($ann->event_end_date)
                                    ? $ann->event_date->format('F j, Y \a\t g:i A') . ' – ' . $ann->event_end_date->format('g:i A')
                                    : $ann->event_date->format('M j, Y g:i A') . ' → ' . $ann->event_end_date->format('M j, Y g:i A');
                            } else {
                                $eventSchedule = $ann->event_date->format('F j, Y \a\t g:i A');
                            }
                        }
                    @endphp
                    <li>
                        <button
                            type="button"
                            onclick="openAnnouncementModal({{ $ann->id }}, {{ Js::from($ann->title) }}, {{ Js::from($ann->body) }}, {{ Js::from($ann->published_at ? $ann->published_at->diffForHumans() : 'Draft') }}, '', {{ $ann->is_pinned ? 'true' : 'false' }}, {{ Js::from($eventSchedule) }}, {{ Js::from($ann->event_location ?? '') }})"
                            class="w-full text-left p-3.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40 cursor-pointer hover:border-emerald-400/50 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-all duration-200 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500"
                            aria-label="Read announcement: {{ $ann->title }}"
                        >
                            <div class="flex items-start gap-2.5">
                                @if($ann->is_pinned)
                                    <flux:icon name="bookmark" class="size-4 text-amber-500 mt-0.5 shrink-0" aria-hidden="true" />
                                @else
                                    <flux:icon name="megaphone" class="size-4 text-emerald-500 mt-0.5 shrink-0" aria-hidden="true" />
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        @if($ann->is_pinned)
                                            <span class="text-[9px] uppercase tracking-widest font-bold px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20">Pinned</span>
                                        @endif
                                        @if($ann->type === 'event' || $ann->event_date)
                                            <span class="text-[9px] uppercase tracking-widest font-bold px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">Event</span>
                                        @endif
                                    </div>
                                    <div class="text-xs font-bold text-zinc-800 dark:text-white truncate group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $ann->title }}</div>
                                    @if($eventSchedule)
                                        <div class="text-[10px] font-semibold text-emerald-700 dark:text-emerald-300 flex items-center gap-1 bg-emerald-50 dark:bg-emerald-950/30 px-2 py-0.5 rounded-lg border border-emerald-500/20 mt-1">
                                            <flux:icon name="calendar" class="size-3 shrink-0 text-emerald-500" />
                                            <span class="truncate">{{ $eventSchedule }}</span>
                                        </div>
                                    @endif
                                    <div class="text-[11px] text-zinc-500 dark:text-zinc-400 line-clamp-2 mt-0.5">{{ $ann->body }}</div>
                                    <div class="text-[9px] text-zinc-400 mt-1.5 flex items-center justify-between">
                                        <span>{{ $ann->published_at ? $ann->published_at->diffForHumans() : 'Draft' }}</span>
                                        <span class="text-emerald-600 dark:text-emerald-400 font-bold">Tap to read →</span>
                                    </div>
                                </div>
                            </div>
                        </button>
                    </li>
                @empty
                    <li class="text-center py-6">
                        <flux:icon name="megaphone" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-1" aria-hidden="true" />
                        <p class="text-xs text-zinc-500">No announcements posted yet.</p>
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Column 2: Pickup Slots & History -->
        <div class="space-y-6">
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
                    <a href="{{ route('services.documents') }}" class="text-[10px] font-bold text-sky-600 dark:text-sky-400 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 rounded">View All</a>
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
                            <a href="{{ route('services.documents') }}" class="text-[11px] font-bold text-sky-600 dark:text-sky-400 hover:underline mt-1 inline-block">Book one now →</a>
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
                    <a href="{{ route('services.documents') }}" class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">View All</a>
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
        </div>
    </div>
</div>
