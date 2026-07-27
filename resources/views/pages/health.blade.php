<x-layouts::app :title="__('Health-based Data')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Health-based Data</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Complete health and medical history registry of all barangay residents.</p>
        </div>

        <livewire:health.health-dashboard />
    </div>
</x-layouts::app>
