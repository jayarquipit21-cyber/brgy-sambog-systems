<x-layouts::app :title="__('My Household Registry')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">My Household Registry</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">View registered family members associated with your household unit.</p>
        </div>

        <livewire:my-household />
    </div>
</x-layouts::app>
