<!-- Dynamic Stats Hub with Vibrant HSL Colorful Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Inhabitants Card -->
    <div class="group relative overflow-hidden bg-emerald-50/60 dark:bg-zinc-900/40 border border-emerald-200/80 dark:border-zinc-800/80 hover:border-emerald-500/45 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 card-glow-admin stripe-left-admin">
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
            <div class="p-4 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-md">
                <flux:icon name="users" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Households Card -->
    <div class="group relative overflow-hidden bg-amber-50/60 dark:bg-zinc-900/40 border border-amber-200/80 dark:border-zinc-800/80 hover:border-amber-500/45 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 card-glow-household stripe-left-household">
        <div class="absolute inset-0 bg-gradient-to-b from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-800 dark:text-amber-400">Households Tracked</span>
                <div class="text-4xl font-black text-amber-950 dark:text-white font-outfit tracking-tight">{{ number_format($totalHouseholds) }}</div>
                <span class="inline-flex items-center text-[10px] text-amber-900 dark:text-zinc-400 font-bold bg-amber-100 dark:bg-amber-950/20 px-2 py-0.5 rounded-full">
                    <flux:icon.home class="size-3 text-amber-600 dark:text-amber-500 mr-1" />
                    Unique family zones
                </span>
            </div>
            <div class="p-4 bg-amber-500/20 text-amber-700 dark:text-amber-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-md">
                <flux:icon name="home" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Document Pickups Card -->
    <div class="group relative overflow-hidden bg-violet-50/60 dark:bg-zinc-900/40 border border-violet-200/80 dark:border-zinc-800/80 hover:border-violet-500/45 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 card-glow-health stripe-left-health">
        <div class="absolute inset-0 bg-gradient-to-b from-violet-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-violet-850 dark:text-violet-400">Pending Pickups</span>
                <div class="text-4xl font-black text-violet-950 dark:text-white font-outfit tracking-tight">{{ number_format($pendingAppointments) }}</div>
                <span class="inline-flex items-center text-[10px] text-violet-900 dark:text-zinc-400 font-bold bg-violet-100 dark:bg-violet-950/20 px-2 py-0.5 rounded-full">
                    Awaiting Slot Approval
                </span>
            </div>
            <div class="p-4 bg-violet-500/20 text-violet-700 dark:text-violet-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-md">
                <flux:icon name="calendar" class="size-6" />
            </div>
        </div>
    </div>
</div>

<!-- Admin Grid: Quick Actions and Purok Demographics Graph -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Quick Actions Workspace Hub -->
    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-6 flex flex-col justify-between">
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
            <a href="{{ route('rbi') }}" class="group flex items-center justify-between p-3.5 bg-zinc-50 hover:bg-emerald-50/50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500/20 rounded-xl transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                <div class="flex items-center gap-3">
                    <flux:icon name="users" class="size-4 text-emerald-650 dark:text-emerald-500 group-hover:scale-110 transition" />
                    <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition">Inhabitants Registry (RBI)</span>
                </div>
                <flux:icon.arrow-right class="size-3.5 text-zinc-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition" />
            </a>

            <a href="{{ route('appointments') }}" class="group flex items-center justify-between p-3.5 bg-zinc-50 hover:bg-amber-50/50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-amber-500/20 rounded-xl transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500">
                <div class="flex items-center gap-3">
                    <flux:icon name="calendar" class="size-4 text-amber-650 dark:text-amber-500 group-hover:scale-110 transition" />
                    <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition">Clearances & Appointments</span>
                </div>
                <flux:icon.arrow-right class="size-3.5 text-zinc-400 group-hover:text-amber-600 group-hover:translate-x-1 transition" />
            </a>

            <a href="{{ route('admin.announcements') }}" class="group flex items-center justify-between p-3.5 bg-zinc-50 hover:bg-sky-50/50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-sky-500/20 rounded-xl transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500">
                <div class="flex items-center gap-3">
                    <flux:icon name="megaphone" class="size-4 text-sky-600 dark:text-sky-500 group-hover:scale-110 transition" />
                    <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition">Manage Announcements</span>
                </div>
                <flux:icon.arrow-right class="size-3.5 text-zinc-400 group-hover:text-sky-600 group-hover:translate-x-1 transition" />
            </a>

            <a href="{{ route('health') }}" class="group flex items-center justify-between p-3.5 bg-zinc-50 hover:bg-violet-50/50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-violet-500/20 rounded-xl transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet-500">
                <div class="flex items-center gap-3">
                    <flux:icon name="heart" class="size-4 text-violet-650 dark:text-violet-500 group-hover:scale-110 transition" />
                    <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white transition">Health Concerns Desk</span>
                </div>
                <flux:icon.arrow-right class="size-3.5 text-zinc-400 group-hover:text-violet-650 group-hover:translate-x-1 transition" />
            </a>
        </div>
    </div>

    <!-- Purok Zone Demographics Visualization (Interactive Chart) -->
    <div class="lg:col-span-2 bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-4">
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
            <span class="text-[10px] text-emerald-700 dark:text-emerald-400 font-bold bg-emerald-500/10 border border-emerald-500/25 px-2.5 py-1 rounded-full flex items-center gap-1.5 animate-pulse"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>Real-time Sync</span>
        </div>

        <!-- Purok Demographics Chart (Chart.js) -->
        <div class="relative pt-4 space-y-4" data-chart-init="initPurokChartAdmin">
            <div class="h-56 px-2">
                <canvas id="purokChart" class="w-full h-full" aria-label="Bar chart showing Purok Demographics Distribution" role="img"></canvas>
            </div>

            <!-- Screen reader alternative table for WCAG accessibility compliance -->
            @if(isset($purokLabels) && count($purokLabels))
                <table class="sr-only">
                    <caption>Purok Demographics data representation</caption>
                    <thead>
                        <tr>
                            <th scope="col">Purok Zone</th>
                            <th scope="col">Residents Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purokLabels as $index => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>{{ $purokValues[$index] ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="flex items-center justify-between text-[10px] text-zinc-650 dark:text-zinc-400 border-t border-zinc-150 dark:border-zinc-800/80 pt-3 font-semibold">
                <span id="purok-highest">Highest density: <strong class="text-emerald-600 dark:text-emerald-400 font-black">—</strong></span>
                <span id="purok-total">Total monitored zones: <strong class="text-zinc-900 dark:text-white font-bold">—</strong></span>
            </div>

            <script>
                window.initPurokChartAdmin = function () {
                    const labels = @json($purokLabels ?? []);
                    const values = @json($purokValues ?? []);

                    window.renderChartWhenReady('purokChart', function () {
                        const isDark = document.documentElement.classList.contains('dark');
                        const labelColor = isDark ? '#a1a1aa' : '#71717a';
                        const gridColor = isDark ? 'rgba(63, 63, 70, 0.4)' : 'rgba(228, 228, 231, 0.6)';

                        const highestEl = document.getElementById('purok-highest');
                        const totalEl = document.getElementById('purok-total');
                        if (highestEl && totalEl) {
                            if (labels.length && values.length) {
                                const totalZones = labels.length;
                                const maxIndex = values.indexOf(Math.max(...values));
                                const highestLabel = labels[maxIndex] || '—';
                                const highestValue = values[maxIndex] || 0;
                                highestEl.innerHTML = `Highest density: <strong class="text-emerald-600 dark:text-emerald-400 font-black">${highestLabel} (${highestValue})</strong>`;
                                totalEl.innerHTML = `Total monitored zones: <strong class="text-zinc-900 dark:text-white font-bold">${totalZones} Puroks</strong>`;
                            } else {
                                highestEl.innerHTML = 'No purok data available';
                                totalEl.innerHTML = '';
                            }
                        }

                        return {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Residents',
                                    data: values,
                                    backgroundColor: labels.map((_, i) => {
                                        const colors = [
                                            'rgba(16, 185, 129, 0.85)', // Emerald
                                            'rgba(245, 158, 11, 0.85)', // Amber
                                            'rgba(139, 92, 246, 0.85)', // Violet
                                            'rgba(14, 165, 233, 0.85)', // Sky
                                            'rgba(249, 115, 22, 0.85)'  // Orange
                                        ];
                                        return colors[i % colors.length];
                                    }),
                                    borderColor: labels.map((_, i) => {
                                        const borders = [
                                            'rgba(5, 150, 105, 0.9)',
                                            'rgba(217, 119, 6, 0.9)',
                                            'rgba(124, 58, 237, 0.9)',
                                            'rgba(3, 105, 161, 0.9)',
                                            'rgba(194, 65, 12, 0.9)'
                                        ];
                                        return borders[i % borders.length];
                                    }),
                                    borderWidth: 1,
                                    borderRadius: 6,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: { 
                                        beginAtZero: true,
                                        grid: { color: gridColor },
                                        ticks: { color: labelColor, font: { family: 'Instrument Sans' } }
                                    },
                                    x: {
                                        grid: { display: false },
                                        ticks: { color: labelColor, font: { family: 'Instrument Sans' } }
                                    }
                                },
                                plugins: {
                                    legend: { display: false }
                                }
                            }
                        };
                    });
                };
                window.initPurokChartAdmin();
            </script>
        </div>
    </div>

</div>

<!-- Demographics Extras Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <!-- Gender Distribution Visualization (Interactive Doughnut Chart) -->
    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-4">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-sky-500/10 text-sky-600 rounded-xl">
                    <flux:icon name="users" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Gender Distribution</h3>
                    <p class="text-[11px] text-zinc-500 font-light">Population demographics by sex</p>
                </div>
            </div>
        </div>

        <div class="relative pt-4 flex flex-col items-center gap-6" data-chart-init="initGenderChartAdmin">
            <div class="w-48 h-48 relative">
                <canvas id="genderChartAdmin" class="w-full h-full" aria-label="Pie chart showing Gender Distribution" role="img"></canvas>
            </div>
            
            <!-- Screen reader alternative table for WCAG accessibility compliance -->
            @if(isset($genderLabels) && count($genderLabels))
                <table class="sr-only">
                    <caption>Gender Distribution data representation</caption>
                    <thead>
                        <tr>
                            <th scope="col">Sex</th>
                            <th scope="col">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($genderLabels as $index => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>{{ $genderValues[$index] ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="w-full space-y-3">
                <div id="gender-legend-admin"></div>
            </div>
        </div>

        <script>
            window.initGenderChartAdmin = function () {
                const origLabels = @json($genderLabels ?? []);
                const origValues = @json($genderValues ?? []);
                
                let labels = [];
                let values = [];
                
                let maleIdx = origLabels.findIndex(l => l && l.toLowerCase() === 'male');
                if (maleIdx !== -1) { labels.push(origLabels[maleIdx]); values.push(origValues[maleIdx]); }
                
                let femaleIdx = origLabels.findIndex(l => l && l.toLowerCase() === 'female');
                if (femaleIdx !== -1) { labels.push(origLabels[femaleIdx]); values.push(origValues[femaleIdx]); }
                
                origLabels.forEach((l, i) => {
                    if (!l || (l.toLowerCase() !== 'male' && l.toLowerCase() !== 'female')) {
                        labels.push(l); values.push(origValues[i]);
                    }
                });

                window.renderChartWhenReady('genderChartAdmin', function () {
                    let legendHtml = '';
                    const colors = ['bg-blue-500', 'bg-pink-500', 'bg-emerald-500'];
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
                    const legendEl = document.getElementById('gender-legend-admin');
                    if (legendEl) legendEl.innerHTML = legendHtml;

                    return {
                        type: 'pie',
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
                            rotation: 180,
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    };
                });
            };
            window.initGenderChartAdmin();
        </script>
    </div>

    <!-- Age Demographics Visualization (Interactive Bar Chart) -->
    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg flex flex-col h-full font-outfit">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-violet-500/10 text-violet-600 rounded-xl">
                    <flux:icon name="chart-pie" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Age Demographics</h3>
                    <p class="text-[11px] text-zinc-500 font-light">Population breakdown by age groups</p>
                </div>
            </div>
        </div>

        <div class="relative flex-1 w-full flex flex-col gap-6" data-chart-init="initAgeChartAdmin">
            <div class="w-full min-h-[220px] relative">
                <canvas id="ageChartAdmin" class="absolute inset-0 w-full h-full" aria-label="Bar chart showing Age Demographics" role="img"></canvas>
            </div>
            
            <!-- Screen reader alternative table for WCAG accessibility compliance -->
            @if(isset($ageLabels) && count($ageLabels))
                <table class="sr-only">
                    <caption>Age Demographics data representation</caption>
                    <thead>
                        <tr>
                            <th scope="col">Age Group</th>
                            <th scope="col">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ageLabels as $index => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>{{ $ageValues[$index] ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="w-full space-y-3">
                <div id="age-legend-admin" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3"></div>
            </div>
        </div>

        <script>
            window.initAgeChartAdmin = function () {
                const labels = @json($ageLabels ?? []);
                const values = @json($ageValues ?? []);

                window.renderChartWhenReady('ageChartAdmin', function () {
                    const isDark = document.documentElement.classList.contains('dark');
                    const labelColor = isDark ? '#a1a1aa' : '#71717a';
                    const gridColor = isDark ? 'rgba(63, 63, 70, 0.4)' : 'rgba(228, 228, 231, 0.6)';

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
                                    <span class="text-[10px] text-zinc-555 dark:text-zinc-400 ml-1">(${pct}%)</span>
                                </div>
                            </div>
                        `;
                    });
                    const legendEl = document.getElementById('age-legend-admin');
                    if (legendEl) legendEl.innerHTML = legendHtml;

                    return {
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
                                borderRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { 
                                    beginAtZero: true,
                                    grid: { color: gridColor },
                                    ticks: { color: labelColor, font: { family: 'Instrument Sans' } }
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
                                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                            const pct = total > 0 ? (Math.floor((val / total) * 10000) / 100).toFixed(2) : '0.00';
                                            return ` ${context.dataset.label || ''}: ${val.toLocaleString()} (${pct}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    };
                });
            };
            window.initAgeChartAdmin();
        </script>
    </div>
</div>

<!-- Recent Activity Table -->
<div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2.5">
                <flux:icon name="inbox-arrow-down" class="size-5 text-emerald-600 dark:text-emerald-500" />
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white font-outfit">Recent Appointment & Document Requests</h3>
            </div>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 font-light">Overview of the latest 5 bookings. Go to Appointments to approve or reject.</p>
        </div>
        <a href="{{ route('appointments') }}" class="w-fit inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-emerald-500/30 text-xs font-bold text-emerald-650 dark:text-emerald-400 rounded-xl transition duration-300 shadow-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
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
                    <tr class="odd:bg-zinc-50/50 hover:bg-zinc-100/50 dark:odd:bg-zinc-900/20 dark:hover:bg-zinc-850/30 transition-colors">
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-zinc-100 dark:bg-zinc-800 text-zinc-650 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">Pending Review</span>
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
