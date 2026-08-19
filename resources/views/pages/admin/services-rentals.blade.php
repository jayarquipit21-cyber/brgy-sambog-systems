<x-layouts::app :title="__('Utility & Equipment Rentals Registry')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Utility & Equipment Rentals Registry</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Manage resident booking requests for barangay venue reservations, covered court, monoblock chairs, tables, tents, and sound systems.
            </p>
        </div>

        <livewire:admin.manage-appointments typeFilter="rental" />
    </div>
</x-layouts::app>
