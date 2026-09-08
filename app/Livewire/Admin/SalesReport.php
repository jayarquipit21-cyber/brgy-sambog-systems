<?php

namespace App\Livewire\Admin;

use App\Models\ServiceFee;
use App\Models\Transaction;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class SalesReport extends Component
{
    use WithPagination;

    // Filters
    public string $search = '';

    public string $timeframe = 'this_month'; // 'today', 'this_week', 'this_month', 'this_quarter', 'this_year', 'all', 'custom'

    public ?string $startDate = null;

    public ?string $endDate = null;

    public string $serviceTypeFilter = ''; // '', 'document', 'rental'

    public string $paymentStatusFilter = 'paid'; // '', 'paid', 'pending', 'waived'

    public string $paymentMethodFilter = ''; // '', 'cash', 'gcash', 'maya', 'free_exemption'

    // Walk-in / Direct Sale Modal state
    public bool $showDirectSaleModal = false;

    public string $directPayerName = '';

    public string $directPayerAddress = '';

    public string $directServiceType = 'document';

    public string $directItemName = '';

    public int $directQuantity = 1;

    public float $directUnitPrice = 50.00;

    public string $directPaymentMethod = 'cash';

    public string $directOrNumber = '';

    public string $directNotes = '';

    // Receipt View Modal state
    public bool $showReceiptModal = false;

    public ?Transaction $selectedReceipt = null;

    // Pricing Editor Modal state
    public bool $showPricingModal = false;

    public array $editingFees = [];

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();
    }

    public function updatedTimeframe(string $value): void
    {
        $now = Carbon::now();
        switch ($value) {
            case 'today':
                $this->startDate = $now->toDateString();
                $this->endDate = $now->toDateString();
                break;
            case 'this_week':
                $this->startDate = $now->copy()->startOfWeek()->toDateString();
                $this->endDate = $now->copy()->endOfWeek()->toDateString();
                break;
            case 'this_month':
                $this->startDate = $now->copy()->startOfMonth()->toDateString();
                $this->endDate = $now->copy()->endOfMonth()->toDateString();
                break;
            case 'this_quarter':
                $this->startDate = $now->copy()->firstOfQuarter()->toDateString();
                $this->endDate = $now->copy()->lastOfQuarter()->toDateString();
                break;
            case 'this_year':
                $this->startDate = $now->copy()->startOfYear()->toDateString();
                $this->endDate = $now->copy()->endOfYear()->toDateString();
                break;
            case 'all':
                $this->startDate = null;
                $this->endDate = null;
                break;
            case 'custom':
                // retain custom inputs
                break;
        }
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedServiceTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatedPaymentStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedPaymentMethodFilter(): void
    {
        $this->resetPage();
    }

    public function openDirectSaleModal(): void
    {
        $this->directPayerName = '';
        $this->directPayerAddress = 'Barangay Sambog, Corella, Bohol';
        $this->directServiceType = 'document';
        $this->directItemName = 'Barangay Clearance';
        $this->directQuantity = 1;
        $this->directUnitPrice = ServiceFee::getFeeByName('Barangay Clearance') ?: 50.00;
        $this->directPaymentMethod = 'cash';
        $this->directOrNumber = sprintf('OR-%s-%04d', now()->format('Y'), rand(100, 999));
        $this->directNotes = 'Over-the-counter walk-in request';
        $this->showDirectSaleModal = true;
    }

    public function updatedDirectItemName(string $name): void
    {
        $fee = ServiceFee::getFeeByName($name);
        $this->directUnitPrice = $fee;
    }

    public function updatedDirectServiceType(string $type): void
    {
        $firstItem = ServiceFee::where('category', $type)->where('is_active', true)->first();
        if ($firstItem) {
            $this->directItemName = $firstItem->name;
            $this->directUnitPrice = (float) $firstItem->default_fee;
        }
    }

    public function saveDirectSale(): void
    {
        $this->validate([
            'directPayerName' => 'required|string|min:2|max:100',
            'directServiceType' => 'required|in:document,rental,other',
            'directItemName' => 'required|string',
            'directQuantity' => 'required|integer|min:1|max:1000',
            'directUnitPrice' => 'required|numeric|min:0',
            'directPaymentMethod' => 'required|string',
            'directOrNumber' => 'nullable|string|max:50',
            'directNotes' => 'nullable|string|max:500',
        ]);

        $total = $this->directUnitPrice * $this->directQuantity;
        $isFree = ($this->directPaymentMethod === 'free_exemption' || $total == 0);

        Transaction::create([
            'payer_name' => $this->directPayerName,
            'payer_address' => $this->directPayerAddress,
            'service_type' => $this->directServiceType,
            'item_name' => $this->directItemName,
            'quantity' => $this->directQuantity,
            'unit_price' => $this->directUnitPrice,
            'total_amount' => $total,
            'amount_paid' => $isFree ? 0.00 : $total,
            'payment_status' => $isFree ? 'waived' : 'paid',
            'payment_method' => $this->directPaymentMethod,
            'official_receipt_number' => $this->directOrNumber ?: null,
            'processed_by' => auth()->id(),
            'notes' => $this->directNotes ?: 'Direct walk-in payment recorded by admin',
            'paid_at' => now(),
        ]);

        $this->showDirectSaleModal = false;
        Flux::toast(variant: 'success', text: __('Transaction & official receipt recorded in Sales Report!'));
    }

    public function viewReceipt(int $id): void
    {
        $this->selectedReceipt = Transaction::with(['user', 'processor'])->findOrFail($id);
        $this->showReceiptModal = true;
    }

    public function openPricingModal(): void
    {
        $fees = ServiceFee::orderBy('category')->orderBy('name')->get();
        $this->editingFees = [];
        foreach ($fees as $fee) {
            $this->editingFees[$fee->id] = (float) $fee->default_fee;
        }
        $this->showPricingModal = true;
    }

    public function savePricing(): void
    {
        foreach ($this->editingFees as $id => $feeAmount) {
            ServiceFee::where('id', $id)->update(['default_fee' => max(0, floatval($feeAmount))]);
        }
        $this->showPricingModal = false;
        Flux::toast(variant: 'success', text: __('Service prices & fee rates updated successfully!'));
    }

    public function render()
    {
        // 1. Base Query with filters
        $query = Transaction::with(['user', 'processor'])->latest('paid_at')->latest('id');

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }



        if ($this->serviceTypeFilter) {
            $query->where('service_type', $this->serviceTypeFilter);
        }

        if ($this->paymentStatusFilter) {
            $query->where('payment_status', $this->paymentStatusFilter);
        }

        if ($this->paymentMethodFilter) {
            $query->where('payment_method', $this->paymentMethodFilter);
        }

        if ($this->search) {
            $s = '%'.$this->search.'%';
            $query->where(function ($q) use ($s) {
                $q->where('payer_name', 'like', $s)
                    ->orWhere('item_name', 'like', $s)
                    ->orWhere('transaction_code', 'like', $s)
                    ->orWhere('official_receipt_number', 'like', $s)
                    ->orWhere('payer_address', 'like', $s)
                    ->orWhere('notes', 'like', $s);
            });
        }

        // 2. Metrics & KPI Calculations for active filter scope (independent of table status filter)
        $metricsQuery = Transaction::query();

        if ($this->startDate) {
            $metricsQuery->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $metricsQuery->whereDate('created_at', '<=', $this->endDate);
        }

        if ($this->serviceTypeFilter) {
            $metricsQuery->where('service_type', $this->serviceTypeFilter);
        }

        if ($this->paymentMethodFilter) {
            $metricsQuery->where('payment_method', $this->paymentMethodFilter);
        }

        if ($this->search) {
            $s = '%'.$this->search.'%';
            $metricsQuery->where(function ($q) use ($s) {
                $q->where('payer_name', 'like', $s)
                    ->orWhere('item_name', 'like', $s)
                    ->orWhere('transaction_code', 'like', $s)
                    ->orWhere('official_receipt_number', 'like', $s);
            });
        }

        $allMatching = $metricsQuery->get();

        $totalGrossRevenue = $allMatching->where('payment_status', 'paid')->sum('amount_paid');
        $documentRevenue = $allMatching->where('payment_status', 'paid')->where('service_type', 'document')->sum('amount_paid');
        $rentalRevenue = $allMatching->where('payment_status', 'paid')->where('service_type', 'rental')->sum('amount_paid');
        $paidCount = $allMatching->where('payment_status', 'paid')->count();
        $pendingCount = $allMatching->where('payment_status', 'pending')->count();
        $pendingAmount = $allMatching->where('payment_status', 'pending')->sum('total_amount');
        $waivedCount = $allMatching->where('payment_status', 'waived')->count();

        // 3. Breakdown by item ranking
        $itemBreakdown = $allMatching->where('payment_status', 'paid')
            ->groupBy('item_name')
            ->map(function ($items, $itemName) use ($totalGrossRevenue) {
                $itemTotal = $items->sum('amount_paid');
                $itemQty = $items->sum('quantity');
                $type = $items->first()->service_type ?? 'document';
                $pct = $totalGrossRevenue > 0 ? ($itemTotal / $totalGrossRevenue) * 100 : 0;

                return [
                    'name' => $itemName,
                    'type' => $type,
                    'qty' => $itemQty,
                    'total' => $itemTotal,
                    'percentage' => round($pct, 1),
                ];
            })
            ->sortByDesc('total')
            ->values();

        // 4. Paginated Transactions
        $transactions = $query->paginate(15);

        // 5. Available Service Fees for direct sale modal
        $availableDocumentFees = ServiceFee::where('category', 'document')->where('is_active', true)->get();
        $availableRentalFees = ServiceFee::where('category', 'rental')->where('is_active', true)->get();
        $allFees = ServiceFee::orderBy('category')->orderBy('name')->get();

        return view('livewire.admin.sales-report', [
            'transactions' => $transactions,
            'totalGrossRevenue' => $totalGrossRevenue,
            'documentRevenue' => $documentRevenue,
            'rentalRevenue' => $rentalRevenue,
            'paidCount' => $paidCount,
            'pendingCount' => $pendingCount,
            'pendingAmount' => $pendingAmount,
            'waivedCount' => $waivedCount,
            'itemBreakdown' => $itemBreakdown,
            'availableDocumentFees' => $availableDocumentFees,
            'availableRentalFees' => $availableRentalFees,
            'allFees' => $allFees,
        ]);
    }
}
