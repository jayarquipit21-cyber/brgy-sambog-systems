<x-layouts::app :title="__('Population Management')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Population Management</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Manage household registration requests and view the household heads directory.</p>
        </div>
        
        <livewire:admin.manage-rbi />
    </div>
</x-layouts::app>
