<div class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-[65fr_35fr] gap-8 items-start">
        
        <!-- Announcements Feed -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white flex items-center gap-2.5">
                    <div class="p-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    Official Bulletins
                </h3>
                <span class="text-xs font-semibold text-zinc-500">Showing {{ count($announcements) }} notices</span>
            </div>
            
            @forelse($announcements as $a)
                <article class="{{ $a->is_pinned ? 'bg-emerald-50/70 dark:bg-emerald-950/30 border-emerald-300/80 dark:border-emerald-800/60 shadow-lg shadow-emerald-600/5' : 'glass-panel border-zinc-200/80 dark:border-zinc-800/80' }} p-6 sm:p-8 rounded-3xl border bento-card-glow relative overflow-hidden transition-all duration-300 space-y-4">
                    
                    <!-- Header Badges -->
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[10px] uppercase tracking-wider font-extrabold text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 dark:bg-emerald-500/20 px-3 py-1 rounded-full border border-emerald-500/20 font-outfit">
                                {{ ucfirst($a->type) }}
                            </span>
                            @if($a->is_pinned)
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-300 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/20 font-outfit">
                                    <svg class="h-3 w-3 text-amber-500" viewBox="0 0 24 24" fill="currentColor"><path d="M16 12V4h1V2H7v2h1v8l-2 2v2h5.2v6h1.6v-6H18v-2l-2-2z"/></svg>
                                    Pinned Notice
                                </span>
                            @endif
                        </div>
                        <time datetime="{{ $a->published_at?->toIso8601String() }}" class="text-xs text-zinc-400 dark:text-zinc-500 flex items-center gap-1.5">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $a->published_at ? $a->published_at->diffForHumans() : 'Draft' }}
                        </time>
                    </div>

                    <!-- Announcement Title & Body -->
                    <div class="space-y-2">
                        <h4 class="font-extrabold text-xl sm:text-2xl text-zinc-950 dark:text-white font-outfit leading-snug">{{ $a->title }}</h4>
                        
                        @if($a->type === 'event' && $a->event_date)
                            <div class="flex items-center gap-3 text-xs text-emerald-700 dark:text-emerald-300 bg-emerald-500/10 px-3.5 py-2 rounded-xl border border-emerald-500/20 flex-wrap font-outfit font-medium">
                                <div class="flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    @if($a->event_end_date)
                                        @if($a->event_date->isSameDay($a->event_end_date))
                                            {{ $a->event_date->format('F j, Y \a\t g:i A') }} – {{ $a->event_end_date->format('g:i A') }}
                                        @else
                                            {{ $a->event_date->format('M j, Y g:i A') }} → {{ $a->event_end_date->format('M j, Y g:i A') }}
                                        @endif
                                    @else
                                        {{ $a->event_date->format('F j, Y \a\t g:i A') }}
                                    @endif
                                </div>
                                @if($a->event_location)
                                    <div class="flex items-center gap-1.5 border-l border-emerald-500/20 pl-3">
                                        <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ $a->event_location }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed font-normal pt-1">{{ $a->body }}</p>
                    </div>
                </article>
            @empty
                <div class="glass-panel p-10 rounded-3xl border border-dashed border-zinc-300 dark:border-zinc-700 text-center space-y-3">
                    <div class="h-14 w-14 mx-auto rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8" />
                        </svg>
                    </div>
                    <h4 class="text-base font-bold text-zinc-800 dark:text-zinc-200 font-outfit">No active announcements</h4>
                    <p class="text-xs text-zinc-500 max-w-sm mx-auto">Official notices and community alerts issued by the Barangay Council will appear here.</p>
                </div>
            @endforelse
        </div>

        <!-- Upcoming Events Sidebar Card -->
        <div class="space-y-6">
            <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white flex items-center gap-2.5">
                <div class="p-2 bg-teal-500/10 text-teal-600 dark:text-teal-400 rounded-xl">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                Upcoming Schedule
            </h3>
            
            <div class="glass-panel rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 overflow-hidden divide-y divide-zinc-100 dark:divide-zinc-800/60 shadow-lg shadow-black/5">
                @forelse($events as $index => $event)
                    @php
                        $colorStyles = [
                            'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
                            'bg-sky-500/10 text-sky-600 dark:text-sky-400 border-sky-500/20',
                            'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20',
                        ];
                        $style = $colorStyles[$index % count($colorStyles)];
                    @endphp
                    <div class="p-5 hover:bg-zinc-100/50 dark:hover:bg-zinc-800/40 transition duration-200 flex items-start gap-4">
                        <!-- Date Badge -->
                        <div class="flex-shrink-0 w-14 h-14 rounded-2xl flex flex-col items-center justify-center border {{ $style }} font-outfit shadow-sm">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider leading-none">{{ $event->event_date->format('M') }}</span>
                            <span class="text-xl font-black leading-none mt-1">{{ $event->event_date->format('d') }}</span>
                        </div>

                        <!-- Event Info -->
                        <div class="space-y-1 min-w-0 flex-grow">
                            <h4 class="font-bold text-sm text-zinc-950 dark:text-white font-outfit truncate" title="{{ $event->title }}">{{ $event->title }}</h4>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                <svg class="h-3.5 w-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @if($event->event_end_date)
                                    @if($event->event_date->isSameDay($event->event_end_date))
                                        {{ $event->event_date->format('g:i A') }} – {{ $event->event_end_date->format('g:i A') }}
                                    @else
                                        {{ $event->event_date->format('M j') }} – {{ $event->event_end_date->format('M j, Y') }}
                                    @endif
                                @else
                                    {{ $event->event_date->format('g:i A') }}
                                @endif
                            </div>
                            @if($event->event_location)
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 flex items-center gap-1 truncate">
                                    <svg class="h-3.5 w-3.5 text-zinc-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <span class="truncate">{{ $event->event_location }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center space-y-2">
                        <div class="h-10 w-10 mx-auto rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-400 flex items-center justify-center">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-xs text-zinc-500 font-medium">No upcoming events scheduled</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
