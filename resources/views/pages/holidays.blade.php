<x-layouts::app :title="__('National Holidays')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Upcoming National Holidays</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">These are nationally observed dates. Appointments are closed by default on these days.</p>
        </div>

        <div class="grid gap-4">
            @if(!empty($holidays) && count($holidays))
                @foreach($holidays as $h)
                    <div class="p-4 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
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
                @endforeach
            @else
                <div class="p-4 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 text-sm text-zinc-500">No upcoming national holidays found.</div>
            @endif
        </div>

        <div>
            <a href="{{ route('home') }}" class="text-sm text-brand hover:underline">Back to homepage</a>
        </div>
    </div>
</x-layouts::app>