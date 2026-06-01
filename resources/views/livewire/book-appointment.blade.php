<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-4">
        <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Book a Document Pickup Appointment</flux:heading>
        <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Specify the documents you need and choose a date to pick them up personally.</flux:text>
    </div>

    <form wire:submit="book" class="space-y-4">
        @if(isset($closures) && $closures->count())
            <div class="bg-yellow-50 border border-yellow-200 p-3 rounded text-sm text-zinc-800">
                <strong>Closures:</strong>
                <ul class="list-disc pl-5 mt-1">
                    @foreach($closures as $weekday => $closure)
                        <li>{{ ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'][$weekday-1] }}: {{ $closure->reason ?? 'Closed' }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Date -->
        <div>
            <label for="appointment_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Preferred Pickup Date</label>
            <input 
                id="appointment_date"
                type="date" 
                wire:model="appointment_date"
                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm"
                required
                min="{{ date('Y-m-d') }}"
                onchange="const d = new Date(this.value); const day = d.getUTCDay(); if(day === 0 || day === 6){ alert('Appointments may be closed on weekends. Please check closure notices.'); }"
            />
            @error('appointment_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Time Slot -->
        <div>
            <label for="appointment_time" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Preferred Time Slot</label>
            <select 
                id="appointment_time"
                wire:model="appointment_time"
                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm"
                required
            >
                <option value="">Select a time slot</option>
                <option value="09:00 AM - 10:00 AM">09:00 AM - 10:00 AM (Morning)</option>
                <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM (Morning)</option>
                <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM (Morning)</option>
                <option value="01:00 PM - 02:00 PM">01:00 PM - 02:00 PM (Afternoon)</option>
                <option value="02:00 PM - 03:00 PM">02:00 PM - 03:00 PM (Afternoon)</option>
                <option value="03:00 PM - 04:00 PM">03:00 PM - 04:00 PM (Afternoon)</option>
            </select>
            @error('appointment_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Purpose / Document Details -->
        <div>
            <label for="purpose" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Required Document(s) & Purpose</label>
            <textarea 
                id="purpose"
                wire:model="purpose"
                rows="3"
                placeholder="e.g. Requesting 1 copy of Barangay Clearance and 1 copy of Certificate of Indigency for job application purposes."
                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm"
                required
            ></textarea>
            @error('purpose') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Submit -->
        <div class="flex justify-end pt-2">
            <flux:button variant="primary" type="submit" class="bg-[#f53003] hover:bg-[#d62700] text-white py-2 px-4 rounded-lg font-medium text-sm transition shadow-sm">
                Book Appointment
            </flux:button>
        </div>
    </form>
</div>
