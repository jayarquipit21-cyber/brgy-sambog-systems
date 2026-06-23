<x-layouts::app :title="__('Blotter & Lupon Management')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Blotter & Lupon Management</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Record incidents, complaints, and manage barangay hearings.</p>
        </div>
        
        <livewire:admin.manage-blotters />
    </div>
</x-layouts::app>
