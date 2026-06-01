<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-3">
        <h3 class="text-sm font-semibold">Manage Date Closures</h3>
        <p class="text-xs text-zinc-500">Add specific dates when appointments are closed, with an optional reason.</p>
    </div>

    @if (session('message'))
        <div class="mb-3 text-sm text-green-600">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="add" class="flex gap-2 mb-3">
        <input type="date" wire:model="date" class="rounded border px-2 py-1" required />
        <input type="text" wire:model="reason" placeholder="Reason (optional)" class="rounded border px-2 py-1 flex-1" />
        <button type="submit" class="bg-[#f53003] text-white px-3 rounded">Add</button>
    </form>

    <div class="space-y-2">
        @foreach($closures as $c)
            <div class="flex items-center justify-between border rounded px-3 py-2">
                <div class="text-sm">{{ $c->date->format('M d, Y') }} - {{ $c->reason ?? 'Closed' }}</div>
                <div>
                    <button wire:click="remove({{ $c->id }})" class="text-red-600 text-sm">Remove</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
