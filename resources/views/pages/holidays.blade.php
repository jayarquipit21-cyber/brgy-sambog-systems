<x-layouts::app :title="__('National Holidays')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Upcoming National Holidays</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">These are nationally observed dates. Appointments are closed by default on these days.</p>
        </div>

        {{-- Calendar + list view --}}
        @php
            $monthParam = request()->query('month');
            $selected = request()->query('date');
            try {
                $display = $monthParam ? \Illuminate\Support\Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth() : \Illuminate\Support\Carbon::now()->startOfMonth();
            } catch (\Exception $e) {
                $display = \Illuminate\Support\Carbon::now()->startOfMonth();
            }
            $prev = $display->copy()->subMonth()->format('Y-m');
            $next = $display->copy()->addMonth()->format('Y-m');
            $startOfMonth = $display->copy()->startOfMonth();
            $daysInMonth = $display->daysInMonth;
            $firstWeekday = $startOfMonth->dayOfWeek; // 0 (Sun) - 6 (Sat)
            $holidayMap = collect($holidays ?? [])->keyBy('date');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between mb-3">
                    <div class="font-semibold">{{ $display->format('F Y') }}</div>
                    <div class="space-x-2">
                        <a href="{{ route('holidays', ['month' => $prev]) }}" class="text-sm text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">‹ Prev</a>
                        <a href="{{ route('holidays', ['month' => $next]) }}" class="text-sm text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">Next ›</a>
                    </div>
                </div>

                <div class="grid grid-cols-7 gap-1 text-xs text-zinc-500 mb-2">
                    <div class="text-center">Sun</div>
                    <div class="text-center">Mon</div>
                    <div class="text-center">Tue</div>
                    <div class="text-center">Wed</div>
                    <div class="text-center">Thu</div>
                    <div class="text-center">Fri</div>
                    <div class="text-center">Sat</div>
                </div>

                <div class="grid grid-cols-7 gap-2">
                    @for ($i = 0; $i < $firstWeekday; $i++)
                        <div class="h-20"></div>
                    @endfor

                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $d = $display->copy()->day($day);
                            $iso = $d->toDateString();
                            $isHoliday = $holidayMap->has($iso);
                            $isSelected = isset($selected) && $selected === $iso;
                            $dayId = 'day-'.$iso;
                        @endphp
                        <div id="{{ $dayId }}" class="h-20 p-2 rounded-md border {{ $isSelected ? 'ring-2 ring-offset-1 ring-indigo-400 bg-indigo-50 dark:bg-indigo-900/30' : ($isHoliday ? 'border-red-300 bg-red-50 dark:bg-red-900/30' : 'border-transparent') }}">
                            <div class="flex items-start justify-between">
                                <div class="text-sm font-medium {{ $isHoliday ? 'text-red-700 dark:text-red-300' : 'text-zinc-700 dark:text-zinc-100' }}">{{ $day }}</div>
                                @if($isHoliday)
                                    <div class="text-xs text-red-600 dark:text-red-300">H</div>
                                @endif
                            </div>
                            @if($isHoliday)
                                <div class="text-xs text-zinc-700 dark:text-zinc-200 mt-2">{{ $holidayMap[$iso]['name'] }}</div>
                            @endif
                        </div>
                    @endfor
                </div>

                <div class="mt-3 text-xs text-zinc-500">Legend: <span class="text-red-600">H</span> = Holiday</div>
            </div>

            <div>
                <div class="space-y-3">
                    @if(!empty($holidays) && count($holidays))
                        @foreach($holidays as $h)
                            @php $hMonth = \Illuminate\Support\Str::substr($h['date'],0,7); $hDate = $h['date']; @endphp
                            <a href="{{ route('holidays', ['month' => $hMonth, 'date' => $hDate]) }}" class="block">
                                <div class="p-4 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 flex items-center justify-between hover:shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 text-center">
                                        <div class="text-xs text-zinc-500">{{ \Illuminate\Support\Carbon::parse($h['date'])->format('M') }}</div>
                                        <div class="text-lg font-extrabold text-zinc-900 dark:text-white">{{ \Illuminate\Support\Carbon::parse($h['date'])->format('d') }}</div>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-zinc-900 dark:text-white">{{ $h['name'] }}</div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ \Illuminate\Support\Carbon::parse($h['date'])->format('l, M d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="text-xs text-zinc-400">National Holiday</div>
                            </div>
                            </a>
                        @endforeach
                    @else
                        <div class="p-4 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 text-sm text-zinc-500">No upcoming national holidays found.</div>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <a href="{{ route('home') }}" class="text-sm text-brand hover:underline">Back to homepage</a>
        </div>
    </div>
</x-layouts::app>

@if(!empty($selected))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            try {
                var el = document.getElementById('day-{{ $selected }}');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    el.classList.add('transform', 'scale-105');
                    setTimeout(function () { el.classList.remove('scale-105'); }, 900);
                }
            } catch (e) { /* ignore */ }
        });
    </script>
@endif