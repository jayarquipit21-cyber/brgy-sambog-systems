<div class="py-16">
    <div class="text-center max-w-2xl mx-auto space-y-3 px-4 sm:px-6 lg:px-8">
        <span class="text-brand text-lg font-bold uppercase tracking-wider font-outfit">Community Picks</span>
        <h2 class="text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Recommended Places Nearby</h2>
        <p class="text-zinc-500 text-xs leading-relaxed font-light">Curated spots in Brgy. Sambog — essential services and popular locations for residents.</p>
    </div>

    <div class="mt-10 w-[95vw] xl:w-[90vw] max-w-[1600px] relative left-1/2 -translate-x-1/2">
        @if($places->isEmpty())
            <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl p-10 text-center text-zinc-400 text-sm shadow-sm">
                No featured places yet.
            </div>
        @else
            <div id="rp-carousel" class="relative select-none">

                {{-- ← Prev Button --}}
                <button id="rp-prev" aria-label="Previous place"
                    class="absolute z-50 left-4 md:left-8 lg:left-16 h-12 w-12 rounded-full
                           bg-white dark:bg-zinc-900 shadow-xl
                           border border-zinc-200/60 dark:border-zinc-700/60
                           flex items-center justify-center
                           text-zinc-700 dark:text-zinc-200
                           hover:bg-emerald-500 hover:text-white hover:border-emerald-500
                           dark:hover:bg-emerald-500 dark:hover:text-white dark:hover:border-emerald-500
                           transition-all duration-200 hover:scale-110
                           focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400"
                    style="top: 50%; transform: translateY(-50%);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- → Next Button --}}
                <button id="rp-next" aria-label="Next place"
                    class="absolute z-50 right-4 md:right-8 lg:right-16 h-12 w-12 rounded-full
                           bg-white dark:bg-zinc-900 shadow-xl
                           border border-zinc-200/60 dark:border-zinc-700/60
                           flex items-center justify-center
                           text-zinc-700 dark:text-zinc-200
                           hover:bg-emerald-500 hover:text-white hover:border-emerald-500
                           dark:hover:bg-emerald-500 dark:hover:text-white dark:hover:border-emerald-500
                           transition-all duration-200 hover:scale-110
                           focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400"
                    style="top: 50%; transform: translateY(-50%);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- Coverflow Stage — mask-image creates the fade, no hard box border --}}
                <div id="rp-stage" class="relative" style="overflow: visible;">
                    @foreach($places as $idx => $place)
                        @php($name        = data_get($place, 'name'))
                        @php($type        = data_get($place, 'type'))
                        @php($purok       = data_get($place, 'purok_no'))
                        @php($description = data_get($place, 'description'))
                        @php($lat         = data_get($place, 'lat'))
                        @php($lng         = data_get($place, 'lng'))
                        @php($photo       = data_get($place, 'photo'))

                        <div class="rp-card absolute top-0 left-0 rounded-3xl overflow-hidden cursor-pointer"
                             data-index="{{ $idx }}">

                            {{-- Photo / placeholder --}}
                            @if($photo)
                                <img src="{{ $photo }}" alt="{{ $name }}"
                                     class="absolute inset-0 w-full h-full object-cover pointer-events-none" />
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-emerald-200 to-teal-400 dark:from-zinc-800 dark:to-zinc-700 flex items-center justify-center text-zinc-400 text-sm">
                                    No image available
                                </div>
                            @endif

                            {{-- Gradient scrim --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent pointer-events-none"></div>

                            {{-- Badge --}}
                            @if($type)
                                <div class="absolute top-5 left-5 z-10">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-bold rounded-full uppercase tracking-wider">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                        {{ ucfirst($type) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Bottom info --}}
                            <div class="absolute bottom-0 left-0 right-0 p-6 flex items-end justify-between gap-4 z-10">
                                <div class="flex-1 min-w-0">
                                    <div class="text-white/60 text-xs font-semibold uppercase tracking-widest mb-1">Purok {{ $purok ?? 'N/A' }}</div>
                                    <h3 class="text-white text-2xl sm:text-3xl font-extrabold font-outfit leading-tight truncate">{{ $name }}</h3>
                                    @if($description)
                                        <p class="text-white/70 text-xs mt-1 line-clamp-1">{{ $description }}</p>
                                    @endif
                                </div>
                                @if($lat && $lng)
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="flex-shrink-0 inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white text-xs font-bold px-4 py-2.5 rounded-full shadow-lg transition-all duration-200 hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Open Map
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Invisible spacer so the parent has height --}}
                    <div id="rp-spacer" style="visibility:hidden; pointer-events:none;"></div>
                </div>

                {{-- Dot indicators --}}
                <div id="rp-dots" class="flex justify-center gap-2 mt-6"></div>
            </div>

            <style>
                /* All transform/filter/opacity are GPU composited — no layout reflow */
                #rp-carousel .rp-card {
                    transform-origin: center center;
                    transform-style: preserve-3d;
                    transition:
                        transform  1.1s cubic-bezier(0.22, 1, 0.36, 1),
                        filter     1.1s cubic-bezier(0.22, 1, 0.36, 1),
                        opacity    0.9s cubic-bezier(0.22, 1, 0.36, 1),
                        box-shadow 1.1s cubic-bezier(0.22, 1, 0.36, 1);
                    will-change: transform, filter, opacity;
                }
                /* Soft fade sides — replaces hard overflow:hidden border */
                #rp-stage {
                    -webkit-mask-image: linear-gradient(to right,
                        transparent 0%,
                        black 2%,
                        black 98%,
                        transparent 100%);
                    mask-image: linear-gradient(to right,
                        transparent 0%,
                        black 2%,
                        black 98%,
                        transparent 100%);
                }
                .rp-dot {
                    width: 8px; height: 8px; border-radius: 9999px;
                    background: #d4d4d8; border: none; padding: 0; cursor: pointer;
                    transition: width 0.35s cubic-bezier(0.22, 1, 0.36, 1),
                                background 0.35s ease;
                }
                .rp-dot.active { width: 26px; background: #10b981; }
                .dark .rp-dot  { background: #3f3f46; }
                .dark .rp-dot.active { background: #10b981; }
            </style>

            <script>
            (function () {
                const carousel = document.getElementById('rp-carousel');
                if (!carousel) return;

                const stage    = document.getElementById('rp-stage');
                const spacer   = document.getElementById('rp-spacer');
                const dotsWrap = document.getElementById('rp-dots');
                const btnPrev  = document.getElementById('rp-prev');
                const btnNext  = document.getElementById('rp-next');
                const cards    = Array.from(stage.querySelectorAll('.rp-card'));
                const N        = cards.length;
                if (N === 0) return;

                // ─── Config ────────────────────────────────────────────────
                const ASPECT      = 0.575;  // height = width × aspect
                const DELAY_MS    = 7500;   // ms between auto-advances

                // layer definitions: [translateX_factor, scale, blur_px, opacity, rotateY_deg]
                // translateX_factor is relative to the active card's width
                const LAYERS = [
                    { tx:  0.00, sc: 1.00, bl: 0,   op: 1.00, ry:   0, z: 30 }, // active
                    { tx:  0.60, sc: 0.80, bl: 1.0, op: 0.88, ry: -18, z: 20 }, // right 1
                    { tx: -0.60, sc: 0.80, bl: 1.0, op: 0.88, ry:  18, z: 20 }, // left  1
                    { tx:  1.10, sc: 0.62, bl: 4,   op: 0.50, ry: -32, z: 10 }, // right 2
                    { tx: -1.10, sc: 0.62, bl: 4,   op: 0.50, ry:  32, z: 10 }, // left  2
                ];
                const HIDDEN = { tx: 0, sc: 0.55, bl: 12, op: 0, ry: 0, z: 0 };

                let current = 0;
                let timer   = null;

                // ─── Build dots ────────────────────────────────────────────
                cards.forEach(function (_, i) {
                    const d = document.createElement('button');
                    d.className = 'rp-dot' + (i === 0 ? ' active' : '');
                    d.setAttribute('aria-label', 'Go to slide ' + (i + 1));
                    d.addEventListener('click', function () { goTo(i); startTimer(); });
                    dotsWrap.appendChild(d);
                });

                function getDots() { return Array.from(dotsWrap.querySelectorAll('.rp-dot')); }

                // ─── Sizing ────────────────────────────────────────────────
                function cardDims() {
                    const sw = stage.offsetWidth;
                    // Leave more room on large screens to see side cards
                    const pct = sw < 768 ? 0.70 : 0.50; 
                    let cw = Math.round(sw * pct);
                    // clamp max card width
                    if (cw > 850) cw = 850;
                    if (cw < 280) cw = 280;
                    const ch = Math.round(cw * ASPECT);
                    return { sw, cw, ch };
                }

                function applySize(animate) {
                    const { sw, cw, ch } = cardDims();
                    // Set spacer so the stage has height (cards are absolute)
                    spacer.style.width  = '100%';
                    spacer.style.height = ch + 'px';
                    // Set all cards to the same base dimensions
                    cards.forEach(function (c) {
                        if (!animate) c.style.transition = 'none';
                        c.style.width  = cw + 'px';
                        c.style.height = ch + 'px';
                        // Horizontally centre within stage
                        c.style.left = Math.round((sw - cw) / 2) + 'px';
                        c.style.top  = '0';
                    });
                    if (!animate) {
                        // force reflow then restore transitions
                        void stage.offsetWidth;
                        cards.forEach(function (c) { c.style.transition = ''; });
                    }
                }

                // ─── Core render ───────────────────────────────────────────
                // Returns circular offset from current: -floor(N/2) … +floor(N/2)
                function circOff(i) {
                    let d = i - current;
                    while (d >  Math.floor(N / 2)) d -= N;
                    while (d < -Math.ceil(N  / 2)) d += N;
                    return d;
                }

                // Map offset → layer config
                function layerFor(off) {
                    if (off === 0)  return LAYERS[0];
                    if (off === 1)  return LAYERS[1];
                    if (off === -1) return LAYERS[2];
                    if (off === 2)  return LAYERS[3];
                    if (off === -2) return LAYERS[4];
                    return HIDDEN;
                }

                function render() {
                    const { sw, cw } = cardDims();
                    const stageHalf  = sw / 2;

                    cards.forEach(function (card) {
                        const i   = parseInt(card.dataset.index, 10);
                        const off = circOff(i);
                        const L   = layerFor(off);

                        // translateX moves card relative to its centred position
                        // tx is based on card width (cw) so spacing is consistent
                        const tx = L.tx * cw;

                        card.style.zIndex    = L.z;
                        card.style.opacity   = L.op;
                        card.style.filter    = L.bl > 0 ? 'blur(' + L.bl + 'px)' : 'none';
                        card.style.transform = 'translateX(' + tx + 'px) scale(' + L.sc + ') rotateY(' + L.ry + 'deg)';
                        card.style.pointerEvents = off === 0 ? 'auto' : 'none';
                        card.style.boxShadow = off === 0
                            ? '0 32px 64px -12px rgba(0,0,0,0.35)'
                            : '0 8px 24px -4px rgba(0,0,0,0.15)';
                    });

                    // Dot state
                    getDots().forEach(function (d, i) {
                        d.classList.toggle('active', i === current);
                    });
                }

                // ─── Navigation ────────────────────────────────────────────
                function goTo(idx) {
                    current = ((idx % N) + N) % N;
                    render();
                }

                // Always clears first — prevents ghost timers from stacking
                function startTimer() {
                    clearInterval(timer);
                    timer = setInterval(function () { goTo(current + 1); }, DELAY_MS);
                }

                function stopTimer() {
                    clearInterval(timer);
                    timer = null;
                }

                btnPrev.addEventListener('click', function () { goTo(current - 1); startTimer(); });
                btnNext.addEventListener('click', function () { goTo(current + 1); startTimer(); });

                // Click side card to navigate directly to it
                cards.forEach(function (card) {
                    card.addEventListener('click', function () {
                        const off = circOff(parseInt(card.dataset.index, 10));
                        if (off !== 0) { goTo(current + off); startTimer(); }
                    });
                });

                // Pause auto-advance while hovering; resume (fresh interval) on leave
                carousel.addEventListener('mouseenter', stopTimer);
                carousel.addEventListener('mouseleave', startTimer);

                // Touch / swipe
                let tx0 = 0;
                carousel.addEventListener('touchstart', function (e) { tx0 = e.touches[0].clientX; }, { passive: true });
                carousel.addEventListener('touchend',   function (e) {
                    const dx = e.changedTouches[0].clientX - tx0;
                    if (Math.abs(dx) > 40) { goTo(dx < 0 ? current + 1 : current - 1); startTimer(); }
                }, { passive: true });

                // ─── Init ──────────────────────────────────────────────────
                applySize(false);
                render();
                startTimer();

                let resizeTimer;
                window.addEventListener('resize', function () {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function () { applySize(false); render(); }, 120);
                });
            })();
            </script>
        @endif
    </div>
</div>
