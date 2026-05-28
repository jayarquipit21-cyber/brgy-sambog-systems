<x-layouts::app :title="__('Health concerns Database')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Health Concerns Database</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Strictly health-scoped view of resident records and vaccination coverages.</p>
        </div>

        <livewire:health.health-dashboard />
    </div>
</x-layouts::app>
