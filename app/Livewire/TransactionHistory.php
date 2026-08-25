<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionHistory extends Component
{
    use WithPagination;

    public string $serviceType = ''; // 'document' or 'rental'

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $isAdmin = auth()->user()?->isAdmin();

        $query = Transaction::with(['user', 'processor'])
            ->latest('paid_at')
            ->latest('id');

        // Filter by service type
        if ($this->serviceType) {
            $query->where('service_type', $this->serviceType);
        }

        // If not admin, scope to current user's transactions only
        if (! $isAdmin) {
            $query->where('user_id', auth()->id());
        }

        // Search
        if ($this->search) {
            $s = '%' . $this->search . '%';
            $query->where(function ($q) use ($s, $isAdmin) {
                $q->where('item_name', 'like', $s)
                    ->orWhere('transaction_code', 'like', $s)
                    ->orWhere('official_receipt_number', 'like', $s);

                if ($isAdmin) {
                    $q->orWhere('payer_name', 'like', $s);
                }
            });
        }

        $transactions = $query->paginate(10);

        return view('livewire.transaction-history', [
            'transactions' => $transactions,
            'isAdmin' => $isAdmin,
        ]);
    }
}
