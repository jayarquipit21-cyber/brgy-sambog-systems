<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-4">
        <h2 class="text-lg font-semibold">Manage Appointment Closures</h2>
        <p class="text-xs text-zinc-500">Mark weekdays as closed and provide an optional reason.</p>
    </div>

    @if (session('message'))
        <div class="mb-3 text-sm text-green-600">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save" class="space-y-3">
        @foreach(['1' => 'Monday','2' => 'Tuesday','3' => 'Wednesday','4' => 'Thursday','5' => 'Friday','6' => 'Saturday','7' => 'Sunday'] as $num => $label)
            <div class="flex items-center space-x-3">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model="weekdays.{{ $num }}.closed" class="form-checkbox" />
                    <span class="font-medium">{{ $label }}</span>
                </label>
                <input type="text" wire:model.defer="weekdays.{{ $num }}.reason" placeholder="Optional reason for closure" class="flex-1 rounded border px-2 py-1 text-sm" />
            </div>
        @endforeach

        <div class="pt-3">
            <button type="submit" class="bg-[#f53003] text-white px-4 py-2 rounded">Save</button>
        </div>
    </form>
</div>
