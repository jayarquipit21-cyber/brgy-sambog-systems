<x-layouts::app :title="__('Utility & Equipment Rentals')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Utility & Equipment Rentals</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Book barangay facilities, covered basketball court, monoblock chairs, banquet tables, heavy-duty tents, and sound systems.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[9fr_11fr] gap-8">
            <div>
                <livewire:book-appointment appointment_category="rental" />
            </div>
            <div>
                <livewire:my-appointments type="rental" />
            </div>
        </div>
    </div>
</x-layouts::app>
