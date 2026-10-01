<div class="space-y-4">
    <div class="bg-white dark:bg-zinc-900 shadow-md rounded-2xl p-6 border border-zinc-200 dark:border-zinc-800">
        {{-- Header --}}
        <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-zinc-100 dark:border-zinc-800 pb-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-xl {{ $serviceType === 'rental' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'bg-sky-500/10 text-sky-600 dark:text-sky-400' }}">
                    <flux:icon :name="$serviceType === 'rental' ? 'building-office' : 'document-text'" class="size-5" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">
                        {{ $serviceType === 'rental' ? 'Rental Payment History' : 'Document Payment History' }}
                    </h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        @if($isAdmin)
                            All official {{ $serviceType === 'rental' ? 'rental & facility' : 'document clearance' }} fee collection records and receipts.
                        @else
                            Your personal {{ $serviceType === 'rental' ? 'rental & facility booking' : 'document clearance' }} payment records and receipts.
                        @endif
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if($isAdmin)
                    {{-- Search (Admin Only) --}}
                    <div class="relative">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search payer, address, item, OR#, code..."
                            class="w-full sm:w-56 pl-8 pr-3 py-1.5 text-xs font-medium rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/90 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-{{ $serviceType === 'rental' ? 'amber' : 'sky' }}-500/20 focus:border-{{ $serviceType === 'rental' ? 'amber' : 'sky' }}-500"
                        />
                        <flux:icon name="magnifying-glass" class="size-3.5 absolute left-2.5 top-2 text-zinc-400" />
                    </div>
                @endif

                <span class="text-xs font-bold {{ $serviceType === 'rental' ? 'text-amber-700 dark:text-amber-400 bg-amber-500/10 border-amber-500/20' : 'text-sky-700 dark:text-sky-400 bg-sky-500/10 border-sky-500/20' }} border px-2.5 py-1 rounded-full whitespace-nowrap">
                    {{ $transactions->total() }} {{ $transactions->total() === 1 ? 'Record' : 'Records' }}
                </span>
            </div>
        </div>

        {{-- Table --}}
        @if($transactions->isEmpty())
            <div class="text-center py-10 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl border border-dashed border-zinc-200 dark:border-zinc-800 p-6">
                <flux:icon :name="$serviceType === 'rental' ? 'building-office' : 'document-text'" class="size-10 text-zinc-300 dark:text-zinc-700 mx-auto mb-2" />
                <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400">No payment records found.</p>
                <p class="text-xs text-zinc-400 mt-1">
                    @if($isAdmin)
                        Transaction records will appear here once payments are collected for {{ $serviceType === 'rental' ? 'rentals' : 'document requests' }}.
                    @else
                        Your payment history will appear here once you have completed {{ $serviceType === 'rental' ? 'rental bookings' : 'document requests' }}.
                    @endif
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-zinc-700 dark:text-zinc-300 border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-[10px] font-bold uppercase tracking-wider">
                            <th class="py-3 px-4">TXN Code & Date</th>
                            @if($isAdmin)
                                <th class="py-3 px-4">Payer Name</th>
                            @endif
                            <th class="py-3 px-4">Service Item</th>
                            <th class="py-3 px-4 text-center">Payment Method</th>
                            <th class="py-3 px-4 text-center">OR Number</th>
                            <th class="py-3 px-4 text-right">Amount (₱)</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 font-medium">
                        @foreach($transactions as $txn)
                            <tr class="odd:bg-zinc-50/40 hover:bg-{{ $serviceType === 'rental' ? 'amber' : 'sky' }}-50/30 dark:odd:bg-zinc-900/20 dark:hover:bg-{{ $serviceType === 'rental' ? 'amber' : 'sky' }}-950/10 transition">
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="font-bold text-zinc-900 dark:text-white font-mono text-[11px]">{{ $txn->transaction_code }}</span>
                                    <div class="text-[10px] text-zinc-400">{{ $txn->created_at->format('M d, Y h:i A') }}</div>
                                </td>
                                @if($isAdmin)
                                    <td class="py-3 px-4">
                                        <div class="font-bold text-zinc-900 dark:text-white">{{ $txn->payer_name }}</div>
                                        @if($txn->payer_address)
                                            <div class="text-[10px] text-zinc-400 truncate max-w-xs">{{ $txn->payer_address }}</div>
                                        @endif
                                    </td>
                                @endif
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="p-1 rounded {{ $serviceType === 'rental' ? 'bg-amber-500/10 text-amber-600' : 'bg-sky-500/10 text-sky-600' }}">
                                            <flux:icon :name="$serviceType === 'rental' ? 'building-office' : 'document-text'" class="size-3.5" />
                                        </span>
                                        <span class="font-bold text-zinc-900 dark:text-white">{{ $txn->item_name }}</span>
                                    </div>
                                    @if($txn->quantity > 1)
                                        <div class="text-[10px] text-zinc-400">Qty: {{ $txn->quantity }} @ ₱{{ number_format($txn->unit_price, 2) }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                        @if($txn->payment_method === 'gcash') bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-300
                                        @elseif($txn->payment_method === 'maya') bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300
                                        @elseif($txn->payment_method === 'free_exemption') bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300
                                        @else bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200
                                        @endif
                                    ">
                                        {{ str_replace('_', ' ', $txn->payment_method) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    @if($txn->official_receipt_number)
                                        <span class="font-mono text-[11px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                                            {{ $txn->official_receipt_number }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400 dark:text-zinc-600">&mdash;</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right whitespace-nowrap">
                                    @if($txn->payment_status === 'waived')
                                        <span class="font-extrabold text-emerald-600 dark:text-emerald-400">FREE</span>
                                    @else
                                        <span class="font-extrabold text-zinc-950 dark:text-white text-sm">₱{{ number_format($txn->amount_paid > 0 ? $txn->amount_paid : $txn->total_amount, 2) }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    @if($txn->payment_status === 'paid')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800/40">
                                            PAID
                                        </span>
                                    @elseif($txn->payment_status === 'waived')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-700 border border-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700">
                                            WAIVED
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800/40">
                                            PENDING
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
