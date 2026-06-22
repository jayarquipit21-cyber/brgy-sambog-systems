<x-layouts::app :title="__('Workspace Dashboard')">
    <!-- Load Chart.js globally for all dashboard views -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="space-y-8 pb-12">
        <!-- Premium Welcome Banner with High-Contrast Animated Gradients -->
        <div class="relative overflow-hidden rounded-3xl border border-emerald-300/30 dark:border-emerald-700/40 bg-gradient-to-br from-emerald-500 via-emerald-650 to-emerald-600 dark:from-zinc-950 dark:via-emerald-950 dark:to-zinc-900 p-8 shadow-2xl transition-all duration-300">
            <!-- Background glow orbs -->
            <div class="absolute -right-16 -bottom-16 h-64 w-64 rounded-full bg-gradient-to-tr from-emerald-400/40 to-emerald-300/40 dark:from-emerald-500/30 dark:to-emerald-400/30 blur-3xl"></div>
            <div class="absolute -left-16 -top-16 h-64 w-64 rounded-full bg-gradient-to-br from-emerald-400/30 to-emerald-300/30 dark:from-emerald-500/20 dark:to-emerald-400/20 blur-3xl"></div>
            <!-- Subtle green shimmer across top -->
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/40 dark:via-emerald-400/50 to-transparent"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 border border-white/30 text-white dark:bg-emerald-500/15 dark:border-emerald-400/40 dark:text-emerald-300 rounded-full text-[10px] font-extrabold tracking-wider uppercase">
                        <span class="h-1.5 w-1.5 rounded-full bg-white dark:bg-emerald-400 animate-ping"></span>
                        Brgy. Sambog, Corella, Bohol Workspace
                    </span>
                    <h2 class="text-3xl font-black font-outfit sm:text-4xl text-white tracking-tight leading-none drop-shadow-sm">
                        Hello, <span class="bg-gradient-to-r from-white via-emerald-100 to-emerald-50 dark:from-emerald-300 dark:via-emerald-200 dark:to-emerald-300 bg-clip-text text-transparent font-black">{{ auth()->user()->name }}</span>
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
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-250 dark:border-zinc-800/80 hover:border-emerald-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Households Tracked</span>
                            <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ number_format($totalHouseholds) }}</div>
                            <span class="inline-flex items-center text-[10px] text-emerald-900 dark:text-zinc-400 font-bold bg-emerald-100 dark:bg-emerald-950/20 px-2 py-0.5 rounded-full">
                                <flux:icon.home class="size-3 text-emerald-600 dark:text-emerald-500 mr-1" />
                                Unique family zones
                            </span>
                        </div>
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-md">
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

                        <a href="{{ route('health') }}" class="group flex items-center justify-between p-3.5 bg-zinc-50 hover:bg-emerald-50/50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500/20 rounded-xl transition duration-300">
                            <div class="flex items-center gap-3">
                                <flux:icon name="heart" class="size-4 text-emerald-600 dark:text-emerald-500 group-hover:scale-110 transition" />
                                <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition">Health Concerns Desk</span>
                            </div>
                            <flux:icon.arrow-right class="size-3.5 text-zinc-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition" />
                        </a>
                    </div>
                </div>

                <!-- Purok Zone Demographics Visualization (Interactive SVG Chart) -->
                <div class="lg:col-span-2 bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-650 dark:text-emerald-500 rounded-xl">
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

            <!-- Demographics Extras Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Gender Distribution Visualization (Interactive Doughnut Chart) -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-650 dark:text-emerald-500 rounded-xl">
                                <flux:icon name="users" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Gender Distribution</h3>
                                <p class="text-[11px] text-zinc-500 font-light">Population demographics by sex</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative pt-4 flex flex-col items-center gap-6">
                        <div class="w-48 h-48 relative">
                            <canvas id="genderChartAdmin" class="w-full h-full"></canvas>
                        </div>
                        <div class="w-full space-y-3">
                            <div id="gender-legend-admin"></div>
                        </div>
                    </div>

                    <script>
                        (function () {
                            const labels = @json($genderLabels ?? []);
                            const values = @json($genderValues ?? []);

                            const ctx = document.getElementById('genderChartAdmin');
                            if (!ctx) return;

                            const chart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        data: values,
                                        backgroundColor: [
                                            'rgba(236, 72, 153, 0.85)', // Pink
                                            'rgba(59, 130, 246, 0.85)', // Blue
                                            'rgba(16, 185, 129, 0.85)'  // Green
                                        ],
                                        borderColor: [
                                            'rgba(190, 24, 93, 0.9)',
                                            'rgba(29, 78, 216, 0.9)',
                                            'rgba(6, 95, 70, 0.9)'
                                        ],
                                        borderWidth: 1,
                                        hoverOffset: 4
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '65%',
                                    plugins: {
                                        legend: { display: false }
                                    }
                                }
                            });

                            let legendHtml = '';
                            const colors = ['bg-pink-500', 'bg-blue-500', 'bg-emerald-500'];
                            const total = values.reduce((a, b) => a + b, 0);
                            labels.forEach((label, index) => {
                                const val = values[index];
                                const pct = total > 0 ? (Math.floor((val / total) * 10000) / 100).toFixed(2) : '0.00';
                                const colorClass = colors[index % colors.length];
                                legendHtml += `
                                    <div class="flex items-center justify-between p-2.5 bg-zinc-50 dark:bg-zinc-800/40 rounded-xl border border-zinc-100 dark:border-zinc-700/50">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-3 h-3 rounded-full ${colorClass}"></span>
                                            <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">${label || 'Not Specified'}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-black text-zinc-900 dark:text-white">${val.toLocaleString()}</span>
                                            <span class="text-[10px] text-zinc-500 dark:text-zinc-400 ml-1">(${pct}%)</span>
                                        </div>
                                    </div>
                                `;
                            });
                            document.getElementById('gender-legend-admin').innerHTML = legendHtml;
                        })();
                    </script>
                </div>

                <!-- Age Demographics Visualization (Interactive Bar Chart) -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg flex flex-col h-full font-outfit">
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-650 dark:text-emerald-500 rounded-xl">
                                <flux:icon name="chart-pie" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Age Demographics</h3>
                                <p class="text-[11px] text-zinc-500 font-light">Population breakdown by age groups</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative flex-1 w-full flex flex-col gap-6">
                        <div class="w-full min-h-[220px] relative">
                            <canvas id="ageChartAdmin" class="absolute inset-0 w-full h-full"></canvas>
                        </div>
                        <div class="w-full space-y-3">
                            <div id="age-legend-admin" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3"></div>
                        </div>
                    </div>

                    <script>
                        (function () {
                            const labels = @json($ageLabels ?? []);
                            const values = @json($ageValues ?? []);

                            const ctx = document.getElementById('ageChartAdmin');
                            if (!ctx) return;

                            const chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Residents',
                                        data: values,
                                        backgroundColor: [
                                            'rgba(245, 158, 11, 0.85)', // Amber
                                            'rgba(16, 185, 129, 0.85)', // Emerald
                                            'rgba(59, 130, 246, 0.85)', // Blue
                                            'rgba(139, 92, 246, 0.85)', // Violet
                                            'rgba(236, 72, 153, 0.85)'  // Pink
                                        ],
                                        borderColor: [
                                            'rgba(217, 119, 6, 0.9)',
                                            'rgba(5, 150, 105, 0.9)',
                                            'rgba(37, 99, 235, 0.9)',
                                            'rgba(124, 58, 237, 0.9)',
                                            'rgba(219, 39, 119, 0.9)'
                                        ],
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
                                        legend: { display: false },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    const val = context.raw || 0;
                                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                                    const pct = total > 0 ? (Math.floor((val / total) * 10000) / 100).toFixed(2) : '0.00';
                                                    return ` ${context.dataset.label || ''}: ${val.toLocaleString()} (${pct}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });

                            let legendHtml = '';
                            const colors = ['bg-amber-500', 'bg-emerald-500', 'bg-blue-500', 'bg-violet-500', 'bg-pink-500'];
                            const total = values.reduce((a, b) => a + b, 0);
                            labels.forEach((label, index) => {
                                const val = values[index];
                                const pct = total > 0 ? (Math.floor((val / total) * 10000) / 100).toFixed(2) : '0.00';
                                const colorClass = colors[index % colors.length];
                                legendHtml += `
                                    <div class="flex items-center justify-between p-2.5 bg-zinc-50 dark:bg-zinc-800/40 rounded-xl border border-zinc-100 dark:border-zinc-700/50">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-3 h-3 rounded-full ${colorClass}"></span>
                                            <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">${label || 'Not Specified'}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-black text-zinc-900 dark:text-white">${val.toLocaleString()}</span>
                                            <span class="text-[10px] text-zinc-500 dark:text-zinc-400 ml-1">(${pct}%)</span>
                                        </div>
                                    </div>
                                `;
                            });
                            document.getElementById('age-legend-admin').innerHTML = legendHtml;
                        })();
                    </script>
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
                                    <td class="py-4 text-zinc-600 dark:text-zinc-400 font-semibold">
                                        @if($apt->appointment_date)
                                            {{ $apt->appointment_date->format('M d, Y') }} <span class="text-emerald-500 font-bold mx-1">@</span> {{ $apt->appointment_time }}
                                        @elseif($apt->status === 'approved-pending')
                                            <span class="text-[11px] text-amber-600 dark:text-amber-400 font-semibold bg-amber-50 dark:bg-amber-950/20 px-2 py-0.5 rounded">Pending Kapitan Signature</span>
                                        @elseif($apt->status === 'cancelled')
                                            <span class="text-[11px] text-red-500 dark:text-red-400 font-semibold bg-red-50 dark:bg-red-950/20 px-2 py-0.5 rounded">Cancelled</span>
                                        @else
                                            <span class="text-[11px] text-zinc-400 dark:text-zinc-500 font-semibold bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">Pending Review</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right">
                                        @if($apt->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">Pending Review</span>
                                        @elseif($apt->status === 'approved-pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/10 text-amber-700 dark:text-amber-500 border border-amber-500/20">Approved-Pending</span>
                                        @elseif($apt->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/10 text-emerald-700 dark:text-emerald-500 border border-emerald-500/20">Approved / Ready</span>
                                        @elseif($apt->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border border-indigo-500/20">Completed</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-red-500/10 text-red-700 dark:text-red-400 border border-red-500/20">Cancelled</span>
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
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-250 dark:border-zinc-800/80 hover:border-emerald-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Case Records</span>
                            <div class="text-4xl font-black text-emerald-700 dark:text-emerald-500 font-outfit tracking-tight">{{ number_format($totalWithConditions) }}</div>
                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400 font-semibold">Active conditions</span>
                        </div>
                        <div class="p-3 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
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
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-250 dark:border-zinc-800/80 hover:border-emerald-500/40 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-450">Pediatric Cases</span>
                            <div class="text-4xl font-black text-emerald-700 dark:text-emerald-500 font-outfit tracking-tight">{{ number_format($pediatricCases) }}</div>
                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400 font-semibold">Children (age &le; 12)</span>
                        </div>
                        <div class="p-3 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
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
                            <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
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
                        <a href="{{ route('health') }}" class="inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-emerald-500 to-emerald-500 hover:from-emerald-600 hover:to-emerald-650 text-white text-xs font-bold rounded-xl transition duration-300 shadow-md shadow-emerald-500/10">
                            <flux:icon name="heart" class="size-3.5 mr-2" />
                            Open Health Registry
                        </a>
                        <a href="{{ route('appointments') }}" class="inline-flex items-center justify-center px-4 py-3 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-zinc-350 text-xs font-semibold text-zinc-700 dark:text-zinc-300 rounded-xl transition duration-300">
                            View Appointments
                        </a>
                    </div>
                </div>

                <!-- Gender Distribution Chart (Health Dashboard) -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-650 dark:text-emerald-500 rounded-xl">
                                <flux:icon name="users" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Gender Distribution in Health Registry</h3>
                                <p class="text-[11px] text-zinc-500 font-light">Demographics of tracked inhabitants</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative pt-4 flex flex-col md:flex-row items-center gap-8">
                        <div class="w-48 h-48 relative">
                            <canvas id="genderChartHealth" class="w-full h-full"></canvas>
                        </div>
                        <div class="flex-1 w-full space-y-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div id="gender-legend-health" class="col-span-full space-y-3"></div>
                        </div>
                    </div>

                    <script>
                        (function () {
                            const labels = @json($genderLabels ?? []);
                            const values = @json($genderValues ?? []);

                            const ctx = document.getElementById('genderChartHealth');
                            if (!ctx) return;

                            const chart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        data: values,
                                        backgroundColor: [
                                            'rgba(59, 130, 246, 0.85)', // Blue
                                            'rgba(236, 72, 153, 0.85)', // Pink
                                            'rgba(16, 185, 129, 0.85)'  // Green
                                        ],
                                        borderColor: [
                                            'rgba(29, 78, 216, 0.9)',
                                            'rgba(190, 24, 93, 0.9)',
                                            'rgba(6, 95, 70, 0.9)'
                                        ],
                                        borderWidth: 1,
                                        hoverOffset: 4
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '65%',
                                    plugins: {
                                        legend: { display: false }
                                    }
                                }
                            });

                            let legendHtml = '';
                            const colors = ['bg-blue-500', 'bg-pink-500', 'bg-emerald-500'];
                            const total = values.reduce((a, b) => a + b, 0);
                            labels.forEach((label, index) => {
                                const val = values[index];
                                const pct = total > 0 ? (Math.floor((val / total) * 10000) / 100).toFixed(2) : '0.00';
                                const colorClass = colors[index % colors.length];
                                legendHtml += `
                                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-800/40 rounded-xl border border-zinc-100 dark:border-zinc-700/50">
                                        <div class="flex items-center gap-3">
                                            <span class="w-3.5 h-3.5 rounded-full ${colorClass}"></span>
                                            <span class="text-sm font-bold text-zinc-700 dark:text-zinc-300">${label || 'Not Specified'}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-black text-zinc-900 dark:text-white">${val.toLocaleString()}</span>
                                            <span class="text-xs text-zinc-500 dark:text-zinc-400 ml-1.5">(${pct}%)</span>
                                        </div>
                                    </div>
                                `;
                            });
                            document.getElementById('gender-legend-health').innerHTML = legendHtml;
                        })();
                    </script>
                </div>

                <!-- Age Demographics Chart (Health Dashboard) -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg flex flex-col h-full font-outfit">
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-650 dark:text-emerald-500 rounded-xl">
                                <flux:icon name="chart-pie" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Age Demographics</h3>
                                <p class="text-[11px] text-zinc-500 font-light">Population breakdown by age groups</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative flex-1 w-full flex flex-col gap-6">
                        <div class="w-full min-h-[220px] relative">
                            <canvas id="ageChartHealth" class="absolute inset-0 w-full h-full"></canvas>
                        </div>
                        <div class="w-full space-y-3">
                            <div id="age-legend-health" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3"></div>
                        </div>
                    </div>

                    <script>
                        (function () {
                            const labels = @json($ageLabels ?? []);
                            const values = @json($ageValues ?? []);

                            const ctx = document.getElementById('ageChartHealth');
                            if (!ctx) return;

                            const chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Residents',
                                        data: values,
                                        backgroundColor: [
                                            'rgba(245, 158, 11, 0.85)', // Amber
                                            'rgba(16, 185, 129, 0.85)', // Emerald
                                            'rgba(59, 130, 246, 0.85)', // Blue
                                            'rgba(139, 92, 246, 0.85)', // Violet
                                            'rgba(236, 72, 153, 0.85)'  // Pink
                                        ],
                                        borderColor: [
                                            'rgba(217, 119, 6, 0.9)',
                                            'rgba(5, 150, 105, 0.9)',
                                            'rgba(37, 99, 235, 0.9)',
                                            'rgba(124, 58, 237, 0.9)',
                                            'rgba(219, 39, 119, 0.9)'
                                        ],
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
                                        legend: { display: false },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    const val = context.raw || 0;
                                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                                    const pct = total > 0 ? (Math.floor((val / total) * 10000) / 100).toFixed(2) : '0.00';
                                                    return ` ${context.dataset.label || ''}: ${val.toLocaleString()} (${pct}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });

                            let legendHtml = '';
                            const colors = ['bg-amber-500', 'bg-emerald-500', 'bg-blue-500', 'bg-violet-500', 'bg-pink-500'];
                            const total = values.reduce((a, b) => a + b, 0);
                            labels.forEach((label, index) => {
                                const val = values[index];
                                const pct = total > 0 ? (Math.floor((val / total) * 10000) / 100).toFixed(2) : '0.00';
                                const colorClass = colors[index % colors.length];
                                legendHtml += `
                                    <div class="flex items-center justify-between p-2.5 bg-zinc-50 dark:bg-zinc-800/40 rounded-xl border border-zinc-100 dark:border-zinc-700/50">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-3 h-3 rounded-full ${colorClass}"></span>
                                            <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">${label || 'Not Specified'}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-black text-zinc-900 dark:text-white">${val.toLocaleString()}</span>
                                            <span class="text-[10px] text-zinc-500 dark:text-zinc-400 ml-1">(${pct}%)</span>
                                        </div>
                                    </div>
                                `;
                            });
                            document.getElementById('age-legend-health').innerHTML = legendHtml;
                        })();
                    </script>
                </div>
            </div>

        <!-- 3. HOUSEHOLD HEAD DASHBOARD VIEW -->
        @elseif(auth()->user()->isHouseholdHead())

            @if(auth()->user()->resident && !auth()->user()->resident->place_of_birth)
                <!-- Complete Profile Prompt -->
                <div class="mb-6 relative overflow-hidden bg-amber-50/70 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/80 p-6 rounded-3xl shadow-sm">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="p-3 bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-2xl shrink-0">
                            <flux:icon name="identification" class="size-6" />
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-amber-900 dark:text-amber-300">Complete Your Profile</h3>
                            <p class="text-[11px] text-amber-800/80 dark:text-amber-400/80 mt-1">Please provide your extended personal details and household information to ensure the Barangay registry is accurate.</p>
                        </div>
                        <a href="{{ route('profile.complete') }}" wire:navigate class="shrink-0 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl shadow-sm transition">
                            Complete Now
                        </a>
                    </div>
                </div>
            @endif

            <!-- Top stats row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Family Members -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-200 dark:border-zinc-800/80 hover:border-emerald-400/50 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Family Members</div>
                            <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ $householdMembersCount }}</div>
                            <div class="text-[11px] text-emerald-900/70 dark:text-zinc-400">Residents in your unit</div>
                        </div>
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="users" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Purok -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-200 dark:border-zinc-800/80 hover:border-emerald-400/50 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Purok Zone</div>
                            <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ $household ? $household->purok_no : '—' }}</div>
                            <div class="text-[11px] text-emerald-900/70 dark:text-zinc-400">Registered purok number</div>
                        </div>
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="map-pin" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Pending Appointments -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-200 dark:border-zinc-800/80 hover:border-emerald-400/50 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">My Appointments</div>
                            <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ $upcomingAppointments->count() }}</div>
                            <div class="text-[11px] text-emerald-900/70 dark:text-zinc-400">Upcoming pickup slots</div>
                        </div>
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="calendar" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Household No -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-200 dark:border-zinc-800/80 hover:border-emerald-400/50 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Household No.</div>
                            <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ $household ? $household->household_no : '—' }}</div>
                            <div class="text-[11px] text-emerald-900/70 dark:text-zinc-400">Official registry number</div>
                        </div>
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="home" class="size-6" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                @php
                    $headIconBgClass = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-500';
                    $headItemIconClass = 'text-emerald-500';
                    if ($residentProfile) {
                        if (strtolower($residentProfile->sex) === 'male') {
                            $headIconBgClass = 'bg-blue-500/10 text-blue-600 dark:text-blue-500';
                            $headItemIconClass = 'text-blue-500';
                        } elseif (strtolower($residentProfile->sex) === 'female') {
                            $headIconBgClass = 'bg-pink-500/10 text-pink-600 dark:text-pink-500';
                            $headItemIconClass = 'text-pink-500';
                        }
                    }
                @endphp
                <!-- Household Profile Card -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg flex flex-col">
                    <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
                        <div class="p-2 {{ $headIconBgClass }} rounded-xl">
                            <flux:icon name="identification" class="size-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">My Profile</h3>
                            <p class="text-[11px] text-zinc-500 font-light">Your registered resident information</p>
                        </div>
                    </div>

                    @if($residentProfile)
                        <div class="flex-1 space-y-2.5 overflow-y-auto pr-0.5">
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
                                    ['label' => 'PhilHealth', 'value' => $residentProfile->has_philhealth === 'Yes' ? 'Enrolled' : ($residentProfile->has_philhealth ? $residentProfile->has_philhealth : null), 'icon' => 'shield-check'],
                                    ['label' => 'National Voter', 'value' => $residentProfile->registered_national_voter, 'icon' => 'check-badge'],
                                ];
                            @endphp
                            @foreach($profileItems as $item)
                                @if(!empty($item['value']))
                                    <div class="flex items-start gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                                        <flux:icon name="{{ $item['icon'] }}" class="size-3.5 {{ $headItemIconClass }} mt-0.5 shrink-0" />
                                        <div class="min-w-0">
                                            <div class="text-[9px] uppercase tracking-widest text-zinc-400 dark:text-zinc-500 font-bold">{{ $item['label'] }}</div>
                                            <div class="text-xs font-bold text-zinc-800 dark:text-white truncate">{{ $item['value'] }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center py-6">
                            <flux:icon name="user-circle" class="size-12 text-zinc-300 dark:text-zinc-600 mb-2" />
                            <p class="text-xs text-zinc-500">No resident profile linked to your account.</p>
                            <p class="text-[11px] text-zinc-400 mt-1">Contact the Barangay Admin to link your record.</p>
                        </div>
                    @endif

                    <div class="pt-4 mt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <a href="{{ route('household') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-400/30 text-xs font-semibold text-zinc-700 dark:text-zinc-300 rounded-xl transition duration-300">
                            <flux:icon name="home" class="size-3.5" />
                            View Household Details
                        </a>
                    </div>
                </div>

                <!-- Household Members List -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg flex flex-col">
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 rounded-xl">
                                <flux:icon name="users" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Household Members</h3>
                                <p class="text-[11px] text-zinc-500 font-light">Residents registered under your household</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded-full">{{ $householdMembersCount }}</span>
                    </div>

                    <div class="space-y-2 flex-1 overflow-y-auto pr-1">
                        @forelse($householdMembers as $member)
                            <div class="flex items-center gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center text-white text-[10px] font-black shrink-0">
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
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <flux:icon name="users" class="size-10 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" />
                                <p class="text-xs text-zinc-500">No household members found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right column: Appointments + Announcements -->
                <div class="flex flex-col gap-6">

                    <!-- Upcoming Appointments -->
                    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-4">
                        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 rounded-xl">
                                    <flux:icon name="calendar" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-zinc-900 dark:text-white font-outfit">My Pickup Slots</h3>
                                    <p class="text-[10px] text-zinc-500 font-light">Upcoming document requests</p>
                                </div>
                            </div>
                            <a href="{{ route('appointments') }}" class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 hover:underline">View All</a>
                        </div>

                        <div class="space-y-2">
                            @forelse($upcomingAppointments as $apt)
                                <div class="flex items-start gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                                    <div class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 shrink-0">
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
                                        <span class="shrink-0 text-[8px] font-bold px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">Approved (Ready)</span>
                                    @else
                                        <span class="shrink-0 text-[8px] font-bold px-1.5 py-0.5 rounded bg-zinc-100 text-zinc-500 border border-zinc-200">{{ ucfirst($apt->status) }}</span>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <flux:icon name="calendar" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-1" />
                                    <p class="text-[11px] text-zinc-500">No upcoming pickups scheduled.</p>
                                    <a href="{{ route('appointments') }}" class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 hover:underline mt-1 inline-block">Book one now →</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    
                    <!-- Document Pickup History -->
                    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-4">
                        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-zinc-500/10 text-zinc-600 dark:text-zinc-500 rounded-xl">
                                    <flux:icon name="clock" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-zinc-900 dark:text-white font-outfit">Pickup History</h3>
                                    <p class="text-[10px] text-zinc-500 font-light">Past document requests</p>
                                </div>
                            </div>
                            <a href="{{ route('appointments') }}" class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 hover:underline">View All</a>
                        </div>

                        <div class="space-y-2">
                            @forelse($appointmentHistory as $apt)
                                <div class="flex items-start gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                                    <div class="p-1.5 rounded-lg bg-zinc-500/10 text-zinc-600 dark:text-zinc-400 shrink-0">
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
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <flux:icon name="clock" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-1" />
                                    <p class="text-[11px] text-zinc-500">No past pickups found.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Announcements -->
                    <div class="flex-1 flex flex-col bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg">
                        <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 rounded-xl">
                                <flux:icon name="megaphone" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-zinc-900 dark:text-white font-outfit">Barangay Announcements</h3>
                                <p class="text-[10px] text-zinc-500 font-light">Latest from Brgy. Sambog</p>
                            </div>
                        </div>

                        <div class="flex-1 space-y-2 mt-4">
                            @forelse($recentAnnouncements as $ann)
                                <div
                                    onclick="openAnnouncementModal({{ $ann->id }}, {{ Js::from($ann->title) }}, {{ Js::from($ann->body) }}, {{ Js::from($ann->published_at ? $ann->published_at->diffForHumans() : 'Draft') }}, {{ Js::from($ann->type ?? 'General') }}, {{ $ann->is_pinned ? 'true' : 'false' }})"
                                    class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40 cursor-pointer hover:border-emerald-400/50 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-all duration-200 group"
                                >
                                    <div class="flex items-start gap-2">
                                        @if($ann->is_pinned)
                                            <flux:icon name="bookmark" class="size-3 text-emerald-500 mt-0.5 shrink-0" />
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <div class="text-[11px] font-bold text-zinc-800 dark:text-white truncate group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $ann->title }}</div>
                                            <div class="text-[10px] text-zinc-500 dark:text-zinc-400 line-clamp-2 mt-0.5">{{ $ann->body }}</div>
                                            <div class="text-[9px] text-zinc-400 mt-1 flex items-center gap-1">
                                                {{ $ann->published_at ? $ann->published_at->diffForHumans() : 'Draft' }}
                                                <span class="text-emerald-500 font-bold">· Tap to read</span>
                                            </div>
                                        </div>
                                        <flux:icon name="arrow-right" class="size-3 text-zinc-300 group-hover:text-emerald-500 shrink-0 mt-0.5 transition-colors" />
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <flux:icon name="megaphone" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-1" />
                                    <p class="text-[11px] text-zinc-500">No announcements posted yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        <!-- 4. RESIDENT MEMBER DASHBOARD VIEW -->
        @else

            @if(auth()->user()->resident && !auth()->user()->resident->place_of_birth)
                <!-- Complete Profile Prompt -->
                <div class="mb-6 relative overflow-hidden bg-amber-50/70 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/80 p-6 rounded-3xl shadow-sm">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="p-3 bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-2xl shrink-0">
                            <flux:icon name="identification" class="size-6" />
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-amber-900 dark:text-amber-300">Complete Your Profile</h3>
                            <p class="text-[11px] text-amber-800/80 dark:text-amber-400/80 mt-1">Please provide your extended personal details to ensure the Barangay registry is accurate.</p>
                        </div>
                        <a href="{{ route('profile.complete') }}" wire:navigate class="shrink-0 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl shadow-sm transition">
                            Complete Now
                        </a>
                    </div>
                </div>
            @endif

            <!-- Quick info cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <!-- Age -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-200 dark:border-zinc-800/80 hover:border-emerald-400/50 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">My Age</div>
                            <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ $residentProfile?->age ?? '—' }}</div>
                            <div class="text-[11px] text-emerald-900/70 dark:text-zinc-400">{{ $residentProfile?->age_classification ?? 'Age group' }}</div>
                        </div>
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="cake" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Upcoming Appointments count -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-200 dark:border-zinc-800/80 hover:border-emerald-400/50 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Pending Slots</div>
                            <div class="text-4xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight">{{ $upcomingAppointments->count() }}</div>
                            <div class="text-[11px] text-emerald-900/70 dark:text-zinc-400">Document pickup requests</div>
                        </div>
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="calendar" class="size-6" />
                        </div>
                    </div>
                </div>

                <!-- Vaccination Status -->
                <div class="group relative overflow-hidden bg-emerald-50/70 dark:bg-zinc-900/40 border border-emerald-200 dark:border-zinc-800/80 hover:border-emerald-400/50 p-6 rounded-3xl shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Vaccination</div>
                            <div class="text-xl font-black text-emerald-950 dark:text-white font-outfit tracking-tight mt-1">
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
                        <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-2xl group-hover:scale-110 transition duration-300 shadow-sm">
                            <flux:icon name="shield-check" class="size-6" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content: Profile + Appointments + Announcements -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                @php
                    $resIconBgClass = 'bg-violet-500/10 text-violet-600 dark:text-violet-500';
                    $resItemIconClass = 'text-violet-500';
                    if ($residentProfile) {
                        if (strtolower($residentProfile->sex) === 'male') {
                            $resIconBgClass = 'bg-blue-500/10 text-blue-600 dark:text-blue-500';
                            $resItemIconClass = 'text-blue-500';
                        } elseif (strtolower($residentProfile->sex) === 'female') {
                            $resIconBgClass = 'bg-pink-500/10 text-pink-600 dark:text-pink-500';
                            $resItemIconClass = 'text-pink-500';
                        }
                    }
                @endphp
                <!-- Resident Profile Card -->
                <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg flex flex-col">
                    <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
                        <div class="p-2 {{ $resIconBgClass }} rounded-xl">
                            <flux:icon name="identification" class="size-5" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">My Profile</h3>
                            <p class="text-[11px] text-zinc-500 font-light">Your registered resident information</p>
                        </div>
                    </div>

                    @if($residentProfile)
                        <div class="flex-1 space-y-2.5 overflow-y-auto pr-0.5">
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
                                    ['label' => 'PhilHealth', 'value' => $residentProfile->has_philhealth === 'Yes' ? 'Enrolled' : ($residentProfile->has_philhealth ? $residentProfile->has_philhealth : null), 'icon' => 'shield-check'],
                                    ['label' => 'Health Condition', 'value' => ($residentProfile->health_condition && $residentProfile->health_condition !== 'None') ? $residentProfile->health_condition : null, 'icon' => 'heart'],
                                    ['label' => 'Vulnerable Sector', 'value' => $residentProfile->vulnerable_sector, 'icon' => 'flag'],
                                    ['label' => 'National Voter', 'value' => $residentProfile->registered_national_voter, 'icon' => 'check-badge'],
                                ];
                            @endphp
                            @foreach($resItems as $item)
                                @if(!empty($item['value']))
                                    <div class="flex items-start gap-3 p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-700/40">
                                        <flux:icon name="{{ $item['icon'] }}" class="size-3.5 {{ $resItemIconClass }} mt-0.5 shrink-0" />
                                        <div class="min-w-0">
                                            <div class="text-[9px] uppercase tracking-widest text-zinc-400 dark:text-zinc-500 font-bold">{{ $item['label'] }}</div>
                                            <div class="text-xs font-bold text-zinc-800 dark:text-white truncate">{{ $item['value'] }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center py-8">
                            <flux:icon name="user-circle" class="size-12 text-zinc-300 dark:text-zinc-600 mb-2" />
                            <p class="text-xs text-zinc-500">No resident profile linked to your account.</p>
                            <p class="text-[11px] text-zinc-400 mt-1">Contact the Barangay Admin to link your record.</p>
                        </div>
                    @endif
                </div>

                <!-- Appointments + Announcements -->
                <div class="lg:col-span-2 flex flex-col gap-6">

                    <!-- Upcoming appointments -->
                    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-4">
                        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 rounded-xl">
                                    <flux:icon name="calendar" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">My Document Pickup Slots</h3>
                                    <p class="text-[11px] text-zinc-500 font-light">Pickup slots scheduled with the Barangay Hall</p>
                                </div>
                            </div>
                            <a href="{{ route('appointments') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline">Book or View All</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-zinc-100 dark:border-zinc-800 text-[10px] text-zinc-500 uppercase tracking-widest">
                                        <th class="pb-3 font-bold">Purpose / Document</th>
                                        <th class="pb-3 font-bold">Scheduled Pick up</th>
                                        <th class="pb-3 font-bold text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 text-xs text-zinc-700 dark:text-zinc-300">
                                    @forelse($upcomingAppointments as $apt)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/20 transition-colors">
                                            <td class="py-3.5 font-bold text-zinc-900 dark:text-white">{{ $apt->purpose }}</td>
                                            <td class="py-3.5 font-semibold text-zinc-600 dark:text-zinc-400">
                                                @if($apt->appointment_date)
                                                    {{ $apt->appointment_date->format('M d, Y') }} <span class="text-emerald-500 mx-1">@</span> {{ $apt->appointment_time }}
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
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-500/10 text-emerald-700 dark:text-emerald-500 border border-emerald-500/25">Approved (Ready)</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">{{ ucfirst($apt->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-8 text-center">
                                                <flux:icon name="calendar" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" />
                                                <p class="text-xs text-zinc-500">No upcoming pickup slots found.</p>
                                                <a href="{{ route('appointments') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline mt-1 inline-block">Book one now →</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                    <!-- Pickup History -->
                    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg space-y-4">
                        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-zinc-500/10 text-zinc-600 dark:text-zinc-500 rounded-xl">
                                    <flux:icon name="clock" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Pickup History</h3>
                                    <p class="text-[11px] text-zinc-500 font-light">Past document requests</p>
                                </div>
                            </div>
                            <a href="{{ route('appointments') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline">View All</a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-zinc-100 dark:border-zinc-800 text-[10px] text-zinc-500 uppercase tracking-widest">
                                        <th class="pb-3 font-bold">Purpose / Document</th>
                                        <th class="pb-3 font-bold">Date Picked up</th>
                                        <th class="pb-3 font-bold text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 text-xs text-zinc-700 dark:text-zinc-300">
                                    @forelse($appointmentHistory as $apt)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/20 transition-colors">
                                            <td class="py-3.5 font-bold text-zinc-900 dark:text-white">{{ $apt->purpose }}</td>
                                            <td class="py-3.5 font-semibold text-zinc-600 dark:text-zinc-400">
                                                @if($apt->appointment_date)
                                                    {{ $apt->appointment_date->format('M d, Y') }} <span class="text-emerald-500 mx-1">@</span> {{ $apt->appointment_time }}
                                                @else
                                                    <span class="text-xs text-zinc-400">N/A</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 text-right">
                                                @if($apt->status === 'completed')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-500/10 text-emerald-700 dark:text-emerald-500 border border-emerald-500/25">Completed</span>
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
                                                <flux:icon name="clock" class="size-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" />
                                                <p class="text-xs text-zinc-500">No past pickups found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Barangay Announcements -->
                    <div class="flex-1 flex flex-col bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 shadow-lg">
                        <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-3">
                            <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 rounded-xl">
                                <flux:icon name="megaphone" class="size-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Barangay Announcements</h3>
                                <p class="text-[11px] text-zinc-500 font-light">Latest updates from Brgy. Sambog</p>
                            </div>
                        </div>

                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4 content-start">
                            @forelse($recentAnnouncements as $ann)
                                <div
                                    onclick="openAnnouncementModal({{ $ann->id }}, {{ Js::from($ann->title) }}, {{ Js::from($ann->body) }}, {{ Js::from($ann->published_at ? $ann->published_at->diffForHumans() : 'Draft') }}, {{ Js::from($ann->type ?? 'General') }}, {{ $ann->is_pinned ? 'true' : 'false' }})"
                                    class="p-4 rounded-2xl bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-800/40 dark:to-zinc-900/40 border border-zinc-100 dark:border-zinc-700/40 space-y-2 cursor-pointer hover:border-emerald-400/50 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group"
                                >
                                    <div class="flex items-center gap-2">
                                        @if($ann->is_pinned)
                                            <flux:icon name="bookmark" class="size-3.5 text-emerald-500 shrink-0" />
                                        @else
                                            <flux:icon name="megaphone" class="size-3.5 text-zinc-400 shrink-0" />
                                        @endif
                                        <span class="text-[9px] uppercase tracking-widest font-bold text-emerald-600 dark:text-emerald-400">{{ $ann->type ?? 'General' }}</span>
                                    </div>
                                    <div class="text-xs font-bold text-zinc-800 dark:text-white line-clamp-2 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $ann->title }}</div>
                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400 line-clamp-3">{{ $ann->body }}</div>
                                    <div class="text-[9px] text-zinc-400 pt-1 border-t border-zinc-100 dark:border-zinc-700/50 flex items-center justify-between">
                                        <span>{{ $ann->published_at ? $ann->published_at->diffForHumans() : 'Draft' }}</span>
                                        <span class="text-emerald-500 font-bold">Read more →</span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-3 text-center py-8">
                                    <flux:icon name="megaphone" class="size-10 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" />
                                    <p class="text-xs text-zinc-500">No announcements posted yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Announcement Detail Modal --}}
    <div
        id="announcement-modal"
        onclick="if(event.target===this)closeAnnouncementModal()"
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300"
        style=""
    >
        <div class="relative w-full max-w-4xl bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden transform scale-95 transition-all duration-300" id="announcement-modal-inner">
            {{-- Header accent --}}
            <div class="h-1.5 w-full bg-gradient-to-r from-emerald-400 via-emerald-500 to-emerald-600"></div>

            {{-- Top bar --}}
            <div class="flex items-start justify-between p-6 pb-4 border-b border-zinc-100 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl shrink-0">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                    </div>
                    <div>
                        <p id="modal-ann-type" class="text-[9px] uppercase tracking-widest font-extrabold text-emerald-600 dark:text-emerald-400 mb-0.5"></p>
                        <h2 id="modal-ann-title" class="text-base font-black text-zinc-900 dark:text-white font-outfit leading-snug"></h2>
                    </div>
                </div>
                <button
                    onclick="closeAnnouncementModal()"
                    class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-700 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-zinc-800 transition shrink-0 ml-3"
                    aria-label="Close"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 max-h-[60vh] overflow-y-auto">
                <p id="modal-ann-body" class="text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed whitespace-pre-line"></p>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between px-6 py-4 border-t border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/30">
                <div class="flex items-center gap-1.5 text-[11px] text-zinc-400">
                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span id="modal-ann-date"></span>
                </div>
                <div id="modal-ann-pinned" class="hidden items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                    <svg class="size-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 3a2 2 0 012 2v1l-2 9H7L5 6V5a2 2 0 012-2h10zm-5 16a2 2 0 100-4 2 2 0 000 4z"/></svg>
                    Pinned
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAnnouncementModal(id, title, body, date, type, isPinned) {
            document.getElementById('modal-ann-title').textContent = title;
            document.getElementById('modal-ann-body').textContent = body;
            document.getElementById('modal-ann-date').textContent = date;
            document.getElementById('modal-ann-type').textContent = type;
            const pinnedEl = document.getElementById('modal-ann-pinned');
            pinnedEl.classList.toggle('hidden', !isPinned);
            pinnedEl.classList.toggle('flex', isPinned);

            const overlay = document.getElementById('announcement-modal');
            const inner = document.getElementById('announcement-modal-inner');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
            inner.classList.remove('scale-95');
            inner.classList.add('scale-100');
            document.body.style.overflow = 'hidden';
        }

        function closeAnnouncementModal() {
            const overlay = document.getElementById('announcement-modal');
            const inner = document.getElementById('announcement-modal-inner');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
            inner.classList.add('scale-95');
            inner.classList.remove('scale-100');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAnnouncementModal();
        });
    </script>

</x-layouts::app>