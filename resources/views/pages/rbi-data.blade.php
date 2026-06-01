<x-layouts::app :title="__('RBI Comprehensive Inhabitant Data')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">RBI Comprehensive Inhabitant Data</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">View a detailed grid containing all fields registered under the official Barangay Registry of Inhabitants (RBI).</p>
        </div>
        
        <livewire:admin.rbi-data-table />
    </div>
</x-layouts::app>
