<div>
    <!-- ─── Filter Bar ──────────────────────────────────────────────────────── -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-sm mb-6 flex flex-col sm:flex-row gap-3 items-start sm:items-center">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Search by name or condition..."
            class="flex-1 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 text-sm"
        />
        <select wire:model.live="nameLetter"
            class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 text-sm">
            <option value="">First Name (A–Z)</option>
            @foreach(range('A', 'Z') as $letter)
                <option value="{{ $letter }}">First Name Starts with {{ $letter }}</option>
            @endforeach
        </select>
        <select wire:model.live="ageGroupFilter"
            class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 text-sm">
            <option value="">All Age Groups</option>
            <option value="pediatric">Pediatric (0-12)</option>
            <option value="youth">Youth (13-24)</option>
            <option value="adult">Adult (25-59)</option>
            <option value="senior">Senior (60+)</option>
        </select>
        <select wire:model.live="healthFilter"
            class="rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 text-sm">
            <option value="">All Residents</option>
            <option value="has_condition">With Health Condition</option>
            <option value="none">No Health Condition</option>
            <option value="Hypertension">Hypertension</option>
            <option value="Diabetes">Diabetes</option>
            <option value="Asthma">Asthma</option>
            <option value="Arthritis">Arthritis</option>
            <option value="Heart">Heart Conditions</option>
            <option value="SAM">Malnutrition (SAM/MAM)</option>
        </select>
    </div>

    <!-- ─── Residents Table ─────────────────────────────────────────────────── -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Resident Health Records</h2>
                <p class="text-xs text-zinc-500 mt-0.5">Click <strong>Edit</strong> to update a resident's health and medical data.</p>
            </div>
            <span class="text-xs text-zinc-400 dark:text-zinc-500">{{ $residents->total() }} records</span>
        </div>

        @if($residents->isEmpty())
            <div class="text-center py-16 text-zinc-400 dark:text-zinc-500">
                <svg class="mx-auto h-10 w-10 mb-3 text-zinc-300 dark:text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm">No residents found.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                    <thead>
                        <tr class="text-[10px] uppercase font-semibold text-zinc-500 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4 text-center">Age / Sex</th>
                            <th class="py-3 px-4">Blood Type</th>
                            <th class="py-3 px-4">Health Condition</th>
                            <th class="py-3 px-4">Nutrition</th>
                            <th class="py-3 px-4">Vaccine</th>
                            <th class="py-3 px-4">Vulnerable</th>
                            <th class="py-3 px-4">PhilHealth</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($residents as $res)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition">
                                <td class="py-3 px-4 font-semibold text-zinc-900 dark:text-white whitespace-nowrap">
                                    {{ $res->last_name }}, {{ $res->first_name }}
                                    @if($res->middle_name) {{ substr($res->middle_name, 0, 1) }}.@endif
                                    @if($res->extension) {{ $res->extension }}@endif
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <span class="font-medium text-zinc-900 dark:text-white">{{ $res->age ?? '—' }}</span>
                                    <span class="text-zinc-400 text-xs"> / {{ $res->sex ?? '—' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($res->blood_type)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/20 dark:text-rose-400 dark:border-rose-900/50">{{ $res->blood_type }}</span>
                                    @else
                                        <span class="text-zinc-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($res->health_condition && $res->health_condition !== 'None')
                                        <span class="text-zinc-900 dark:text-white font-medium text-xs">{{ $res->health_condition }}</span>
                                    @else
                                        <span class="text-emerald-600 dark:text-emerald-400 text-xs">No condition</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-xs text-zinc-600 dark:text-zinc-400">
                                    {{ $res->nutritional_classification ?: 'Normal' }}
                                </td>
                                <td class="py-3 px-4 text-xs">
                                    @if($res->fully_vaccinated === 'Y')
                                        <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Fully</span>
                                    @elseif($res->partially_vaccinated === 'Y')
                                        <span class="text-amber-600 dark:text-amber-400">Partial</span>
                                    @else
                                        <span class="text-red-500">None</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-xs">
                                    @if($res->vulnerable_sector && $res->vulnerable_sector !== 'None')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-violet-50 text-violet-800 border border-violet-200 dark:bg-violet-950/20 dark:text-violet-400 dark:border-violet-900/50">{{ $res->vulnerable_sector }}</span>
                                    @else
                                        <span class="text-zinc-400">—</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-xs">
                                    @if($res->has_philhealth === 'Y')
                                        <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Yes</span>
                                    @else
                                        <span class="text-red-400">No</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <button wire:click="openEdit({{ $res->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-violet-50 hover:bg-violet-100 text-violet-700 dark:bg-violet-500/10 dark:hover:bg-violet-500/20 dark:text-violet-400 border border-violet-200 dark:border-violet-500/20 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-zinc-100 dark:border-zinc-800">
                {{ $residents->links() }}
            </div>
        @endif
    </div>

    <!-- ─── Edit Modal ───────────────────────────────────────────────────────── -->
    @if($showEditModal && $editingResident)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" wire:click.self="closeModal">
            <div class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-800 mx-4">

                <!-- Modal Header -->
                <div class="sticky top-0 z-10 flex items-center justify-between px-6 py-4 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 rounded-t-2xl">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-violet-500/10 text-violet-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">
                                Edit Health Record
                            </h3>
                            <p class="text-xs text-zinc-500">
                                {{ $editingResident->last_name }}, {{ $editingResident->first_name }}
                                {{ $editingResident->middle_name ? substr($editingResident->middle_name,0,1).'.' : '' }}
                                &mdash; Age {{ $editingResident->age ?? 'N/A' }}, {{ $editingResident->sex ?? '' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="p-2 rounded-xl text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="px-6 py-6 space-y-6">

                    <!-- ── Section: Basic Physical ────────────────────────────── -->
                    <div>
                        <h4 class="text-xs font-extrabold uppercase tracking-widest text-violet-600 dark:text-violet-400 mb-3">Physical Information</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Blood Type</label>
                                <select wire:model="blood_type"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <option value="">— Select —</option>
                                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                                        <option value="{{ $bt }}" @selected($blood_type === $bt)>{{ $bt }}</option>
                                    @endforeach
                                </select>
                                @error('blood_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Height (cm)</label>
                                <input type="text" wire:model="height" placeholder="e.g. 160"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500"/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Weight (kg)</label>
                                <input type="text" wire:model="weight" placeholder="e.g. 55"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500"/>
                            </div>
                        </div>
                    </div>

                    <!-- ── Section: Medical Profile ───────────────────────────── -->
                    <div class="border-t border-zinc-100 dark:border-zinc-800 pt-5">
                        <h4 class="text-xs font-extrabold uppercase tracking-widest text-violet-600 dark:text-violet-400 mb-3">Medical Profile</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Health Condition</label>
                                <input type="text" wire:model="health_condition"
                                    placeholder="e.g. Hypertension, Diabetes, None..."
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500"/>
                                @error('health_condition') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Nutritional Classification</label>
                                <select wire:model="nutritional_classification"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <option value="">— Select —</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Underweight">Underweight</option>
                                    <option value="Overweight">Overweight</option>
                                    <option value="Obese">Obese</option>
                                    <option value="SAM">Severely Acute Malnourished (SAM)</option>
                                    <option value="MAM">Moderately Acute Malnourished (MAM)</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Vulnerable Sector</label>
                                <select wire:model="vulnerable_sector"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <option value="">— Select —</option>
                                    <option value="None">None</option>
                                    <option value="PWD">Person with Disability (PWD)</option>
                                    <option value="Senior Citizen">Senior Citizen</option>
                                    <option value="Pregnant">Pregnant</option>
                                    <option value="Solo Parent">Solo Parent</option>
                                    <option value="Indigenous People">Indigenous People</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ── Section: Vaccination ───────────────────────────────── -->
                    <div class="border-t border-zinc-100 dark:border-zinc-800 pt-5">
                        <h4 class="text-xs font-extrabold uppercase tracking-widest text-violet-600 dark:text-violet-400 mb-3">Vaccination Status</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center gap-3 p-3 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                <input type="radio" id="vax_fully" wire:model="fully_vaccinated" value="Y" class="accent-emerald-500"/>
                                <label for="vax_fully" class="text-sm font-semibold text-zinc-800 dark:text-white cursor-pointer">Fully Vaccinated</label>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                <input type="radio" id="vax_partial" wire:model="fully_vaccinated" value="" class="accent-amber-500"/>
                                <label for="vax_partial" class="text-sm font-semibold text-zinc-800 dark:text-white cursor-pointer">Partially</label>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                <input type="radio" id="vax_none" wire:model="fully_vaccinated" value="N" class="accent-red-500"/>
                                <label for="vax_none" class="text-sm font-semibold text-zinc-800 dark:text-white cursor-pointer">Unvaccinated</label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">COVID Dose 1 Date</label>
                                <input type="date" wire:model="covid_dose_1_date"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500"/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">COVID Dose 2 Date</label>
                                <input type="date" wire:model="covid_dose_2_date"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500"/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">COVID Vaccine Brand</label>
                                <select wire:model="covid_brand"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <option value="">— Select —</option>
                                    @foreach(['Pfizer','Moderna','AstraZeneca','Sinovac','Johnson & Johnson','Sputnik V','Nuvaxovid'] as $brand)
                                        <option value="{{ $brand }}">{{ $brand }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Booster -->
                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Has Booster?</label>
                                <select wire:model="has_booster"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <option value="">— Select —</option>
                                    <option value="Y">Yes</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Booster Date</label>
                                <input type="date" wire:model="booster_date"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500"/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Booster Brand</label>
                                <select wire:model="booster_brand"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <option value="">— Select —</option>
                                    @foreach(['Pfizer','Moderna','AstraZeneca','Sinovac','Johnson & Johnson','Sputnik V','Nuvaxovid'] as $brand)
                                        <option value="{{ $brand }}">{{ $brand }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ── Section: PhilHealth ────────────────────────────────── -->
                    <div class="border-t border-zinc-100 dark:border-zinc-800 pt-5">
                        <h4 class="text-xs font-extrabold uppercase tracking-widest text-violet-600 dark:text-violet-400 mb-3">PhilHealth</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Enrolled in PhilHealth?</label>
                                <select wire:model="has_philhealth"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <option value="">— Select —</option>
                                    <option value="Y">Yes</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">PhilHealth ID No.</label>
                                <input type="text" wire:model="philhealth_id" placeholder="e.g. 12-345678901-2"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500"/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">Membership Type</label>
                                <select wire:model="philhealth_membership_type"
                                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <option value="">— Select —</option>
                                    <option value="Employed">Employed</option>
                                    <option value="Self-Employed">Self-Employed</option>
                                    <option value="Indigent">Indigent (4Ps)</option>
                                    <option value="Senior Citizen">Senior Citizen</option>
                                    <option value="Lifetime">Lifetime</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ── Footer Buttons ─────────────────────────────────────── -->
                    <div class="border-t border-zinc-100 dark:border-zinc-800 pt-5 flex justify-end gap-3">
                        <button type="button" wire:click="closeModal"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 border border-zinc-200 dark:border-zinc-700 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-violet-500 to-violet-600 hover:from-violet-600 hover:to-violet-700 shadow-md shadow-violet-500/15 transition focus:outline-none focus:ring-2 focus:ring-violet-500">
                            <span wire:loading.remove wire:target="save">Save Health Record</span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
