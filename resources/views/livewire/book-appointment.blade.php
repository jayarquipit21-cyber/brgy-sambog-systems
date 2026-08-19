<div class="bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-lg space-y-4 font-outfit">
    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-3">
        <div class="flex items-center gap-3">
            <div class="p-2.5 @if($appointment_category === 'rental') bg-amber-500/10 text-amber-600 dark:text-amber-400 @else bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 @endif rounded-xl transition-colors duration-200" aria-hidden="true">
                @if($appointment_category === 'rental')
                    <flux:icon name="building-office" class="size-5" />
                @else
                    <flux:icon name="document-text" class="size-5" />
                @endif
            </div>
            <div>
                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">
                    @if($appointment_category === 'rental')
                        Barangay Rental & Facility Reservation
                    @else
                        Barangay Official Document Request
                    @endif
                </h3>
                <p class="text-[11px] text-zinc-500 font-light">
                    @if($appointment_category === 'rental')
                        Reserve barangay facilities, covered court, tents, chairs, tables, and sound system
                    @else
                        Request official clearances, indigency, residency proof, business permits, & inhabitant IDs
                    @endif
                </p>
            </div>
        </div>
    </div>

    <form wire:submit="book" class="space-y-4">



        <!-- Item Dropdown Select (Documents vs Rentals) -->
        <div>
            <label for="document_type" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                @if($appointment_category === 'rental')
                    Select Rental Service / Facility <span class="text-amber-500">*</span>
                @else
                    Select Barangay Document <span class="text-emerald-500">*</span>
                @endif
            </label>
            <div class="relative">
                <select 
                    id="document_type" 
                    wire:model.live="document_type"
                    class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700/80 bg-white dark:bg-zinc-800/90 px-3.5 py-2.5 text-xs font-bold text-zinc-900 dark:text-white focus:outline-none focus:ring-2 transition shadow-sm cursor-pointer @if($appointment_category === 'rental') focus:border-amber-500 focus:ring-amber-500/20 @else focus:border-emerald-500 focus:ring-emerald-500/20 @endif"
                    required
                >
                    @if($appointment_category === 'rental')
                        <option value="" disabled selected>-- Choose Rental Equipment or Facility --</option>
                        @foreach(\App\Livewire\BookAppointment::$availableRentals as $rental => $desc)
                            <option value="{{ $rental }}" class="py-1">{{ $rental }}</option>
                        @endforeach
                    @else
                        <option value="" disabled selected>-- Choose Barangay Document --</option>
                        @foreach(\App\Livewire\BookAppointment::$availableDocuments as $doc => $desc)
                            <option value="{{ $doc }}" class="py-1">{{ $doc }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            @error('document_type') <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror

            <!-- Selected Item Description Helper Badge -->
            @php
                $itemDict = ($appointment_category === 'rental') 
                    ? \App\Livewire\BookAppointment::$availableRentals 
                    : \App\Livewire\BookAppointment::$availableDocuments;
            @endphp
            @if($document_type && isset($itemDict[$document_type]))
                @php
                    $itemFee = \App\Models\ServiceFee::getFeeByName($document_type);
                @endphp
                <div class="mt-2.5 p-2.5 rounded-xl flex items-start justify-between gap-2.5 animate-fadeIn border @if($appointment_category === 'rental') bg-amber-50/70 dark:bg-amber-950/20 border-amber-200/60 dark:border-amber-800/40 @else bg-emerald-50/70 dark:bg-emerald-950/20 border-emerald-200/60 dark:border-emerald-800/40 @endif">
                    <div class="flex items-start gap-2">
                        <flux:icon name="information-circle" class="size-4 shrink-0 mt-0.5 @if($appointment_category === 'rental') text-amber-600 dark:text-amber-400 @else text-emerald-600 dark:text-emerald-400 @endif" aria-hidden="true" />
                        <div class="text-[11px] @if($appointment_category === 'rental') text-amber-900/80 dark:text-amber-300 @else text-emerald-900/80 dark:text-emerald-300 @endif">
                            <strong class="font-bold">{{ $document_type }}:</strong> {{ $itemDict[$document_type] }}
                        </div>
                    </div>
                    <div class="shrink-0 text-right">
                        @if($itemFee == 0.00)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 border border-emerald-300/60">FREE / EXEMPTED</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-extrabold @if($appointment_category === 'rental') bg-amber-100 dark:bg-amber-900/40 text-amber-900 dark:text-amber-300 border border-amber-300/60 @else bg-emerald-100 dark:bg-emerald-900/40 text-emerald-900 dark:text-emerald-300 border border-emerald-300/60 @endif">
                                ₱{{ number_format($itemFee, 2) }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Preferred Rental / Event Date Picker (Rental Category Only) -->
        @if($appointment_category === 'rental')
            <div>
                <label for="rental_date" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                    Preferred Rental / Event Date <span class="text-zinc-400 font-normal lowercase">(optional)</span>
                </label>
                <input 
                    type="date" 
                    id="rental_date" 
                    wire:model="rental_date"
                    min="{{ date('Y-m-d') }}"
                    class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700/80 bg-white dark:bg-zinc-800/90 px-3.5 py-2.5 text-xs text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:outline-none focus:ring-2 transition shadow-sm focus:border-amber-500 focus:ring-amber-500/20 cursor-pointer"
                />
                @error('rental_date') <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
            </div>
        @endif

        <!-- Additional Remarks & Event / Purpose Details -->
        <div>
            <label for="purpose_details" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1.5">
                @if($appointment_category === 'rental')
                    Quantity & Rental Remarks @if(str_contains($document_type, 'Other')) <span class="text-amber-500">*</span> @else <span class="text-zinc-400 font-normal lowercase">(optional)</span> @endif
                @else
                    Purpose & Additional Remarks @if(str_contains($document_type, 'Other')) <span class="text-emerald-500">*</span> @else <span class="text-zinc-400 font-normal lowercase">(optional)</span> @endif
                @endif
            </label>
            <textarea 
                 id="purpose_details"
                 wire:model="purpose_details"
                 rows="3"
                 placeholder="@if($appointment_category === 'rental') e.g. Requesting 50 monoblock chairs and 2 tents for a family event at Purok 2 on Saturday, Aug 15. @else e.g. For employment application at ABC Company, or medical financial assistance at Bohol Doctors Hospital. @endif"
                 class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700/80 bg-white dark:bg-zinc-800/90 px-3.5 py-2.5 text-xs text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:outline-none focus:ring-2 transition shadow-sm @if($appointment_category === 'rental') focus:border-amber-500 focus:ring-amber-500/20 @else focus:border-emerald-500 focus:ring-emerald-500/20 @endif"
                 @if(str_contains($document_type, 'Other')) required @endif
            ></textarea>
            @error('purpose_details') <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between pt-2 border-t border-zinc-100 dark:border-zinc-800/80">
            <span class="text-[10px] text-zinc-400">
                @if($appointment_category === 'rental')
                    Barangay Sambog facility & equipment booking
                @else
                    Official document request for Barangay Sambog
                @endif
            </span>
            <flux:button id="book_submit" variant="primary" type="submit" class="font-bold py-2 px-4 rounded-xl text-xs shadow-md transition-all duration-200 hover:-translate-y-0.5 text-white @if($appointment_category === 'rental') bg-amber-600 hover:bg-amber-700 @else bg-emerald-600 hover:bg-emerald-700 @endif">
                @if($appointment_category === 'rental')
                    Submit Rental Request
                @else
                    Submit Document Request
                @endif
            </flux:button>
        </div>
    </form>
</div>


