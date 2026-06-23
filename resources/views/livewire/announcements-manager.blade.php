<div class="py-12">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <h3 class="font-bold text-lg mb-3">Create Announcement</h3>
            <div class="space-y-3">
                <input wire:model.defer="title" type="text" placeholder="Title" class="w-full p-3 rounded border border-zinc-200 dark:border-zinc-800 bg-transparent text-sm" />
                <textarea wire:model.defer="body" rows="4" placeholder="Message" class="w-full p-3 rounded border border-zinc-200 dark:border-zinc-800 bg-transparent text-sm"></textarea>
                <div class="flex items-center gap-2">
                    <select wire:model.live="type" class="p-2 rounded border border-zinc-200 dark:border-zinc-800 bg-transparent text-sm">
                        <option value="general">General</option>
                        <option value="health">Health</option>
                        <option value="alert">Alert</option>
                        <option value="event">Event</option>
                    </select>
                    <label class="flex items-center gap-2 text-xs"><input wire:model="is_pinned" type="checkbox" /> Pin</label>
                    <label class="flex items-center gap-2 text-xs"><input wire:model="publish_now" type="checkbox" checked /> Publish now</label>
                </div>
                
                @if($type === 'event')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                    <div>
                        <label class="block text-xs font-bold text-zinc-500 mb-1">Event Date & Time</label>
                        <input wire:model="event_date" type="datetime-local" class="w-full p-2 rounded border border-zinc-200 dark:border-zinc-800 bg-transparent text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-zinc-500 mb-1">Event Location</label>
                        <input wire:model="event_location" type="text" placeholder="e.g. Barangay Hall" class="w-full p-2 rounded border border-zinc-200 dark:border-zinc-800 bg-transparent text-sm" />
                    </div>
                </div>
                @endif
                <div class="flex items-center gap-2">
                    @if($editingId)
                        <button wire:click="updateAnnouncement" class="px-4 py-2 bg-brand hover:bg-brand-dark text-white rounded">Update</button>
                        <button wire:click="cancelEdit" class="px-4 py-2 bg-zinc-200 hover:bg-zinc-300 text-zinc-800 rounded">Cancel</button>
                    @else
                        <button wire:click="createAnnouncement" class="px-4 py-2 bg-brand hover:bg-brand-dark text-white rounded">Publish</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <h4 class="font-bold mb-3">Existing Announcements</h4>
            <div class="space-y-3">
                @forelse($announcements as $a)
                    <div class="flex items-start justify-between p-3 border border-zinc-100 dark:border-zinc-800 rounded-lg">
                        <div>
                            <div class="text-xs text-zinc-400">{{ ucfirst($a->type) }} @if($a->is_pinned) • <strong class="text-brand">Pinned</strong>@endif</div>
                            <div class="font-bold">{{ $a->title }}</div>
                            @if($a->type === 'event' && $a->event_date)
                                <div class="text-xs text-brand mt-0.5">🗓 {{ $a->event_date->format('M d, Y h:i A') }} @if($a->event_location) • 📍 {{ $a->event_location }} @endif</div>
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
