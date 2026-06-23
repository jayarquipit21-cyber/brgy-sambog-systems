<div class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
        <span class="text-brand text-lg font-bold uppercase tracking-wider font-outfit">Bulletins & Feeds</span>
        <h2 class="text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Community Notice Board</h2>
        <p class="text-zinc-500 text-sm leading-relaxed font-light">Official statements, seasonal alerts, local assembly programs, and upcoming events.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Announcements Feed -->
        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-2xl font-bold font-outfit text-zinc-900 dark:text-white flex items-center gap-2 mb-6">
                <svg class="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                Recent Announcements
            </h3>
            
            @forelse($announcements as $a)
                <div class="bg-white dark:bg-zinc-900/60 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md transition duration-300 relative overflow-hidden group">
                    @if($a->is_pinned)
                        <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                            <div class="absolute transform rotate-45 bg-brand text-center text-white font-bold text-[10px] py-1 right-[-35px] top-[32px] w-[170px] shadow-sm">
                                PINNED
                            </div>
                        </div>
                    @endif
                    <div class="flex items-start justify-between gap-4 relative z-10">
                        <div class="flex-1">
                            <div class="text-xs uppercase tracking-wider font-extrabold text-brand bg-brand/10 px-3 py-1 rounded-full w-fit mb-3">
                                {{ ucfirst($a->type) }}
                            </div>
                            <h4 class="font-extrabold text-2xl text-zinc-900 dark:text-white mt-1 group-hover:text-brand transition">{{ $a->title }}</h4>
                            
                            @if($a->type === 'event' && $a->event_date)
                                <div class="flex items-center gap-4 mt-2 text-sm text-brand font-semibold bg-brand/5 w-fit px-3 py-1.5 rounded-lg border border-brand/10">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        {{ $a->event_date->format('F j, Y \a\t g:i A') }}
                                    </div>
                                    @if($a->event_location)
                                        <div class="flex items-center gap-1.5 border-l border-brand/20 pl-4">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            {{ $a->event_location }}
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <p class="text-base text-zinc-600 dark:text-zinc-400 mt-3 leading-relaxed">{{ $a->body }}</p>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-zinc-100 dark:border-zinc-800 flex items-center text-sm text-zinc-500">
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Published {{ $a->published_at ? $a->published_at->diffForHumans() : 'Draft' }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white/60 dark:bg-zinc-900/60 p-8 rounded-3xl border border-dashed border-zinc-300 dark:border-zinc-700 text-center text-zinc-500">
                    <svg class="h-12 w-12 mx-auto text-zinc-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8" />
                    </svg>
                    <p>No announcements published at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Upcoming Events Sidebar -->
        <div class="lg:col-span-1">
            <h3 class="text-2xl font-bold font-outfit text-zinc-900 dark:text-white flex items-center gap-2 mb-6">
                <svg class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Upcoming Events
            </h3>
            
            <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
                @forelse($events as $index => $event)
                    @php
                        $colors = [
                            'bg-emerald-100 dark:bg-emerald-900/40 text-brand',
                            'bg-sky-100 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400',
                            'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-500'
                        ];
                        $colorClass = $colors[$index % 3];
                    @endphp
                    <div class="p-5 {{ !$loop->last ? 'border-b border-zinc-100 dark:border-zinc-800' : '' }} hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition cursor-pointer flex gap-4">
                        <div class="flex-shrink-0 w-14 h-14 rounded-2xl flex flex-col items-center justify-center {{ $colorClass }}">
                            <span class="text-xs font-bold uppercase">{{ $event->event_date->format('M') }}</span>
                            <span class="text-xl font-black leading-none">{{ $event->event_date->format('d') }}</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-zinc-900 dark:text-white line-clamp-1">{{ $event->title }}</h4>
                            <div class="text-xs text-zinc-500 mt-1 flex items-center gap-1">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $event->event_date->format('g:i A') }}
                            </div>
                            @if($event->event_location)
                                <div class="text-xs text-zinc-500 mt-0.5 flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    {{ $event->event_location }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center text-sm text-zinc-500 border-b border-zinc-100 dark:border-zinc-800">
                        No upcoming events scheduled.
                    </div>
                @endforelse
                
                <div class="p-4 bg-zinc-50 dark:bg-zinc-900/80 border-t border-zinc-100 dark:border-zinc-800 text-center">
                    <a href="#" class="text-sm font-bold text-brand hover:text-brand-dark transition">View full calendar &rarr;</a>
                </div>
            </div>
            
            <!-- Quick Subcribe -->
            <div class="mt-8 bg-brand text-white p-6 rounded-3xl relative overflow-hidden shadow-lg shadow-emerald-500/20">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <h4 class="font-bold text-lg font-outfit mb-2">Never miss an update</h4>
                <p class="text-sm text-emerald-100 mb-4 leading-relaxed">Subscribe to our community newsletter for emergency alerts and event schedules.</p>
                <div class="flex gap-2">
                    <input type="email" placeholder="Your email address" class="w-full rounded-xl border-0 bg-white/20 text-white placeholder:text-emerald-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-white outline-none">
                    <button class="bg-white text-brand px-4 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-emerald-50 transition">Join</button>
                </div>
            </div>

        </div>
    </div>
</div>
