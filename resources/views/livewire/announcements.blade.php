<div class="py-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto space-y-3 mb-8">
        <span class="text-brand text-lg font-bold uppercase tracking-wider font-outfit">Bulletins & Feeds</span>
        <h2 class="text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Community Notice Board</h2>
        <p class="text-zinc-500 text-sm leading-relaxed font-light">Official statements, seasonal alerts, and local assembly programs.</p>
    </div>

    <div class="space-y-6">
        @forelse($announcements as $a)
            <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-lg">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="text-sm text-zinc-400">{{ ucfirst($a->type) }} @if($a->is_pinned) • <span class="text-brand font-bold">Pinned</span>@endif</div>
                        <h3 class="font-extrabold text-2xl text-zinc-900 dark:text-white mt-2">{{ $a->title }}</h3>
                        <p class="text-base text-zinc-600 dark:text-zinc-300 mt-4 leading-relaxed">{{ $a->body }}</p>
                    </div>
                    <div class="text-right text-sm text-zinc-400">
                        <div>Published</div>
                        <div class="font-medium text-zinc-500 mt-1">{{ $a->published_at ? $a->published_at->diffForHumans() : 'Draft' }}</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm text-zinc-500">No announcements yet.</div>
        @endforelse
    </div>
</div>
