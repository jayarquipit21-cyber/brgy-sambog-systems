<x-layouts::app :title="__('Appointments & Rentals')">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Appointments & Rentals</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                @if(auth()->user()->isAdmin())
                    Manage and review all document requests and rental service bookings submitted by Barangay residents.
                @else
                    Request official barangay documents or book rental services and facilities, then track your appointments.
                @endif
            </p>
        </div>

        @if(auth()->user()->isAdmin())
            <livewire:admin.manage-appointments />
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <livewire:book-appointment />
                </div>
                <div class="lg:col-span-2">
                    <livewire:my-appointments />
                </div>
            </div>
        @endif
    </div>
</x-layouts::app>

