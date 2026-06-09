<x-layouts::app :title="__('Workspace Dashboard')">
    <div class="space-y-8 pb-12">
        
        <!-- Premium Welcome Banner with High-Contrast Animated Gradients -->
        <div class="relative overflow-hidden rounded-3xl border border-emerald-300/30 dark:border-emerald-700/40 bg-gradient-to-br from-emerald-500 via-emerald-650 to-teal-600 dark:from-zinc-950 dark:via-emerald-950 dark:to-zinc-900 p-8 shadow-2xl transition-all duration-300">
            <!-- Background glow orbs -->
            <div class="absolute -right-16 -bottom-16 h-64 w-64 rounded-full bg-gradient-to-tr from-emerald-400/40 to-teal-300/40 dark:from-emerald-500/30 dark:to-teal-400/30 blur-3xl"></div>
            <div class="absolute -left-16 -top-16 h-64 w-64 rounded-full bg-gradient-to-br from-teal-400/30 to-emerald-300/30 dark:from-teal-500/20 dark:to-emerald-400/20 blur-3xl"></div>
            <!-- Subtle green shimmer across top -->
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/40 dark:via-emerald-400/50 to-transparent"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 border border-white/30 text-white dark:bg-emerald-500/15 dark:border-emerald-400/40 dark:text-emerald-300 rounded-full text-[10px] font-extrabold tracking-wider uppercase">
                        <span class="h-1.5 w-1.5 rounded-full bg-white dark:bg-emerald-400 animate-ping"></span>
                        Brgy. Sambog, Corella, Bohol Workspace
                    </span>
                    <h2 class="text-3xl font-black font-outfit sm:text-4xl text-white tracking-tight leading-none drop-shadow-sm">
                        Hello, <span class="bg-gradient-to-r from-white via-emerald-100 to-teal-50 dark:from-emerald-300 dark:via-teal-200 dark:to-cyan-300 bg-clip-text text-transparent font-black">{{ auth()->user()->name }}</span>
                    </h2>
                    <p class="text-white/90 dark:text-zinc-200 text-xs sm:text-sm max-w-2xl font-normal leading-relaxed">
                        Welcome to your official inhabitant management and public services center. Access filtered registries, Purok demographic matrices, and pickup slots securely.
                    </p>
                </div>

                <!-- Quick Badge with user role -->
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 dark:bg-zinc-950/80 dark:border-emerald-800/60 px-4 py-3 rounded-2xl w-fit shadow-xl">
                    <div class="p-2.5 rounded-xl bg-white/20 text-white dark:bg-emerald-400/20 dark:text-emerald-300">
                        <flux:icon name="shield-check" class="size-5" />
                    </div>
                    <div>
                        <div class="text-[9px] uppercase tracking-widest text-emerald-100 dark:text-zinc-400 font-extrabold">Active Role</div>
                        <div class="text-xs font-black text-white font-outfit">
                            @if(auth()->user()->isAdmin())
                                Barangay Administrator
                            @elseif(auth()->user()->isHealthAdmin())
                                Public Health Officer
                            @elseif(auth()->user()->isHouseholdHead())
                                Registered Household Head
                            @else
                                Resident Inhabitant
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. ADMIN DASHBOARD VIEW -->
        @if(auth()->user()->isAdmin())
            <!-- Dynamic Stats Hub with Vibrant HSL Colorful Cards (Light & Dark Support) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Inhabitants Card -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-250 dark:border-zinc-800/80 hover:border-emerald-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Total Population</span>
                            <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ number_format($totalResidents) }}</div>
                            <span class="inline-flex items-center text-[10px] text-emerald-900 dark:text-zinc-400 font-bold bg-emerald-100 dark:bg-emerald-950/20 px-2 py-0.5 rounded-full">
                                <flux:icon.arrow-trending-up class="size-3 text-emerald-600 dark:text-emerald-500 mr-1" />
                                Registered inhabitants
                            </span>
                        </div>
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-md">
                            <flux:icon name="users" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Households Card -->
                <div class="group relative overflow-hidden bg-teal-50/70 dark:bg-zinc-900/40 border border-teal-250 dark:border-zinc-800/80 hover:border-teal-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-teal-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-teal-800 dark:text-teal-400">Households Tracked</span>
                            <div class="text-4xl font-black text-teal-950 dark:text-white font-outfit tracking-tight">{{ number_format($totalHouseholds) }}</div>
                            <span class="inline-flex items-center text-[10px] text-teal-900 dark:text-zinc-400 font-bold bg-teal-100 dark:bg-teal-950/20 px-2 py-0.5 rounded-full">
                                <flux:icon.home class="size-3 text-teal-600 dark:text-teal-500 mr-1" />
                                Unique family zones
                            </span>
                        </div>
                        <div class="p-4 bg-teal-500/20 text-teal-700 dark:text-teal-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-md">
                            <flux:icon name="home" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Document Pickups Card -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-250 dark:border-zinc-800/80 hover:border-emerald-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Pending Pickups</span>
                            <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ number_format($pendingAppointments) }}</div>
                            <span class="inline-flex items-center text-[10px] text-emerald-900 dark:text-emerald-400 font-bold bg-emerald-100 dark:bg-emerald-500/10 border border-emerald-300 dark:border-emerald-500/20 px-2.5 py-0.5 rounded-full">
                                Awaiting Slot Approval
                            </span>
                        </div>
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-md">
                            <flux:icon name="calendar" class="size-6" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Grid: Quick Actions and Purok Demographics Graph -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Quick Actions Workspace Hub -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3 border-b border-zinc-100 dark:border-zinc-800/80 pb-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 rounded-xl">
                                <flux:icon name="command" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Quick Actions Hub</h3>
                                <p class="text-[11px] text-zinc-500 font-medium">Direct workspace gateways</p>
                            </div>
                        </div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed font-light">
                            Use these pre-configured shortcuts to manage administrative databases, verify inhabitant credentials, and issue clearances.
                        </p>
                    </div>

                    <div class="space-y-3 pt-4">
                        <a href="{{ route('rbi') }}" class="group flex items-center justify-between p-3.5 bg-zinc-50 hover:bg-emerald-50/50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500/20 rounded-xl transition duration-300">
                            <div class="flex items-center gap-3">
                                <flux:icon name="users" class="size-4 text-emerald-600 dark:text-emerald-500 group-hover:scale-110 transition" />
                                <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition">Inhabitants Registry (RBI)</span>
                            </div>
                            <flux:icon.arrow-right class="size-3.5 text-zinc-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition" />
                        </a>

                        <a href="{{ route('appointments') }}" class="group flex items-center justify-between p-3.5 bg-zinc-50 hover:bg-emerald-50/50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500/20 rounded-xl transition duration-300">
                            <div class="flex items-center gap-3">
                                <flux:icon name="calendar" class="size-4 text-emerald-600 dark:text-emerald-500 group-hover:scale-110 transition" />
                                <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition">Clearances & Appointments</span>
                            </div>
                            <flux:icon.arrow-right class="size-3.5 text-zinc-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition" />
                        </a>

                        <a href="{{ route('admin.announcements') }}" class="group flex items-center justify-between p-3.5 bg-zinc-50 hover:bg-emerald-50/50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500/20 rounded-xl transition duration-300">
                            <div class="flex items-center gap-3">
                                <flux:icon name="megaphone" class="size-4 text-emerald-600 dark:text-emerald-500 group-hover:scale-110 transition" />
                                <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition">Manage Announcements</span>
                            </div>
                            <flux:icon.arrow-right class="size-3.5 text-zinc-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition" />
                        </a>

                        <a href="{{ route('health') }}" class="group flex items-center justify-between p-3.5 bg-zinc-50 hover:bg-teal-50/50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-teal-500/20 rounded-xl transition duration-300">
                            <div class="flex items-center gap-3">
                                <flux:icon name="heart" class="size-4 text-teal-600 dark:text-teal-500 group-hover:scale-110 transition" />
                                <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition">Health Concerns Desk</span>
                            </div>
                            <flux:icon.arrow-right class="size-3.5 text-zinc-400 group-hover:text-teal-600 group-hover:translate-x-1 transition" />
                        </a>
                    </div>
                </div>

                <!-- Purok Zone Demographics Visualization (Interactive SVG Chart) -->
                <div class="lg:col-span-2 bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-teal-500/10 text-teal-650 dark:text-teal-500 rounded-xl">
                                <flux:icon name="chart-bar" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Purok Demographics Distribution</h3>
                                <p class="text-[11px] text-zinc-500 font-light">Visual population density by municipal zone</p>
                            </div>
                        </div>
                        <span class="text-[10px] text-zinc-650 dark:text-zinc-400 font-semibold bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 px-2.5 py-1 rounded-lg">Real-time Sync</span>
                    </div>

                    <!-- Purok Demographics Chart (Chart.js) -->
                    <div class="relative pt-4 space-y-4">
                        <div class="h-56 px-2">
                            <canvas id="purokChart" class="w-full h-full"></canvas>
                        </div>

                        <div class="flex items-center justify-between text-[10px] text-zinc-650 dark:text-zinc-400 border-t border-zinc-150 dark:border-zinc-800/80 pt-3 font-semibold">
                            <span id="purok-highest">Highest density: <strong class="text-emerald-600 dark:text-emerald-400 font-black">—</strong></span>
                            <span id="purok-total">Total monitored zones: <strong class="text-zinc-900 dark:text-white font-bold">—</strong></span>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            (function () {
                                const labels = @json($purokLabels ?? []);
                                const values = @json($purokValues ?? []);

                                const ctx = document.getElementById('purokChart');
                                if (!ctx) return;

                                const chart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Residents',
                                            data: values,
                                            backgroundColor: labels.map(() => 'rgba(16, 185, 129, 0.85)'),
                                            borderColor: labels.map(() => 'rgba(6, 95, 70, 0.9)'),
                                            borderWidth: 1,
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            y: { beginAtZero: true }
                                        },
                                        plugins: {
                                            legend: { display: false }
                                        }
                                    }
                                });

                                // Update summary info
                                if (labels.length && values.length) {
                                    const totalZones = labels.length;
                                    const maxIndex = values.indexOf(Math.max(...values));
                                    const highestLabel = labels[maxIndex] || '—';
                                    const highestValue = values[maxIndex] || 0;
                                    document.getElementById('purok-highest').innerHTML = `Highest density: <strong class="text-emerald-600 dark:text-emerald-400 font-black">${highestLabel} (${highestValue})</strong>`;
                                    document.getElementById('purok-total').innerHTML = `Total monitored zones: <strong class="text-zinc-900 dark:text-white font-bold">${totalZones} Puroks</strong>`;
                                } else {
                                    document.getElementById('purok-highest').innerHTML = 'No purok data available';
                                    document.getElementById('purok-total').innerHTML = '';
                                }
                            })();
                        </script>
                    </div>
                </div>

            </div>

            <!-- Recent Activity Table -->
            <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <flux:icon name="inbox-arrow-down" class="size-5 text-emerald-600 dark:text-emerald-500" />
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white font-outfit">Recent Appointment & Document Requests</h3>
                        </div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 font-light">Overview of the latest 5 bookings. Go to Appointments to approve or reject.</p>
                    </div>
                    <a href="{{ route('appointments') }}" class="w-fit inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500/30 text-xs font-bold text-emerald-600 dark:text-emerald-400 rounded-xl transition duration-300 shadow-sm">
                        Manage Slots
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-800 text-[10px] text-zinc-500 uppercase tracking-widest">
                                <th class="pb-3.5 font-bold">Resident Inhabitant</th>
                                <th class="pb-3.5 font-bold">Purpose / Documents</th>
                                <th class="pb-3.5 font-bold">Scheduled Collection</th>
                                <th class="pb-3.5 font-bold text-right">Status State</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 text-xs text-zinc-700 dark:text-zinc-300">
                            @forelse($recentAppointments as $apt)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-850/20 transition-colors">
                                    <td class="py-4 font-bold text-zinc-900 dark:text-white font-outfit">{{ $apt->user->name }}</td>
                                    <td class="py-4">{{ $apt->purpose }}</td>
                                    <td class="py-4 text-zinc-600 dark:text-zinc-400 font-semibold">{{ $apt->appointment_date }} <span class="text-emerald-500 font-bold mx-1">@</span> {{ $apt->appointment_time }}</td>
                                    <td class="py-4 text-right">
                                        @if($apt->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/10 text-amber-700 dark:text-amber-500 border border-amber-500/20">Pending review</span>
                                        @elseif($apt->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/10 text-emerald-700 dark:text-emerald-500 border border-emerald-500/20">Approved / Processed</span>
                                        @elseif($apt->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border border-indigo-500/20">Completed</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-500 border border-zinc-200 dark:border-zinc-700">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-zinc-550 text-xs font-light">No recent appointments found in the system registry.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        <!-- 2. HEALTH OFFICE ADMIN DASHBOARD VIEW -->
        @elseif(auth()->user()->isHealthAdmin())
            <!-- Dynamic Health Metrics Dashboard Grid (Vibrant Colors) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Case Records -->
                <div class="group relative overflow-hidden bg-teal-50/70 dark:bg-zinc-900/40 border border-teal-250 dark:border-zinc-800/80 hover:border-teal-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-teal-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-teal-800 dark:text-teal-400">Case Records</span>
                            <div class="text-4xl font-black text-teal-700 dark:text-teal-500 font-outfit tracking-tight">{{ number_format($totalWithConditions) }}</div>
                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400 font-semibold">Active conditions</span>
                        </div>
                        <div class="p-3 bg-teal-500/20 text-teal-700 dark:text-teal-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="heart" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Fully Vaccinated -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-250 dark:border-zinc-800/80 hover:border-emerald-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Immunized</span>
                            <div class="text-4xl font-black text-emerald-700 dark:text-emerald-500 font-outfit tracking-tight">{{ number_format($totalVaccinated) }}</div>
                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400 font-semibold">Fully vaccinated</span>
                        </div>
                        <div class="p-3 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="shield-check" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Pediatric Cases -->
                <div class="group relative overflow-hidden bg-cyan-50/70 dark:bg-zinc-900/40 border border-cyan-250 dark:border-zinc-800/80 hover:border-cyan-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-cyan-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-cyan-800 dark:text-cyan-450">Pediatric Cases</span>
                            <div class="text-4xl font-black text-cyan-700 dark:text-cyan-500 font-outfit tracking-tight">{{ number_format($pediatricCases) }}</div>
                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400 font-semibold">Children (age &le; 12)</span>
                        </div>
                        <div class="p-3 bg-cyan-500/20 text-cyan-700 dark:text-cyan-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="face-smile" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Senior Cases -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-250 dark:border-zinc-800/80 hover:border-emerald-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Senior Cases</span>
                            <div class="text-4xl font-black text-emerald-700 dark:text-emerald-500 font-outfit tracking-tight">{{ number_format($seniorCases) }}</div>
                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400 font-semibold">Seniors (age &ge; 60)</span>
                        </div>
                        <div class="p-3 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="identification" class="size-6" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health Coverage Grid: Graphs & Action Panel -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Vaccination Coverage Progress Bar Card -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-6">
                    <div class="flex items-center gap-3 border-b border-zinc-150 dark:border-zinc-800 pb-3">
                        <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 rounded-xl">
                            <flux:icon name="arrow-trending-up" class="size-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Vaccination Coverage Progress</h3>
                            <p class="text-[11px] text-zinc-500 font-light">Immunization statistics across registered inhabitants</p>
                        </div>
                    </div>

                    @php
                        $percentage = $totalResidents > 0 ? ($totalVaccinated / $totalResidents) * 100 : 0;
                    @endphp

                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-xs font-semibold text-zinc-600 dark:text-zinc-400">
                            <span>Fully Vaccinated ({{ number_format($totalVaccinated) }} / {{ number_format($totalResidents) }})</span>
                            <span class="text-emerald-700 dark:text-emerald-400 font-black">{{ number_format($percentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-zinc-100 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-full h-4 overflow-hidden p-0.5">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-[10px] text-zinc-550 dark:text-zinc-550 pt-2 border-t border-zinc-100 dark:border-zinc-800/50">
                            <div>Unvaccinated: <strong class="text-zinc-800 dark:text-white font-semibold">{{ number_format($totalResidents - $totalVaccinated) }} residents</strong></div>
                            <div class="text-right">Demographics source: <strong class="text-zinc-800 dark:text-white font-semibold">RBI Database</strong></div>
                        </div>
                    </div>
                </div>

                <!-- Secure Health Database Access Panel -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 border-b border-zinc-150 dark:border-zinc-800 pb-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-650 dark:text-emerald-500 rounded-xl">
                                <flux:icon name="shield-check" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Secure Health Database Portal</h3>
                                <p class="text-[11px] text-zinc-500 font-light">Encrypted dynamic database querying</p>
                            </div>
                        </div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed font-light">
                            Your dashboard has query-layer restrictions configured to secure inhabitant privacy. You are authorized to manage health indices, filter chronic conditions, and update demographic immunization records.
                        </p>
                    </div>

                    <div class="pt-6 flex flex-wrap gap-4">
                        <a href="{{ route('health') }}" class="inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-650 text-white text-xs font-bold rounded-xl transition duration-300 shadow-md shadow-emerald-500/10">
                            <flux:icon name="heart" class="size-3.5 mr-2" />
                            Open Health Registry
                        </a>
                        <a href="{{ route('appointments') }}" class="inline-flex items-center justify-center px-4 py-3 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-zinc-350 text-xs font-semibold text-zinc-700 dark:text-zinc-300 rounded-xl transition duration-300">
                            View Appointments
                        </a>
                    </div>
                </div>

            </div>

        <!-- 3. HOUSEHOLD HEAD DASHBOARD VIEW -->
        @elseif(auth()->user()->isHouseholdHead())
            <!-- Household Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Members count -->
                <div class="bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-250 dark:border-zinc-800/80 p-6 rounded-3xl shadow-md flex items-center justify-between transition hover:-translate-y-0.5 duration-300">
                    <div class="space-y-1">
                        <div class="text-xs font-bold uppercase tracking-wider text-emerald-850 dark:text-emerald-400">Family Members</div>
                        <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit">{{ $householdMembersCount }}</div>
                        <div class="text-[11px] text-emerald-900/80 dark:text-zinc-400">Residents in your household unit</div>
                    </div>
                    <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl shadow-sm">
                        <flux:icon name="users" class="size-6" />
                    </div>
                </div>

                <!-- Household Address -->
                <div class="bg-teal-50/70 dark:bg-zinc-900/40 border border-teal-250 dark:border-zinc-800/80 p-6 rounded-3xl shadow-md flex items-center justify-between transition hover:-translate-y-0.5 duration-300">
                    <div class="space-y-1 flex-1">
                        <div class="text-xs font-bold uppercase tracking-wider text-teal-850 dark:text-teal-400">Registered Address</div>
                        <div class="text-lg font-black text-teal-950 dark:text-white truncate max-w-xs mt-1 font-outfit">
                            {{ $household ? $household->address : 'Address not registered' }}
                        </div>
                        <div class="text-[11px] text-teal-900/85 dark:text-zinc-400">
                            Purok No: {{ $household ? $household->purok_no : 'N/A' }} | Household No: {{ $household ? $household->household_no : 'N/A' }}
                        </div>
                    </div>
                    <div class="p-4 bg-teal-500/20 text-teal-700 dark:text-teal-400 rounded-2xl shadow-sm">
                        <flux:icon name="home" class="size-6" />
                    </div>
                </div>
            </div>

            <!-- Household Appointments -->
            <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-6">
                <div class="flex items-center justify-between border-b border-zinc-150 dark:border-zinc-800 pb-4">
                    <div>
                        <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">My Upcoming Document Pickup Slots</h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Pickup slots scheduled with the Barangay Hall.</p>
                    </div>
                    <a href="{{ route('appointments') }}" class="text-xs font-bold text-emerald-600 hover:underline">Book or View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-155 dark:border-zinc-800 text-[10px] text-zinc-500 uppercase tracking-widest">
                                <th class="pb-3.5 font-bold">Purpose / Document</th>
                                <th class="pb-3.5 font-bold">Scheduled Pick up</th>
                                <th class="pb-3.5 font-bold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 text-xs text-zinc-750 dark:text-zinc-300">
                            @forelse($upcomingAppointments as $apt)
                                <tr>
                                    <td class="py-3.5 font-bold text-zinc-900 dark:text-white">{{ $apt->purpose }}</td>
                                    <td class="py-3.5 font-semibold">{{ $apt->appointment_date }} ({{ $apt->appointment_time }})</td>
                                    <td class="py-3.5 text-right">
                                        @if($apt->status === 'pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-amber-500/10 text-amber-700 dark:text-amber-500 border border-amber-500/25">Pending</span>
                                        @elseif($apt->status === 'approved')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-500/10 text-emerald-700 dark:text-emerald-500 border border-emerald-500/25">Approved</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-650 dark:text-zinc-500 border border-zinc-200 dark:border-zinc-705">{{ ucfirst($apt->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-zinc-500 text-xs font-light">No upcoming document pickup slots found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        <!-- 4. RESIDENT MEMBER DASHBOARD VIEW -->
        @else
            <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-6">
                <div class="flex items-center justify-between border-b border-zinc-150 dark:border-zinc-800 pb-4">
                    <div>
                        <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">My Upcoming Document Pickup Slots</h3>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Pickup slots scheduled with the Barangay Hall.</p>
                    </div>
                    <a href="{{ route('appointments') }}" class="text-xs font-bold text-emerald-600 hover:underline">Book or View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-155 dark:border-zinc-800 text-[10px] text-zinc-500 uppercase tracking-widest">
                                <th class="pb-3.5 font-bold">Purpose / Document</th>
                                <th class="pb-3.5 font-bold">Scheduled Pick up</th>
                                <th class="pb-3.5 font-bold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 text-xs text-zinc-750 dark:text-zinc-300">
                            @forelse($upcomingAppointments as $apt)
                                <tr>
                                    <td class="py-3.5 font-bold text-zinc-900 dark:text-white">{{ $apt->purpose }}</td>
                                    <td class="py-3.5 font-semibold">{{ $apt->appointment_date }} ({{ $apt->appointment_time }})</td>
                                    <td class="py-3.5 text-right">
                                        @if($apt->status === 'pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-amber-500/10 text-amber-700 dark:text-amber-500 border border-amber-500/25">Pending</span>
                                        @elseif($apt->status === 'approved')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-500/10 text-emerald-700 dark:text-emerald-500 border border-emerald-500/25">Approved</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-650 dark:text-zinc-500 border border-zinc-200 dark:border-zinc-705">{{ ucfirst($apt->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-zinc-550 text-xs font-light">No upcoming document pickup slots found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layouts::app>