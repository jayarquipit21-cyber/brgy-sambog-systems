<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto space-y-3">
        <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Community Picks</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Recommended Places Nearby</h2>
        <p class="text-zinc-500 text-xs leading-relaxed font-light">Curated spots in Brgy. Sambog — essential services and popular locations for residents.</p>
    </div>

    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($places as $place)
            @php($name = data_get($place, 'name'))
            @php($type = data_get($place, 'type'))
            @php($purok = data_get($place, 'purok_no'))
            @php($description = data_get($place, 'description'))
            @php($address = data_get($place, 'address'))
            @php($lat = data_get($place, 'lat'))
            @php($lng = data_get($place, 'lng'))

            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="h-16 w-16 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center font-bold text-zinc-700 dark:text-zinc-200">{{ strtoupper(substr($name ?? '',0,2)) }}</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm text-zinc-900 dark:text-white">{{ $name }}</h3>
                        <div class="text-[11px] text-zinc-500 mt-1">{{ $type ? ucfirst($type) : 'Place' }} • Purok {{ $purok ?? 'N/A' }}</div>
                        @if($description)
                            <p class="text-xs text-zinc-500 mt-3 line-clamp-3">{{ $description }}</p>
                        @endif
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between gap-3">
                    <div class="text-xs text-zinc-500">{{ $address }}</div>
                    <div class="flex items-center gap-2">
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}" target="_blank" class="text-xs font-semibold text-brand hover:underline">Map</a>
                        <a href="#" class="text-xs px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200">Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm text-zinc-500 text-sm">No featured places yet.</div>
        @endforelse
    </div>
</div>
