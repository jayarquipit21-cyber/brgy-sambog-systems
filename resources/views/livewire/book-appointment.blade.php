<div class="bg-white dark:bg-zinc-900 shadow-md rounded-xl p-6 border border-zinc-200 dark:border-zinc-800">
    <div class="mb-4">
        <flux:heading size="lg" level="2" class="text-zinc-900 dark:text-white font-semibold">Request Document Redemption</flux:heading>
        <flux:text variant="subtle" class="text-xs text-zinc-500 dark:text-zinc-400">Specify the documents you need. Once reviewed and fully signed by the Kapitan, you will be scheduled a set date for pickup.</flux:text>
    </div>

    <form wire:submit="book" class="space-y-4">
        <!-- Purpose / Document Details -->
        <div>
            <label for="purpose" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Required Document(s) & Purpose</label>
            <textarea 
                 id="purpose"
                 wire:model="purpose"
                 rows="4"
                 placeholder="e.g. Requesting 1 copy of Barangay Clearance and 1 copy of Certificate of Indigency for job application purposes."
                 class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-zinc-950 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand text-sm"
                 required
            ></textarea>
            @error('purpose') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Submit -->
        <div class="flex justify-end pt-2">
            <flux:button id="book_submit" variant="primary" type="submit" class="bg-brand hover:bg-brand-dark text-white py-2 px-4 rounded-lg font-medium text-sm transition shadow-sm">
                Submit Request
            </flux:button>
        </div>
    </form>
</div>
