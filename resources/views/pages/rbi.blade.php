<x-layouts::app :title="__('RBI Inhabitants Registry')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">RBI Inhabitants Registry</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">View and manage the official Barangay records seeded from RBI 2025.</p>
        </div>
        
        <livewire:admin.manage-rbi />
    </div>
</x-layouts::app>
