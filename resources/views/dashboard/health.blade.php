<!-- Dynamic Health Metrics Dashboard Grid (Vibrant Colors) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Case Records -->
    <div class="group relative overflow-hidden bg-rose-50/60 dark:bg-zinc-900/40 border border-rose-200/85 dark:border-zinc-800/80 hover:border-red-500/40 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 border-l-4 border-l-red-500 card-glow-health">
        <div class="absolute inset-0 bg-gradient-to-b from-red-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-red-800 dark:text-red-400">Case Records</span>
                <div class="text-4xl font-black text-red-700 dark:text-red-500 font-outfit tracking-tight">{{ number_format($totalWithConditions) }}</div>
                <span class="text-[10px] text-zinc-650 dark:text-zinc-400 font-semibold">Active conditions</span>
            </div>
            <div class="p-3 bg-red-500/20 text-red-700 dark:text-red-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
                <flux:icon name="heart" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Fully Vaccinated -->
    <div class="group relative overflow-hidden bg-emerald-50/60 dark:bg-zinc-900/40 border border-emerald-200/80 dark:border-zinc-800/80 hover:border-emerald-500/40 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-admin card-glow-admin">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Immunized</span>
                <div class="text-4xl font-black text-emerald-700 dark:text-emerald-500 font-outfit tracking-tight">{{ number_format($totalVaccinated) }}</div>
                <span class="text-[10px] text-zinc-650 dark:text-zinc-400 font-semibold">Fully vaccinated</span>
            </div>
            <div class="p-3 bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
                <flux:icon name="shield-check" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Pediatric Cases -->
    <div class="group relative overflow-hidden bg-sky-50/60 dark:bg-zinc-900/40 border border-sky-200/80 dark:border-zinc-800/80 hover:border-sky-500/40 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-resident card-glow-resident">
        <div class="absolute inset-0 bg-gradient-to-b from-sky-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-sky-850 dark:text-sky-450">Pediatric Cases</span>
                <div class="text-4xl font-black text-sky-700 dark:text-sky-500 font-outfit tracking-tight">{{ number_format($pediatricCases) }}</div>
                <span class="text-[10px] text-zinc-650 dark:text-zinc-400 font-semibold">Children (age &le; 12)</span>
            </div>
            <div class="p-3 bg-sky-500/20 text-sky-700 dark:text-sky-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
                <flux:icon name="face-smile" class="size-6" />
            </div>
        </div>
    </div>

    <!-- Senior Cases -->
    <div class="group relative overflow-hidden bg-violet-50/60 dark:bg-zinc-900/40 border border-violet-200/80 dark:border-zinc-800/80 hover:border-violet-500/40 p-6 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1 stripe-left-health card-glow-health">
        <div class="absolute inset-0 bg-gradient-to-b from-violet-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-violet-800 dark:text-violet-400">Senior Cases</span>
                <div class="text-4xl font-black text-violet-700 dark:text-violet-500 font-outfit tracking-tight">{{ number_format($seniorCases) }}</div>
                <span class="text-[10px] text-zinc-650 dark:text-zinc-400 font-semibold">Seniors (age &ge; 60)</span>
            </div>
            <div class="p-3 bg-violet-500/20 text-violet-700 dark:text-violet-400 rounded-xl group-hover:scale-110 transition duration-300 shadow-sm">
                <flux:icon name="identification" class="size-6" />
            </div>
        </div>
    </div>
</div>

<!-- Health Coverage Grid: Graphs & Action Panel -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <!-- Vaccination Coverage Progress Bar Card -->
    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-6 card-glow-health">
        <div class="flex items-center gap-3 border-b border-zinc-150 dark:border-zinc-800 pb-3">
            <div class="p-2 bg-violet-500/10 text-violet-650 rounded-xl">
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
                <span class="text-violet-700 dark:text-violet-400 font-black">{{ number_format($percentage, 1) }}%</span>
            </div>
            <div class="w-full bg-zinc-100 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-full h-4 overflow-hidden p-0.5" role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                <div class="bg-gradient-to-r from-violet-500 to-fuchsia-400 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 text-[10px] text-zinc-550 dark:text-zinc-550 pt-2 border-t border-zinc-100 dark:border-zinc-800/50 font-semibold">
                <div>Unvaccinated: <strong class="text-zinc-800 dark:text-white font-bold">{{ number_format($totalResidents - $totalVaccinated) }} residents</strong></div>
                <div class="text-right">Demographics source: <strong class="text-zinc-800 dark:text-white font-bold">RBI Database</strong></div>
            </div>
        </div>
    </div>

    <!-- Secure Health Database Access Panel -->
    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg flex flex-col justify-between card-glow-health">
        <div class="space-y-4">
            <div class="flex items-center gap-3 border-b border-zinc-150 dark:border-zinc-800 pb-3">
                <div class="p-2 bg-violet-500/10 text-violet-650 rounded-xl">
                    <flux:icon name="shield-check" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Secure Health Database Portal</h3>
                    <p class="text-[11px] text-zinc-500 font-light">Encrypted dynamic database querying</p>
                </div>
            </div>
            <p class="text-xs text-zinc-650 dark:text-zinc-400 leading-relaxed font-light">
                Your dashboard has query-layer restrictions configured to secure inhabitant privacy. You are authorized to manage health indices, filter chronic conditions, and update demographic immunization records.
            </p>
        </div>

        <div class="pt-6 flex flex-wrap gap-4">
            <a href="{{ route('health') }}" class="inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-violet-500 to-violet-600 hover:from-violet-600 hover:to-violet-650 text-white text-xs font-bold rounded-xl transition duration-300 shadow-md shadow-violet-500/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet-500">
                <flux:icon name="heart" class="size-3.5 mr-2" />
                Open Health-based Data
            </a>
            <a href="{{ route('appointments') }}" class="inline-flex items-center justify-center px-4 py-3 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 text-xs font-semibold text-zinc-700 dark:text-zinc-300 rounded-xl transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet-500">
                View Appointments
            </a>
        </div>
    </div>

    <!-- Gender Distribution Chart (Health Dashboard) -->
    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-4">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-sky-500/10 text-sky-650 rounded-xl">
                    <flux:icon name="users" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Gender Distribution in Health Registry</h3>
                    <p class="text-[11px] text-zinc-500 font-light">Demographics of tracked inhabitants</p>
                </div>
            </div>
        </div>

        <div class="relative pt-4 flex flex-col md:flex-row items-center gap-8" data-chart-init="initGenderChartHealth">
            <div class="w-48 h-48 relative">
                <canvas id="genderChartHealth" class="w-full h-full" aria-label="Pie chart showing Gender Distribution in Health Registry" role="img"></canvas>
            </div>
            
            <!-- Screen reader alternative table for WCAG accessibility compliance -->
            @if(isset($genderLabels) && count($genderLabels))
                <table class="sr-only">
                    <caption>Gender demographics in health registry</caption>
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

            <div class="flex-1 w-full space-y-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div id="gender-legend-health" class="col-span-full space-y-3"></div>
            </div>
        </div>

        <script>
            window.initGenderChartHealth = function () {
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

                window.renderChartWhenReady('genderChartHealth', function () {
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
                                    <span class="text-xs text-zinc-550 dark:text-zinc-400 ml-1.5">(${pct}%)</span>
                                </div>
                            </div>
                        `;
                    });
                    const legendEl = document.getElementById('gender-legend-health');
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
            window.initGenderChartHealth();
        </script>
    </div>

    <!-- Age Demographics Chart (Health Dashboard) -->
    <div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg flex flex-col h-full font-outfit">
        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3 mb-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-violet-500/10 text-violet-650 rounded-xl">
                    <flux:icon name="chart-pie" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Age Demographics</h3>
                    <p class="text-[11px] text-zinc-500 font-light">Population breakdown by age groups</p>
                </div>
            </div>
        </div>

        <div class="relative flex-1 w-full flex flex-col gap-6" data-chart-init="initAgeChartHealth">
            <div class="w-full min-h-[220px] relative">
                <canvas id="ageChartHealth" class="absolute inset-0 w-full h-full" aria-label="Bar chart showing Age Demographics" role="img"></canvas>
            </div>
            
            <!-- Screen reader alternative table for WCAG accessibility compliance -->
            @if(isset($ageLabels) && count($ageLabels))
                <table class="sr-only">
                    <caption>Age Demographics breakdown data representation</caption>
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
                <div id="age-legend-health" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3"></div>
            </div>
        </div>

        <script>
            window.initAgeChartHealth = function () {
                const labels = @json($ageLabels ?? []);
                const values = @json($ageValues ?? []);

                window.renderChartWhenReady('ageChartHealth', function () {
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
                                    <span class="text-[10px] text-zinc-550 dark:text-zinc-400 ml-1">(${pct}%)</span>
                                </div>
                            </div>
                        `;
                    });
                    const legendEl = document.getElementById('age-legend-health');
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
            window.initAgeChartHealth();
        </script>
    </div>
</div>
