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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700/60">
                    <div>
                        <label class="block text-xs font-bold text-zinc-700 dark:text-zinc-300 mb-1">Event Start Date & Time <span class="text-emerald-500">*</span></label>
                        <input wire:model="event_date" type="datetime-local" class="w-full p-2 rounded border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-sm text-zinc-900 dark:text-white" required />
                        @error('event_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-zinc-700 dark:text-zinc-300 mb-1">Event End Date & Time <span class="font-normal text-zinc-400">(optional)</span></label>
                        <input wire:model="event_end_date" type="datetime-local" class="w-full p-2 rounded border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-sm text-zinc-900 dark:text-white" />
                        @error('event_end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-zinc-700 dark:text-zinc-300 mb-1">Event Location <span class="font-normal text-zinc-400">(optional)</span></label>
                        <input wire:model="event_location" type="text" placeholder="e.g. Barangay Hall" class="w-full p-2 rounded border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-sm text-zinc-900 dark:text-white" />
                        @error('event_location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
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
