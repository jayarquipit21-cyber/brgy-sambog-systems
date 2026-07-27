<x-layouts::app :title="__('Update Health Records')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Update Health Records</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Edit health conditions, vaccination status, PhilHealth, and medical data for barangay residents.</p>
        </div>

        <livewire:health.edit-health-record />
    </div>
</x-layouts::app>
