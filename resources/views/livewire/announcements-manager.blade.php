<div class="py-12">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <h3 class="font-bold text-lg mb-3">Create Announcement</h3>
            <div class="space-y-3">
                <input wire:model.defer="title" type="text" placeholder="Title" class="w-full p-3 rounded border border-zinc-200 dark:border-zinc-800 bg-transparent text-sm" />
                <textarea wire:model.defer="body" rows="4" placeholder="Message" class="w-full p-3 rounded border border-zinc-200 dark:border-zinc-800 bg-transparent text-sm"></textarea>
                <div class="flex items-center gap-4 flex-wrap">
                    <label class="flex items-center gap-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 cursor-pointer">
                        <input wire:model.live="is_event" type="checkbox" class="rounded text-brand focus:ring-brand" />
                        Schedule as Community Event
                    </label>
                    <label class="flex items-center gap-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 cursor-pointer">
                        <input wire:model="is_pinned" type="checkbox" class="rounded text-amber-500 focus:ring-amber-500" />
                        Pin Announcement
                    </label>
                    <label class="flex items-center gap-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300 cursor-pointer">
                        <input wire:model="publish_now" type="checkbox" class="rounded text-emerald-500 focus:ring-emerald-500" />
                        Publish immediately
                    </label>
                </div>
                
                @if($is_event)
                <div class="mt-4 p-5 rounded-2xl bg-zinc-50/90 dark:bg-zinc-800/40 border border-zinc-200/80 dark:border-zinc-700/60 space-y-4 transition-all">
                    <!-- Section Header -->
                    <div class="flex items-center gap-3 pb-3 border-b border-zinc-200 dark:border-zinc-700/60">
                        <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold text-lg">
                            🗓
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Event Timing & Schedule</h4>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Configure event start time, duration, and venue location</p>
                        </div>
                    </div>

                    <!-- Quick Presets Toolbar -->
                    <div>
                        <div class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">
                            ⚡ Quick Schedule Templates:
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            <button 
                                type="button" 
                                wire:click="applyTimePreset('morning')" 
                                class="px-3 py-2 text-xs font-semibold rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-emerald-50 hover:border-emerald-300 dark:hover:bg-emerald-950/30 text-zinc-700 dark:text-zinc-300 transition-colors shadow-xs text-left cursor-pointer flex items-center gap-2"
                            >
                                <span class="text-base">🌅</span>
                                <div class="min-w-0">
                                    <div class="font-bold text-zinc-900 dark:text-white">Morning</div>
                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400">8:00 AM – 12:00 PM</div>
                                </div>
                            </button>

                            <button 
                                type="button" 
                                wire:click="applyTimePreset('afternoon')" 
                                class="px-3 py-2 text-xs font-semibold rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-amber-50 hover:border-amber-300 dark:hover:bg-amber-950/30 text-zinc-700 dark:text-zinc-300 transition-colors shadow-xs text-left cursor-pointer flex items-center gap-2"
                            >
                                <span class="text-base">☀️</span>
                                <div class="min-w-0">
                                    <div class="font-bold text-zinc-900 dark:text-white">Afternoon</div>
                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400">1:00 PM – 5:00 PM</div>
                                </div>
                            </button>

                            <button 
                                type="button" 
                                wire:click="applyTimePreset('whole_day')" 
                                class="px-3 py-2 text-xs font-semibold rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-blue-50 hover:border-blue-300 dark:hover:bg-blue-950/30 text-zinc-700 dark:text-zinc-300 transition-colors shadow-xs text-left cursor-pointer flex items-center gap-2"
                            >
                                <span class="text-base">📅</span>
                                <div class="min-w-0">
                                    <div class="font-bold text-zinc-900 dark:text-white">Whole Day</div>
                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400">8:00 AM – 5:00 PM</div>
                                </div>
                            </button>

                            <button 
                                type="button" 
                                wire:click="applyTimePreset('evening')" 
                                class="px-3 py-2 text-xs font-semibold rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-purple-50 hover:border-purple-300 dark:hover:bg-purple-950/30 text-zinc-700 dark:text-zinc-300 transition-colors shadow-xs text-left cursor-pointer flex items-center gap-2"
                            >
                                <span class="text-base">🌙</span>
                                <div class="min-w-0">
                                    <div class="font-bold text-zinc-900 dark:text-white">Evening</div>
                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400">6:00 PM – 9:00 PM</div>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Main Timing Grid (Clean 2-Column Layout) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Column 1: Start Schedule -->
                        <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 space-y-3 shadow-xs">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-zinc-900 dark:text-white flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Start Schedule <span class="text-emerald-500">*</span>
                                </label>
                                <span class="text-[11px] text-zinc-400 font-medium">Date & Time</span>
                            </div>

                            <!-- Start Date and Time Inputs Side-by-Side -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 mb-1">Date</label>
                                    <input 
                                        type="date" 
                                        wire:model.live="start_date" 
                                        class="w-full px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
                                        required 
                                    />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 mb-1">Time</label>
                                    <select 
                                        wire:model.live="start_time" 
                                        class="w-full px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                    >
                                        @foreach($this->getTimeSlots() as $val => $label)
                                            <option value="{{ $val }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Quick Start Time Chips in Single Clean Row -->
                            <div class="flex items-center gap-1.5 pt-1 border-t border-zinc-100 dark:border-zinc-800/80">
                                <span class="text-[10px] text-zinc-400 font-semibold uppercase">Quick:</span>
                                <div class="flex items-center gap-1 flex-wrap">
                                    @foreach(['08:00' => '8:00 AM', '09:00' => '9:00 AM', '10:00' => '10:00 AM', '13:00' => '1:00 PM', '14:00' => '2:00 PM'] as $qTime => $qLabel)
                                        <button 
                                            type="button" 
                                            wire:click="setStartTimePreset('{{ $qTime }}')" 
                                            class="px-2 py-0.5 text-[11px] rounded-md font-medium transition-colors cursor-pointer {{ $start_time === $qTime ? 'bg-emerald-600 text-white font-bold' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}"
                                        >
                                            {{ $qLabel }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            @error('event_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Column 2: End Schedule -->
                        <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 space-y-3 shadow-xs">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <label class="text-xs font-bold text-zinc-900 dark:text-white flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full {{ $has_end_time ? 'bg-emerald-500' : 'bg-zinc-300 dark:bg-zinc-600' }}"></span>
                                    End Schedule
                                </label>
                                <div class="flex items-center gap-3">
                                    <label class="inline-flex items-center gap-1.5 text-xs text-zinc-700 dark:text-zinc-300 cursor-pointer font-medium">
                                        <input type="checkbox" wire:model.live="has_end_time" class="rounded text-emerald-600 focus:ring-emerald-500" />
                                        <span>Set End Time</span>
                                    </label>
                                    @if($has_end_time)
                                        <label class="inline-flex items-center gap-1.5 text-xs text-zinc-700 dark:text-zinc-300 cursor-pointer font-medium">
                                            <input type="checkbox" wire:model.live="is_multi_day" class="rounded text-brand focus:ring-brand" />
                                            <span>Multi-day</span>
                                        </label>
                                    @endif
                                </div>
                            </div>

                            @if($has_end_time)
                                <div class="grid {{ $is_multi_day ? 'grid-cols-2' : 'grid-cols-1' }} gap-2">
                                    @if($is_multi_day)
                                        <div>
                                            <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 mb-1">End Date</label>
                                            <input 
                                                type="date" 
                                                wire:model.live="end_date" 
                                                min="{{ $start_date ?: date('Y-m-d') }}"
                                                class="w-full px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
                                            />
                                        </div>
                                    @endif
                                    <div>
                                        <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 mb-1">End Time</label>
                                        <select 
                                            wire:model.live="end_time" 
                                            class="w-full px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                        >
                                            @foreach($this->getTimeSlots() as $val => $label)
                                                <option value="{{ $val }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Quick Duration Chips in Single Clean Row -->
                                <div class="flex items-center gap-1.5 pt-1 border-t border-zinc-100 dark:border-zinc-800/80">
                                    <span class="text-[10px] text-zinc-400 font-semibold uppercase">Duration:</span>
                                    <div class="flex items-center gap-1 flex-wrap">
                                        @foreach([1 => '+1 hr', 2 => '+2 hrs', 3 => '+3 hrs', 4 => '+4 hrs'] as $dur => $dLabel)
                                            <button 
                                                type="button" 
                                                wire:click="applyDuration({{ $dur }})" 
                                                class="px-2 py-0.5 text-[11px] rounded-md font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-emerald-50 hover:text-emerald-700 dark:hover:bg-emerald-950/40 dark:hover:text-emerald-400 transition-colors cursor-pointer"
                                            >
                                                {{ $dLabel }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="py-4 px-3 rounded-lg border border-dashed border-zinc-200 dark:border-zinc-800 text-center text-xs text-zinc-400 bg-zinc-50/50 dark:bg-zinc-800/20">
                                    Open-ended event (no specific end time set)
                                </div>
                            @endif
                            @error('event_end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Row 2: Location (Full Width Card) -->
                    <div class="p-4 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 space-y-2.5 shadow-xs">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <label class="text-xs font-bold text-zinc-900 dark:text-white flex items-center gap-1.5">
                                <span>📍</span>
                                Event Location <span class="font-normal text-zinc-400 text-[11px]">(optional)</span>
                            </label>
                            
                            <!-- Location Suggestions Pills -->
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-[10px] text-zinc-400 font-semibold uppercase">Popular:</span>
                                @foreach(['Barangay Hall', 'Covered Court', 'Health Center', 'Barangay Plaza', 'Day Care'] as $loc)
                                    <button 
                                        type="button" 
                                        wire:click="setLocationSuggestion('{{ $loc }}')" 
                                        class="px-2 py-0.5 text-[11px] rounded-md font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors cursor-pointer"
                                    >
                                        {{ $loc }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <input 
                            wire:model="event_location" 
                            type="text" 
                            placeholder="e.g. Sambog Barangay Hall, Covered Court, or Plaza" 
                            class="w-full px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-zinc-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none" 
                        />
                        @error('event_location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Live Formatted Preview Badge -->
                    @if($this->getScheduleSummary())
                        <div class="p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-800 dark:text-emerald-300 flex items-center justify-between flex-wrap gap-2 text-xs">
                            <div class="flex items-center gap-2">
                                <span class="text-base">📅</span>
                                <span class="font-bold">Schedule Summary:</span>
                                <span class="font-medium">{{ $this->getScheduleSummary() }}</span>
                            </div>
                            @if($event_location)
                                <div class="flex items-center gap-1.5 text-zinc-700 dark:text-zinc-300 font-medium bg-white/60 dark:bg-zinc-900/60 px-2.5 py-1 rounded-lg border border-emerald-500/20">
                                    <span>📍</span>
                                    <span>{{ $event_location }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                @endif
                <div class="flex items-center gap-2">
                    @if($editingId)
                        <button wire:click="updateAnnouncement" wire:loading.attr="disabled" class="px-4 py-2 bg-brand hover:bg-brand-dark text-white rounded cursor-pointer">Update</button>
                        <button wire:click="cancelEdit" class="px-4 py-2 bg-zinc-200 hover:bg-zinc-300 text-zinc-800 rounded cursor-pointer">Cancel</button>
                    @else
                        <button wire:click="createAnnouncement" wire:loading.attr="disabled" class="px-4 py-2 bg-brand hover:bg-brand-dark text-white rounded cursor-pointer">Publish</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4">
                <h4 class="font-bold text-base">Existing Announcements</h4>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search announcements..." 
                        class="px-3 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand w-full sm:w-56"
                    />
                    <select 
                        wire:model.live="filterType" 
                        class="px-3 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand"
                    >
                        <option value="">All Types</option>
                        <option value="general">Announcements</option>
                        <option value="event">Community Events</option>
                    </select>
                </div>
            </div>
            <div class="space-y-3">
                @forelse($announcements as $a)
                    <div class="flex items-start justify-between p-3 border border-zinc-100 dark:border-zinc-800 rounded-lg">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                @if($a->is_pinned)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 dark:text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded-full border border-amber-500/20">
                                        Pinned
                                    </span>
                                @endif
                                @if($a->type === 'event' || $a->event_date)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">
                                        Event
                                    </span>
                                @endif
                            </div>
                            <div class="font-bold">{{ $a->title }}</div>
                            @if(($a->type === 'event' || $a->event_date) && $a->event_date)
                                <div class="text-xs text-brand mt-0.5 font-medium">
                                    🗓 {{ $a->event_date->format('M d, Y h:i A') }}
                                    @if($a->event_end_date)
                                        → {{ $a->event_end_date->format('M d, Y h:i A') }}
                                    @endif
                                    @if($a->event_location) • 📍 {{ $a->event_location }} @endif
                                </div>
                            @endif
                            <div class="text-xs text-zinc-500 mt-1">{{ Str::limit($a->body, 120) }}</div>
                            <div class="text-[11px] text-zinc-400 mt-1">{{ $a->published_at ? $a->published_at->diffForHumans() : 'Draft' }}</div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <button wire:click="editAnnouncement({{ $a->id }})" class="text-xs px-3 py-1 rounded bg-zinc-200 text-zinc-800">Edit</button>
                                @if($a->published_at)
                                    <button wire:click="unpublishAnnouncement({{ $a->id }})" class="text-xs px-3 py-1 rounded bg-zinc-700 text-white">Unpublish</button>
                                @else
                                    <button wire:click="publishAnnouncement({{ $a->id }})" class="text-xs px-3 py-1 rounded bg-brand text-white">Publish</button>
                                @endif
                                <button wire:click="deleteAnnouncement({{ $a->id }})" class="text-xs px-3 py-1 rounded bg-red-600 text-white">Delete</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-zinc-500">No announcements yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
