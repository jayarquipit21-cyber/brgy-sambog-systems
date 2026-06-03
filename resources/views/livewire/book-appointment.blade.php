<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-4">
        <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Book a Document Pickup Appointment</flux:heading>
        <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Specify the documents you need and choose a date to pick them up personally.</flux:text>
    </div>

    <form wire:submit="book" class="space-y-4">
        @if((isset($dateClosures) && $dateClosures->count()) || (isset($weekdayClosures) && $weekdayClosures->count()))
            <div class="bg-yellow-50 border border-yellow-200 p-3 rounded text-sm text-zinc-800">
                <strong>Closures:</strong>
                <ul class="list-disc pl-5 mt-1">
                    @if(isset($dateClosures))
                        @foreach($dateClosures as $c)
                            <li>{{ $c->date->format('M d, Y') }}: {{ $c->reason ?? 'Closed' }}</li>
                        @endforeach
                    @endif
                    @if(isset($weekdayClosures))
                        @foreach($weekdayClosures as $weekday => $closure)
                            <li>{{ ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'][$weekday-1] }}: {{ $closure->reason ?? 'Closed' }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
            
            {{-- Holiday dates toggle button (shows national holidays but not admin-managed closures) --}}
            <div class="mt-3">
                <button id="toggleHolidays" type="button" class="inline-flex items-center gap-2 px-3 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md text-sm hover:shadow-sm">
                    Show Holiday Dates
                </button>

                <div id="holidaysPanel" class="mt-3 hidden bg-white dark:bg-zinc-900 p-3 rounded border border-zinc-200 dark:border-zinc-800 text-sm">
                    @if(isset($holidays) && count($holidays))
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($holidays as $h)
                                <li>{{ \Illuminate\Support\Carbon::parse($h['date'])->format('M d, Y') }}: {{ $h['name'] }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-zinc-500">No upcoming national holidays.</div>
                    @endif
                </div>
            </div>
        @endif
        <!-- Date -->
        <div>
            <label for="appointment_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Preferred Pickup Date</label>
            <input 
                id="appointment_date"
                type="date" 
                wire:model="appointment_date"
                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                required
                min="{{ date('Y-m-d') }}"
                onchange="const d = new Date(this.value); const day = d.getUTCDay(); if(day === 0 || day === 6){ alert('Appointments may be closed on weekends. Please check closure notices.'); }"
            />
            <p id="closure_notice" class="text-xs text-red-600 mt-1"></p>
            @error('appointment_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Time Slot -->
        <div>
            <label for="appointment_time" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Preferred Time Slot</label>
            <select 
                id="appointment_time"
                wire:model="appointment_time"
                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
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
                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                required
            ></textarea>
            @error('purpose') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Submit -->
        <div class="flex justify-end pt-2">
            <flux:button id="book_submit" variant="primary" type="submit" class="bg-brand hover:bg-brand-dark text-white py-2 px-4 rounded-lg font-medium text-sm transition shadow-sm">
                Book Appointment
            </flux:button>
        </div>
    </form>
    <script>
        (function(){
            // Build map of closed dates -> reason
            const dateClosures = @json(isset($dateClosures) ? $dateClosures->map(function($c){ return ['date' => $c->date->toDateString(), 'reason' => $c->reason]; }) : []);
            const closedMap = new Map(dateClosures.map(d => [d.date, d.reason]));
            const dateInput = document.getElementById('appointment_date');
            const submitBtn = document.getElementById('book_submit');
            const closureNotice = document.getElementById('closure_notice');

            function check(dateStr){
                if(!dateStr){ submitBtn.disabled = false; closureNotice.textContent = ''; return; }
                if(closedMap.has(dateStr)){
                    const reason = closedMap.get(dateStr) || 'Closed';
                    alert('Appointments are closed on this date. ' + reason);
                    dateInput.value = '';
                    submitBtn.disabled = true;
                    closureNotice.textContent = 'Closed: ' + reason;
                } else {
                    submitBtn.disabled = false;
                    closureNotice.textContent = '';
                }
            }

            if(dateInput){
                dateInput.addEventListener('change', function(){ check(this.value); });
                // initial check
                check(dateInput.value);
            }
        })();

        // Holiday toggle
        document.addEventListener('DOMContentLoaded', function(){
            const btn = document.getElementById('toggleHolidays');
            const panel = document.getElementById('holidaysPanel');
            if(btn && panel){
                btn.addEventListener('click', function(){
                    const open = !panel.classList.contains('hidden');
                    if(open){
                        panel.classList.add('hidden');
                        btn.textContent = 'Show Holiday Dates';
                    } else {
                        panel.classList.remove('hidden');
                        btn.textContent = 'Hide Holiday Dates';
                    }
                });
            }
        });
    </script>
</div>
