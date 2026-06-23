<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-3">
        <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Manage Date Closures</h3>
        <p class="text-xs text-zinc-500 dark:text-zinc-400">Add specific dates when appointments are closed, with an optional reason.</p>
    </div>

    @if (session('message'))
        <div class="mb-3 text-sm text-emerald-600 dark:text-emerald-400">{{ session('message') }}</div>
    @endif

    @if (session('error'))
        <div class="mb-3 text-sm text-red-600 dark:text-red-400">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="add" class="flex gap-2 mb-4">
        <input
            type="date"
            wire:model="date"
            class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-2 py-1.5 text-zinc-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-brand"
            required
        />
        <input
            type="text"
            wire:model="reason"
            placeholder="Reason (optional)"
            class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-2 py-1.5 text-zinc-900 dark:text-white text-sm flex-1 focus:outline-none focus:ring-2 focus:ring-brand"
        />
        <button type="submit" class="bg-brand hover:bg-brand-dark text-white px-3 py-1.5 rounded-lg text-sm font-medium transition duration-200">Add</button>
    </form>

    <div class="space-y-2">
        @foreach($closures as $c)
            <div class="flex items-center justify-between border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 bg-zinc-50 dark:bg-zinc-800/50">
                <div class="text-sm text-zinc-800 dark:text-zinc-200">{{ $c->date->format('M d, Y') }} – {{ $c->reason ?? 'Closed' }}</div>
                <div>
                    <button wire:click="remove({{ $c->id }})" class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs font-semibold transition">Remove</button>
                </div>
            </div>
        @endforeach
    </div>
</div>

