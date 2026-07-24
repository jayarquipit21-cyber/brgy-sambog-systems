<div x-data="{
    activeTab: 'all',
    canScrollLeft: false,
    canScrollRight: true,
    updateScrollState() {
        const el = $refs.slider;
        if (!el) return;
        this.canScrollLeft = el.scrollLeft > 10;
        this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 10);
    },
    getScrollStep() {
        const el = $refs.slider;
        if (!el) return el.clientWidth;
        return el.clientWidth;
    },
    scrollLeft() {
        $refs.slider.scrollBy({ left: -this.getScrollStep(), behavior: 'smooth' });
        setTimeout(() => this.updateScrollState(), 400);
    },
    scrollRight() {
        $refs.slider.scrollBy({ left: this.getScrollStep(), behavior: 'smooth' });
        setTimeout(() => this.updateScrollState(), 400);
    }
}" x-init="$nextTick(() => updateScrollState())" class="space-y-6">

    <!-- Category Filter Pills -->
    <div class="flex items-center justify-center flex-wrap gap-2">
        @php
            $tabs = [
                'all'        => ['label' => 'All Places', 'count' => count($places)],
                'government' => ['label' => 'Civic & Gov\'t', 'count' => null],
                'health'     => ['label' => 'Health & Education', 'count' => null],
                'store'      => ['label' => 'Dining & Shops', 'count' => null],
            ];
        @endphp
        @foreach($tabs as $key => $tab)
            <button
                @click="activeTab = '{{ $key }}'"
                :class="activeTab === '{{ $key }}'
                    ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/25 ring-1 ring-emerald-500'
                    : 'bg-white/70 dark:bg-zinc-900/70 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 ring-1 ring-zinc-200/80 dark:ring-zinc-800/80'"
                class="px-4 py-2 rounded-full text-xs font-bold transition-all duration-200 font-outfit cursor-pointer backdrop-blur-sm"
            >
                {{ $tab['label'] }}
                @if($tab['count'])
                    <span class="ml-1 opacity-70">({{ $tab['count'] }})</span>
                @endif
            </button>
        @endforeach
    </div>

    <!-- Carousel Container -->
    <div class="relative">

        <!-- Left Arrow -->
        <button
            @click="scrollLeft()"
            x-show="canScrollLeft"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-x-2"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 -translate-x-2"
            aria-label="Scroll to previous places"
            class="absolute -left-5 top-1/2 -translate-y-1/2 z-20 h-11 w-11 rounded-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-200 shadow-xl shadow-black/10 dark:shadow-black/30 flex items-center justify-center hover:bg-emerald-600 hover:border-emerald-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-950 transition-all duration-200 cursor-pointer"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
        </button>

        <!-- Right Arrow -->
        <button
            @click="scrollRight()"
            x-show="canScrollRight"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-x-2"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 translate-x-2"
            aria-label="Scroll to next places"
            class="absolute -right-5 top-1/2 -translate-y-1/2 z-20 h-11 w-11 rounded-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-200 shadow-xl shadow-black/10 dark:shadow-black/30 flex items-center justify-center hover:bg-emerald-600 hover:border-emerald-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-950 transition-all duration-200 cursor-pointer"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
        </button>

        <!-- Scroll Track (force 3 cards visible) -->
        <div
            x-ref="slider"
            @scroll.debounce.100ms="updateScrollState()"
            class="flex items-stretch gap-5 overflow-x-hidden scroll-smooth snap-x snap-mandatory py-3"
            style="scrollbar-width: none; -ms-overflow-style: none;"
        >

            @forelse($places as $place)
                @php
                    $name        = data_get($place, 'name');
                    $type        = strtolower(data_get($place, 'type', 'general'));
                    $purok       = data_get($place, 'purok_no');
                    $description = data_get($place, 'description');
                    $address     = data_get($place, 'address');
                    $lat         = data_get($place, 'lat');
                    $lng         = data_get($place, 'lng');
                    $photo       = data_get($place, 'photo');

                    $category = match(true) {
                        in_array($type, ['government', 'civic', 'place of worship']) => 'government',
                        in_array($type, ['health', 'education', 'school'])           => 'health',
                        in_array($type, ['store', 'bakery', 'hardware', 'pizzeria', 'food']) => 'store',
                        default => 'other',
                    };

                    // Theme-harmonized gradients (Vibrant in Light mode, Deep in Dark mode)
                    $gradientMap = [
                        'government' => 'from-emerald-500 via-teal-600 to-emerald-700 dark:from-emerald-950 dark:via-teal-950 dark:to-zinc-900',
                        'health'     => 'from-sky-500 via-blue-600 to-indigo-700 dark:from-sky-950 dark:via-blue-950 dark:to-zinc-900',
                        'store'      => 'from-amber-500 via-orange-600 to-amber-700 dark:from-amber-950 dark:via-orange-950 dark:to-zinc-900',
                        'other'      => 'from-violet-500 via-purple-600 to-violet-700 dark:from-violet-950 dark:via-purple-950 dark:to-zinc-900',
                    ];
                    $gradient = $gradientMap[$category] ?? $gradientMap['other'];

                    // Icon accent colors
                    $accentMap = [
                        'government' => 'text-white dark:text-emerald-300',
                        'health'     => 'text-white dark:text-sky-300',
                        'store'      => 'text-white dark:text-amber-300',
                        'other'      => 'text-white dark:text-violet-300',
                    ];
                    $accent = $accentMap[$category] ?? $accentMap['other'];

                    $badgeColorMap = [
                        'government' => 'bg-emerald-600/90 dark:bg-emerald-500/90',
                        'health'     => 'bg-sky-600/90 dark:bg-sky-500/90',
                        'store'      => 'bg-amber-600/90 dark:bg-amber-500/90',
                        'other'      => 'bg-violet-600/90 dark:bg-violet-500/90',
                    ];
                    $badgeColor = $badgeColorMap[$category] ?? $badgeColorMap['other'];
                @endphp

                <article
                    x-show="activeTab === 'all' || activeTab === '{{ $category }}'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="snap-start snap-always flex-shrink-0 w-[calc((100%-40px)/3)] min-w-[280px] rounded-3xl overflow-hidden border border-zinc-200/80 dark:border-zinc-800/80 bg-white dark:bg-zinc-900 shadow-xl shadow-black/5 dark:shadow-black/20 flex flex-col group/card hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-600/10 transition-all duration-300"
                >
                    <!-- Immersive Cover -->
                    <div class="h-48 relative overflow-hidden bg-gradient-to-br {{ $gradient }}">
                        @if($photo)
                            <img
                                src="{{ $photo }}"
                                alt="Photo of {{ $name }}"
                                class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500 ease-out"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        @else
                            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.25),transparent_70%)]"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="h-16 w-16 rounded-2xl bg-white/20 dark:bg-white/10 backdrop-blur-md border border-white/30 dark:border-white/20 flex items-center justify-center shadow-lg group-hover/card:scale-110 transition-transform duration-300">
                                    @if(in_array($type, ['government', 'civic']))
                                        <svg class="h-8 w-8 {{ $accent }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1 0v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    @elseif($type === 'place of worship')
                                        <svg class="h-8 w-8 {{ $accent }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" /></svg>
                                    @elseif($type === 'health')
                                        <svg class="h-8 w-8 {{ $accent }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                    @elseif(in_array($type, ['education', 'school']))
                                        <svg class="h-8 w-8 {{ $accent }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                                    @elseif(in_array($type, ['store', 'bakery', 'pizzeria', 'food']))
                                        <svg class="h-8 w-8 {{ $accent }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" /></svg>
                                    @elseif($type === 'hardware')
                                        <svg class="h-8 w-8 {{ $accent }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.573-1.066z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    @else
                                        <svg class="h-8 w-8 {{ $accent }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Floating Badges -->
                        <div class="absolute top-3.5 left-3.5 right-3.5 flex items-start justify-between z-10">
                            <span class="px-2.5 py-1 bg-white/90 dark:bg-black/60 border border-white/50 dark:border-white/20 text-zinc-900 dark:text-white rounded-lg text-[10px] font-bold uppercase tracking-wider font-outfit shadow-sm backdrop-blur-md">
                                {{ ucfirst($type) }}
                            </span>
                            @if($purok)
                                <span class="px-2.5 py-1 {{ $badgeColor }} backdrop-blur-md text-white rounded-lg text-[10px] font-bold font-outfit shadow-sm">
                                    Purok {{ $purok }}
                                </span>
                            @endif
                        </div>

                        <!-- Bottom name overlay (visible on photo cards) -->
                        @if($photo)
                            <div class="absolute bottom-0 left-0 right-0 px-5 pb-4 z-10">
                                <h3 class="text-lg font-bold text-white font-outfit leading-snug drop-shadow-lg">{{ $name }}</h3>
                            </div>
                        @endif
                    </div>

                    <!-- Content Body -->
                    <div class="p-5 flex-grow flex flex-col justify-between gap-4">
                        <div class="space-y-2">
                            @if(!$photo)
                                <h3 class="text-lg font-bold text-zinc-950 dark:text-white font-outfit leading-snug">{{ $name }}</h3>
                            @endif
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed line-clamp-2">
                                {{ $description ?? $address ?? 'A notable local landmark in Brgy. Sambog, Corella, Bohol.' }}
                            </p>
                        </div>

                        <!-- Footer Actions -->
                        <div class="pt-3 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between gap-3">
                            <span class="text-[11px] text-zinc-400 dark:text-zinc-500 truncate max-w-[180px] leading-tight" title="{{ $address }}">
                                <svg class="h-3 w-3 inline-block -mt-0.5 mr-0.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                {{ $address }}
                            </span>
                            @if($lat && $lng)
                                <a
                                    href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="View {{ $name }} on Google Maps"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-500/10 hover:bg-emerald-600 text-emerald-600 hover:text-white dark:text-emerald-400 dark:hover:text-white rounded-xl text-xs font-bold transition-all duration-200 font-outfit flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                                >
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <span>View Map</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </article>

            @empty
                <!-- Rich Empty State -->
                <div class="w-full py-16 flex flex-col items-center justify-center text-center space-y-4">
                    <div class="h-20 w-20 rounded-3xl bg-zinc-100 dark:bg-zinc-800/80 flex items-center justify-center">
                        <svg class="h-10 w-10 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-zinc-700 dark:text-zinc-300 font-outfit">No places registered yet</h4>
                        <p class="text-xs text-zinc-400 dark:text-zinc-500 max-w-xs mx-auto leading-relaxed">Local landmarks, civic buildings, and community spots will appear here once registered by the Barangay administration.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

</div>
