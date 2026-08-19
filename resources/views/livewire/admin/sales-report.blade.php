<div class="space-y-8 font-outfit">

    <!-- Header Actions & Livewire Title -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-zinc-900/60 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl">
                    <flux:icon name="banknotes" class="size-6" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Sales & Revenue Report</h1>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Official Barangay Sambog financial collections, clearance fees, and facility rental transactions.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center flex-wrap gap-2.5">
            <button 
                type="button" 
                onclick="window.print()" 
                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-800 dark:text-zinc-200 border border-zinc-300/80 dark:border-zinc-700 transition cursor-pointer"
            >
                <flux:icon name="printer" class="size-4" />
                <span>Print Official Report</span>
            </button>

            <button 
                type="button" 
                wire:click="openPricingModal" 
                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-800 dark:text-zinc-200 border border-zinc-300/80 dark:border-zinc-700 transition cursor-pointer"
            >
                <flux:icon name="cog-6-tooth" class="size-4" />
                <span>Configure Service Fees</span>
            </button>

            <button 
                type="button" 
                wire:click="openDirectSaleModal" 
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-extrabold bg-emerald-600 hover:bg-emerald-700 text-white shadow-md hover:shadow-emerald-500/20 transition cursor-pointer"
            >
                <flux:icon name="plus" class="size-4" />
                <span>Record Walk-in Collection</span>
            </button>
        </div>
    </div>

    <!-- Revenue Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- 1. Total Gross Revenue -->
        <div class="relative overflow-hidden rounded-2xl p-5 bg-gradient-to-br from-emerald-500/10 via-white to-white dark:from-emerald-950/40 dark:via-zinc-900 dark:to-zinc-900 border border-emerald-500/20 dark:border-emerald-500/30 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Total Collections</span>
                <div class="p-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                    <flux:icon name="banknotes" class="size-5" />
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl font-extrabold text-zinc-950 dark:text-white">₱{{ number_format($totalGrossRevenue, 2) }}</div>
                <div class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 mt-1 flex items-center gap-1.5">
                    <span>{{ $paidCount }} Paid Transactions</span>
                    <span class="text-zinc-300 dark:text-zinc-700">•</span>
                    <span>{{ $timeframe === 'all' ? 'All-time' : ucfirst(str_replace('_', ' ', $timeframe)) }}</span>
                </div>
            </div>
        </div>

        <!-- 2. Document Clearances Revenue -->
        <div class="relative overflow-hidden rounded-2xl p-5 bg-gradient-to-br from-sky-500/10 via-white to-white dark:from-sky-950/40 dark:via-zinc-900 dark:to-zinc-900 border border-sky-500/20 dark:border-sky-500/30 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-800 dark:text-sky-400">Document Clearances</span>
                <div class="p-2 rounded-xl bg-sky-500/10 text-sky-600 dark:text-sky-400">
                    <flux:icon name="document-text" class="size-5" />
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl font-extrabold text-zinc-950 dark:text-white">₱{{ number_format($documentRevenue, 2) }}</div>
                <div class="text-[11px] font-semibold text-sky-600 dark:text-sky-400 mt-1">
                    {{ $totalGrossRevenue > 0 ? round(($documentRevenue / $totalGrossRevenue) * 100, 1) : 0 }}% of total collection
                </div>
            </div>
        </div>

        <!-- 3. Rental & Facility Revenue -->
        <div class="relative overflow-hidden rounded-2xl p-5 bg-gradient-to-br from-amber-500/10 via-white to-white dark:from-amber-950/40 dark:via-zinc-900 dark:to-zinc-900 border border-amber-500/20 dark:border-amber-500/30 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-amber-400">Utility & Rentals</span>
                <div class="p-2 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                    <flux:icon name="building-office" class="size-5" />
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl font-extrabold text-zinc-950 dark:text-white">₱{{ number_format($rentalRevenue, 2) }}</div>
                <div class="text-[11px] font-semibold text-amber-600 dark:text-amber-400 mt-1">
                    {{ $totalGrossRevenue > 0 ? round(($rentalRevenue / $totalGrossRevenue) * 100, 1) : 0 }}% of total collection
                </div>
            </div>
        </div>

        <!-- 4. Pending / Free Exemptions -->
        <div class="relative overflow-hidden rounded-2xl p-5 bg-gradient-to-br from-violet-500/10 via-white to-white dark:from-violet-950/40 dark:via-zinc-900 dark:to-zinc-900 border border-violet-500/20 dark:border-violet-500/30 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-violet-800 dark:text-violet-400">Pending Receivables</span>
                <div class="p-2 rounded-xl bg-violet-500/10 text-violet-600 dark:text-violet-400">
                    <flux:icon name="clock" class="size-5" />
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl font-extrabold text-zinc-950 dark:text-white">₱{{ number_format($pendingAmount, 2) }}</div>
                <div class="text-[11px] font-semibold text-violet-600 dark:text-violet-400 mt-1 flex items-center gap-1.5">
                    <span>{{ $pendingCount }} Pending</span>
                    <span class="text-zinc-300 dark:text-zinc-700">•</span>
                    <span>{{ $waivedCount }} Indigent Exempted</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm space-y-4">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <!-- Timeframe selector -->
            <div class="flex items-center flex-wrap gap-1.5 p-1 bg-zinc-100 dark:bg-zinc-800/80 rounded-xl border border-zinc-200/60 dark:border-zinc-700/60">
                @foreach(['today' => 'Today', 'this_week' => 'This Week', 'this_month' => 'This Month', 'this_quarter' => 'Quarter', 'this_year' => 'This Year', 'all' => 'All-Time', 'custom' => 'Custom Range'] as $key => $label)
                    <button 
                        type="button" 
                        wire:click="$set('timeframe', '{{ $key }}')" 
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all @if($timeframe === $key) bg-white dark:bg-zinc-900 text-emerald-600 dark:text-emerald-400 shadow-sm border border-zinc-200/80 dark:border-zinc-700 @else text-zinc-600 dark:text-zinc-400 hover:text-zinc-950 dark:hover:text-white @endif"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <!-- Search box -->
            <div class="w-full lg:w-72">
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search payer, OR#, transaction code..." 
                        class="w-full pl-9 pr-3.5 py-2 text-xs font-medium rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/90 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                    />
                    <flux:icon name="magnifying-glass" class="size-4 absolute left-3 top-2.5 text-zinc-400" />
                </div>
            </div>
        </div>

        <!-- Custom Date Range Picker & Category/Status dropdowns -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 pt-3 border-t border-zinc-100 dark:border-zinc-800 text-xs">
            <div>
                <label class="block font-bold text-zinc-600 dark:text-zinc-400 mb-1">Start Date</label>
                <input 
                    type="date" 
                    wire:model.live="startDate" 
                    class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/90 px-3 py-1.5 text-xs text-zinc-900 dark:text-white"
                />
            </div>

            <div>
                <label class="block font-bold text-zinc-600 dark:text-zinc-400 mb-1">End Date</label>
                <input 
                    type="date" 
                    wire:model.live="endDate" 
                    class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/90 px-3 py-1.5 text-xs text-zinc-900 dark:text-white"
                />
            </div>

            <div>
                <label class="block font-bold text-zinc-600 dark:text-zinc-400 mb-1">Service Category</label>
                <select 
                    wire:model.live="serviceTypeFilter" 
                    class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/90 px-3 py-1.5 text-xs text-zinc-900 dark:text-white font-medium"
                >
                    <option value="">All Services & Rentals</option>
                    <option value="document">Document Clearances Only</option>
                    <option value="rental">Utility & Equipment Rentals Only</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-zinc-600 dark:text-zinc-400 mb-1">Payment Status</label>
                <select 
                    wire:model.live="paymentStatusFilter" 
                    class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/90 px-3 py-1.5 text-xs text-zinc-900 dark:text-white font-medium"
                >
                    <option value="">All Statuses</option>
                    <option value="paid">Paid Collections Only</option>
                    <option value="pending">Pending Payments</option>
                    <option value="waived">Waived / Free Exemption</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Revenue Breakdown by Service Item Ranking Table -->
    @if($itemBreakdown->isNotEmpty())
    <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
            <div>
                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Revenue Breakdown by Service Item</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Total collections and percentage share per document and rental offering</p>
            </div>
            <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-full">{{ $itemBreakdown->count() }} Active Revenue Sources</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($itemBreakdown->take(6) as $item)
                <div class="p-4 rounded-xl border border-zinc-100 dark:border-zinc-800/80 bg-zinc-50/50 dark:bg-zinc-800/30 flex flex-col justify-between space-y-2.5">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 rounded-lg @if($item['type'] === 'rental') bg-amber-500/10 text-amber-600 dark:text-amber-400 @else bg-sky-500/10 text-sky-600 dark:text-sky-400 @endif">
                                <flux:icon :name="$item['type'] === 'rental' ? 'building-office' : 'document-text'" class="size-4" />
                            </span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white line-clamp-1" title="{{ $item['name'] }}">{{ $item['name'] }}</span>
                        </div>
                        <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300">
                            {{ $item['percentage'] }}%
                        </span>
                    </div>

                    <div>
                        <div class="flex items-baseline justify-between">
                            <span class="text-lg font-extrabold text-zinc-900 dark:text-white">₱{{ number_format($item['total'], 2) }}</span>
                            <span class="text-[11px] font-semibold text-zinc-500">{{ $item['qty'] }} issued / booked</span>
                        </div>
                        <!-- Progress Bar -->
                        <div class="w-full bg-zinc-200 dark:bg-zinc-700 h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ min(100, $item['percentage']) }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Transactions & Official Receipts Ledger -->
    <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-zinc-100 dark:border-zinc-800">
            <div>
                <h3 class="text-base font-bold text-zinc-900 dark:text-white font-outfit">Transactions & Collection Ledger</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Complete itemized audit log of official fee receipts, payers, and payment channels</p>
            </div>
            <div class="text-xs font-semibold text-zinc-500">
                Showing {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} records
            </div>
        </div>

        @if($transactions->isEmpty())
            <div class="text-center py-12 text-zinc-400 dark:text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-xl border border-dashed border-zinc-200 dark:border-zinc-800 p-6">
                <flux:icon name="banknotes" class="size-12 text-zinc-300 dark:text-zinc-700 mx-auto mb-2" />
                <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">No transaction records found.</p>
                <p class="text-xs text-zinc-400 mt-1">Try adjusting your date range or filters, or record a new walk-in payment.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-zinc-700 dark:text-zinc-300 border-collapse">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-500 text-[10px] font-bold uppercase tracking-wider">
                            <th class="py-3 px-4">TXN Code & Date</th>
                            <th class="py-3 px-4">Payer Name</th>
                            <th class="py-3 px-4">Service Item</th>
                            <th class="py-3 px-4 text-center">Payment Method</th>
                            <th class="py-3 px-4 text-center">OR Number</th>
                            <th class="py-3 px-4 text-right">Amount (₱)</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 font-medium">
                        @foreach($transactions as $txn)
                            <tr class="odd:bg-zinc-50/40 hover:bg-emerald-50/30 dark:odd:bg-zinc-900/20 dark:hover:bg-emerald-950/10 transition">
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="font-bold text-zinc-900 dark:text-white font-mono text-[11px]">{{ $txn->transaction_code }}</span>
                                    <div class="text-[10px] text-zinc-400">{{ $txn->created_at->format('M d, Y h:i A') }}</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-zinc-900 dark:text-white">{{ $txn->payer_name }}</div>
                                    @if($txn->payer_address)
                                        <div class="text-[10px] text-zinc-400 truncate max-w-xs">{{ $txn->payer_address }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-1.5">
                                        <span class="p-1 rounded @if($txn->service_type === 'rental') bg-amber-500/10 text-amber-600 @else bg-sky-500/10 text-sky-600 @endif">
                                            <flux:icon :name="$txn->service_type === 'rental' ? 'building-office' : 'document-text'" class="size-3.5" />
                                        </span>
                                        <span class="font-bold text-zinc-900 dark:text-white">{{ $txn->item_name }}</span>
                                    </div>
                                    @if($txn->quantity > 1)
                                        <div class="text-[10px] text-zinc-400">Qty: {{ $txn->quantity }} @ ₱{{ number_format($txn->unit_price, 2) }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase @if($txn->payment_method === 'gcash') bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-300 @elseif($txn->payment_method === 'maya') bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300 @elseif($txn->payment_method === 'free_exemption') bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 @else bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200 @endif">
                                        {{ str_replace('_', ' ', $txn->payment_method) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @if($txn->official_receipt_number)
                                        <span class="font-mono text-[11px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                                            {{ $txn->official_receipt_number }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400 dark:text-zinc-600">&mdash;</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    @if($txn->payment_status === 'waived')
                                        <span class="font-extrabold text-emerald-600 dark:text-emerald-400">FREE</span>
                                    @else
                                        <span class="font-extrabold text-zinc-950 dark:text-white text-sm">₱{{ number_format($txn->amount_paid > 0 ? $txn->amount_paid : $txn->total_amount, 2) }}</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @if($txn->payment_status === 'paid')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800/40">
                                            PAID
                                        </span>
                                    @elseif($txn->payment_status === 'waived')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-700 border border-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700">
                                            WAIVED (FREE)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800/40">
                                            PENDING
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <button 
                                        type="button" 
                                        wire:click="viewReceipt({{ $txn->id }})" 
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-800 dark:text-zinc-200 transition cursor-pointer"
                                        title="View Official Barangay Receipt"
                                    >
                                        <flux:icon name="receipt-percent" class="size-3" />
                                        <span>Receipt</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    <!-- Modal 1: Record Direct / Walk-In Sale Modal -->
    <flux:modal name="direct-sale-modal" class="max-w-md" wire:model="showDirectSaleModal">
        <form wire:submit="saveDirectSale" class="space-y-5">
            <div>
                <flux:heading size="lg">{{ __('Record Walk-in Collection') }}</flux:heading>
                <flux:subheading>{{ __('Record over-the-counter clearance fee or rental payment at Barangay Hall.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Payer / Resident Name <span class="text-emerald-500">*</span></label>
                    <input 
                        type="text" 
                        wire:model="directPayerName" 
                        placeholder="e.g. Juan Dela Cruz" 
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 py-2 text-xs font-bold text-zinc-900 dark:text-white" 
                        required 
                    />
                    @error('directPayerName') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Payer Address (Optional)</label>
                    <input 
                        type="text" 
                        wire:model="directPayerAddress" 
                        placeholder="e.g. Purok 3, Barangay Sambog" 
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 py-2 text-xs text-zinc-900 dark:text-white" 
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Service Category</label>
                        <select 
                            wire:model.live="directServiceType" 
                            class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-xs font-bold text-zinc-900 dark:text-white"
                        >
                            <option value="document">Official Document</option>
                            <option value="rental">Utility & Rental</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Quantity</label>
                        <input 
                            type="number" 
                            min="1" 
                            wire:model.live="directQuantity" 
                            class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 py-2 text-xs font-bold text-zinc-900 dark:text-white" 
                            required 
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Select Service Item <span class="text-emerald-500">*</span></label>
                    <select 
                        wire:model.live="directItemName" 
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 py-2 text-xs font-bold text-zinc-900 dark:text-white"
                    >
                        @if($directServiceType === 'rental')
                            @foreach($availableRentalFees as $fee)
                                <option value="{{ $fee->name }}">{{ $fee->name }} (₱{{ number_format($fee->default_fee, 2) }})</option>
                            @endforeach
                        @else
                            @foreach($availableDocumentFees as $fee)
                                <option value="{{ $fee->name }}">{{ $fee->name }} (₱{{ number_format($fee->default_fee, 2) }})</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Unit Price (₱)</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            wire:model.live="directUnitPrice" 
                            class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 py-2 text-xs font-extrabold text-zinc-900 dark:text-white" 
                            required 
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Payment Method</label>
                        <select 
                            wire:model="directPaymentMethod" 
                            class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-xs font-bold text-zinc-900 dark:text-white"
                        >
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="maya">Maya</option>
                            <option value="free_exemption">Free Exemption / Indigent</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-1">Official Receipt (OR) Number</label>
                    <input 
                        type="text" 
                        wire:model="directOrNumber" 
                        placeholder="e.g. OR-2026-0045" 
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 py-2 text-xs font-mono text-zinc-900 dark:text-white" 
                    />
                </div>

                <!-- Summary Total banner -->
                <div class="p-3 bg-emerald-50 dark:bg-emerald-950/30 rounded-xl border border-emerald-200 dark:border-emerald-800/40 flex items-center justify-between">
                    <span class="text-xs font-bold text-emerald-900 dark:text-emerald-300">Total Collection Amount:</span>
                    <span class="text-base font-extrabold text-emerald-700 dark:text-emerald-400">₱{{ number_format($directUnitPrice * $directQuantity, 2) }}</span>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <flux:button variant="ghost" type="button" wire:click="$set('showDirectSaleModal', false)">{{ __('Cancel') }}</flux:button>
                <flux:button variant="primary" type="submit" class="bg-emerald-600 hover:bg-emerald-700 font-bold text-white">{{ __('Record Collection & OR') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Modal 2: Official Barangay Receipt Viewer & Print Modal -->
    <flux:modal name="receipt-modal" class="max-w-md" wire:model="showReceiptModal">
        @if($selectedReceipt)
            <div class="space-y-6">
                <!-- Printable Receipt Canvas -->
                <div id="printable-receipt" class="p-6 bg-white dark:bg-zinc-900 rounded-2xl border-2 border-dashed border-zinc-300 dark:border-zinc-700 font-outfit text-zinc-900 dark:text-zinc-100">
                    <!-- Barangay Header -->
                    <div class="text-center pb-4 border-b border-zinc-200 dark:border-zinc-700">
                        <div class="text-[10px] uppercase tracking-widest text-zinc-500 font-bold">Republic of the Philippines</div>
                        <div class="text-[10px] uppercase font-bold text-zinc-600 dark:text-zinc-400">Province of Bohol • Municipality of Corella</div>
                        <div class="text-base font-extrabold text-zinc-900 dark:text-white mt-1">BARANGAY SAMBOG</div>
                        <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400 mt-0.5 tracking-wider uppercase">OFFICIAL COLLECTION RECEIPT</div>
                    </div>

                    <!-- Receipt Details -->
                    <div class="py-4 space-y-3 text-xs">
                        <div class="flex justify-between">
                            <span class="text-zinc-500">Receipt OR #:</span>
                            <span class="font-mono font-bold text-zinc-900 dark:text-white">{{ $selectedReceipt->official_receipt_number ?? $selectedReceipt->transaction_code }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-500">Date & Time:</span>
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedReceipt->created_at->format('F d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-500">Received From:</span>
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $selectedReceipt->payer_name }}</span>
                        </div>
                        @if($selectedReceipt->payer_address)
                            <div class="flex justify-between">
                                <span class="text-zinc-500">Address:</span>
                                <span class="font-medium text-zinc-700 dark:text-zinc-300 text-right">{{ $selectedReceipt->payer_address }}</span>
                            </div>
                        @endif

                        <div class="pt-2 border-t border-zinc-100 dark:border-zinc-800">
                            <div class="flex justify-between font-bold py-1">
                                <span>Particulars / Service:</span>
                                <span class="text-right">{{ $selectedReceipt->item_name }}</span>
                            </div>
                            @if($selectedReceipt->quantity > 1)
                                <div class="flex justify-between text-zinc-500 text-[11px]">
                                    <span>Quantity x Rate:</span>
                                    <span>{{ $selectedReceipt->quantity }} x ₱{{ number_format($selectedReceipt->unit_price, 2) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="pt-3 border-t-2 border-zinc-900 dark:border-zinc-100 flex justify-between items-baseline">
                            <span class="text-sm font-extrabold">TOTAL AMOUNT PAID:</span>
                            <span class="text-lg font-black text-emerald-600 dark:text-emerald-400">₱{{ number_format($selectedReceipt->amount_paid > 0 ? $selectedReceipt->amount_paid : $selectedReceipt->total_amount, 2) }}</span>
                        </div>

                        <div class="flex justify-between text-[11px] text-zinc-500 pt-1">
                            <span>Payment Method:</span>
                            <span class="uppercase font-bold text-zinc-800 dark:text-zinc-200">{{ str_replace('_', ' ', $selectedReceipt->payment_method) }}</span>
                        </div>
                    </div>

                    <!-- Signatory -->
                    <div class="pt-6 border-t border-zinc-200 dark:border-zinc-700 text-center">
                        <div class="w-48 mx-auto border-b border-zinc-400 dark:border-zinc-500 pb-1 font-bold text-xs">
                            {{ $selectedReceipt->processor?->name ?? 'Barangay Treasurer / Collector' }}
                        </div>
                        <div class="text-[10px] text-zinc-400 uppercase tracking-wider mt-1">Collecting Officer / Admin</div>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <button 
                        type="button" 
                        onclick="window.print()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition cursor-pointer"
                    >
                        <flux:icon name="printer" class="size-4" />
                        <span>Print Receipt</span>
                    </button>

                    <flux:button variant="ghost" type="button" wire:click="$set('showReceiptModal', false)">{{ __('Close') }}</flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

    <!-- Modal 3: Pricing & Fee Configuration Modal -->
    <flux:modal name="pricing-modal" class="max-w-xl" wire:model="showPricingModal">
        <form wire:submit="savePricing" class="space-y-5">
            <div>
                <flux:heading size="lg">{{ __('Configure Standard Service Fees') }}</flux:heading>
                <flux:subheading>{{ __('Adjust official fee schedule for Barangay Sambog documents, clearances, and facility rentals.') }}</flux:subheading>
            </div>

            <div class="max-h-[60vh] overflow-y-auto space-y-3 pr-2">
                @foreach($allFees as $fee)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-800/40 rounded-xl border border-zinc-200/80 dark:border-zinc-700/60 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2.5">
                            <span class="p-2 rounded-lg @if($fee->category === 'rental') bg-amber-500/10 text-amber-600 @else bg-emerald-500/10 text-emerald-600 @endif">
                                <flux:icon :name="$fee->category === 'rental' ? 'building-office' : 'document-text'" class="size-4" />
                            </span>
                            <div>
                                <div class="text-xs font-bold text-zinc-900 dark:text-white">{{ $fee->name }}</div>
                                <div class="text-[10px] text-zinc-400">{{ $fee->fee_unit }} • {{ $fee->code }}</div>
                            </div>
                        </div>

                        <div class="w-32 flex items-center gap-1.5 shrink-0">
                            <span class="text-xs font-bold text-zinc-500">₱</span>
                            <input 
                                type="number" 
                                step="0.01" 
                                min="0" 
                                wire:model="editingFees.{{ $fee->id }}" 
                                class="w-full rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 px-2 py-1 text-xs font-bold text-zinc-900 dark:text-white text-right"
                            />
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                <flux:button variant="ghost" type="button" wire:click="$set('showPricingModal', false)">{{ __('Cancel') }}</flux:button>
                <flux:button variant="primary" type="submit" class="bg-emerald-600 hover:bg-emerald-700 font-bold text-white">{{ __('Save Fee Changes') }}</flux:button>
            </div>
        </form>
    </flux:modal>

</div>
