<x-layouts::app :title="__('Document Requests Registry')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Document Requests Registry</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Review, approve, schedule pickup slots, or reject resident document requests (clearances, indigency, residency, business permits, IDs).
            </p>
        </div>

        <livewire:admin.manage-appointments typeFilter="document" />
    </div>
</x-layouts::app>
