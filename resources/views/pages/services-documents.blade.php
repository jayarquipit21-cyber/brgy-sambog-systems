<x-layouts::app :title="__('Barangay Document Requests')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Barangay Document Requests</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Request official barangay clearances, indigency certificates, residency proof, business permits, and IDs, then track your pickup slots.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[9fr_11fr] gap-8">
            <div>
                <livewire:book-appointment appointment_category="document" />
            </div>
            <div>
                <livewire:my-appointments type="document" />
            </div>
        </div>
    </div>
</x-layouts::app>
