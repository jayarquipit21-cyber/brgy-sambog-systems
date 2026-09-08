@php
    $bannerGradient = 'from-emerald-500 via-emerald-600 to-teal-600 dark:from-zinc-950 dark:via-emerald-950/70 dark:to-zinc-900 border-emerald-300/30 dark:border-emerald-700/40';
    $roleName = 'Barangay Administrator';
    
    if (auth()->user()->isHealthAdmin()) {
        $bannerGradient = 'from-violet-500 via-violet-600 to-purple-600 dark:from-zinc-950 dark:via-violet-950/70 dark:to-zinc-900 border-violet-300/30 dark:border-violet-700/40';
        $roleName = 'Public Health Officer';
    } elseif (auth()->user()->isHouseholdHead()) {
        $bannerGradient = 'from-amber-500 via-amber-600 to-orange-600 dark:from-zinc-950 dark:via-amber-950/70 dark:to-zinc-900 border-amber-300/30 dark:border-amber-700/40';
        $roleName = 'Registered Household Head';
    } elseif (auth()->user()->isResident()) {
        $bannerGradient = 'from-sky-500 via-sky-600 to-cyan-600 dark:from-zinc-950 dark:via-sky-950/70 dark:to-zinc-900 border-sky-300/30 dark:border-sky-700/40';
        $roleName = 'Resident Inhabitant';
    }
@endphp
<x-layouts::app :title="__('Workspace Dashboard')">
    <div class="space-y-8 pb-12">
        <!-- Premium Welcome Banner with High-Contrast Animated Gradients -->
        <div class="relative overflow-hidden rounded-2xl border bg-gradient-to-br {{ $bannerGradient }} p-8 shadow-2xl transition-all duration-300">
            <!-- Background glow orbs -->
            <div class="absolute -right-16 -bottom-16 h-64 w-64 rounded-full bg-white/10 dark:bg-white/5 blur-3xl animate-pulse-slow" aria-hidden="true"></div>
            <div class="absolute -left-16 -top-16 h-64 w-64 rounded-full bg-white/10 dark:bg-white/5 blur-3xl animate-pulse-slow" aria-hidden="true"></div>
            <!-- Subtle shimmer line across top -->
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/40 to-transparent" aria-hidden="true"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 border border-white/30 text-white rounded-full text-[10px] font-extrabold tracking-wider uppercase">
                        <span class="h-1.5 w-1.5 rounded-full bg-white animate-ping" aria-hidden="true"></span>
                        Brgy. Sambog, Corella, Bohol Workspace
                    </span>
                    <h2 class="text-3xl font-black font-outfit sm:text-4xl text-white tracking-tight leading-none drop-shadow-sm">
                        Hello, <span class="font-black text-white">{{ auth()->user()->name }}</span>
                    </h2>
                    <p class="text-white/95 dark:text-zinc-200 text-xs sm:text-sm max-w-2xl font-normal leading-relaxed">
                        Welcome to your official inhabitant management and public services center. Access filtered registries, Purok demographic matrices, and pickup slots securely.
                    </p>
                </div>

                <!-- Active Role Badge -->
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 dark:bg-zinc-950/80 dark:border-zinc-800/60 px-4 py-3 rounded-2xl w-fit shadow-xl">
                    <div class="p-2.5 rounded-xl bg-white/20 text-white dark:bg-white/10 dark:text-white" aria-hidden="true">
                        <flux:icon name="shield-check" class="size-5" />
                    </div>
                    <div>
                        <div class="text-[9px] uppercase tracking-widest text-white/80 dark:text-zinc-400 font-extrabold">Active Role</div>
                        <div class="text-xs font-black text-white font-outfit">
                            {{ $roleName }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role-Based Dashboard Views -->
        @if(auth()->user()->isAdmin())
            @include('dashboard.admin')

        @elseif(auth()->user()->isHealthAdmin())
            @include('dashboard.health')

        @elseif(auth()->user()->isHouseholdHead())
            @include('dashboard.household')

        @else
            @include('dashboard.resident')

        @endif
    </div>

    {{-- Announcement Detail Modal (shared across all role views) --}}
    <div
        id="announcement-modal"
        onclick="if(event.target===this)closeAnnouncementModal()"
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-ann-title"
    >
        <div class="relative w-full max-w-4xl bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden transform scale-95 transition-all duration-300" id="announcement-modal-inner">
            {{-- Header accent --}}
            <div class="h-1.5 w-full bg-gradient-to-r from-emerald-400 via-emerald-500 to-emerald-600" aria-hidden="true"></div>

            {{-- Top bar --}}
            <div class="flex items-start justify-between p-6 pb-4 border-b border-zinc-100 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl shrink-0" aria-hidden="true">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                    </div>
                    <div>
                        <h2 id="modal-ann-title" class="text-base font-black text-zinc-900 dark:text-white font-outfit leading-snug"></h2>
                    </div>
                </div>
                <button
                    onclick="closeAnnouncementModal()"
                    class="p-1.5 rounded-lg text-zinc-400 hover:text-zinc-700 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-zinc-800 transition shrink-0 ml-3 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500"
                    aria-label="Close announcement"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 max-h-[60vh] overflow-y-auto space-y-4">
                {{-- Event schedule banner (when event) --}}
                <div id="modal-ann-event" class="hidden items-center gap-2 text-xs text-emerald-700 dark:text-emerald-300 bg-emerald-500/10 px-4 py-2.5 rounded-xl border border-emerald-500/20 font-semibold font-outfit">
                    <svg class="size-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span id="modal-ann-event-text"></span>
                </div>
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
        function openAnnouncementModal(id, title, body, date, type, isPinned, eventSchedule = '', eventLocation = '') {
            document.getElementById('modal-ann-title').textContent = title;
            document.getElementById('modal-ann-body').textContent = body;
            document.getElementById('modal-ann-date').textContent = date;
            
            const eventEl = document.getElementById('modal-ann-event');
            const eventText = document.getElementById('modal-ann-event-text');
            if (eventSchedule) {
                eventEl.classList.remove('hidden');
                eventEl.classList.add('flex');
                let text = 'Event Date: ' + eventSchedule;
                if (eventLocation) {
                    text += ' • Location: ' + eventLocation;
                }
                eventText.textContent = text;
            } else {
                eventEl.classList.add('hidden');
                eventEl.classList.remove('flex');
            }

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

            // Move focus into modal for a11y
            overlay.querySelector('button[aria-label="Close announcement"]').focus();
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