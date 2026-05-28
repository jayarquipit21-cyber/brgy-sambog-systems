<?php

namespace App\Livewire\Admin;

use App\Models\Resident;
use App\Models\Household;
use Livewire\Component;
use Livewire\WithPagination;

class ManageRbi extends Component
{
    use WithPagination;

    public string $search = '';
    public string $purokFilter = '';
    public string $voterFilter = '';

    // Reset pagination when search or filters change
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPurokFilter(): void
    {
        $this->resetPage();
    }

    public function updatingVoterFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Resident::with('household')
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email_address', 'like', '%' . $this->search . '%')
                  ->orWhereHas('household', function ($hq) {
                      $hq->where('household_no', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->purokFilter) {
            $query->whereHas('household', function ($hq) {
                $hq->where('purok_no', $this->purokFilter);
            });
        }

        if ($this->voterFilter) {
            if ($this->voterFilter === 'registered') {
                $query->where(function ($q) {
                    $q->where('registered_national_voter', 'Y')
                      ->orWhere('registered_sk_voter', 'Y')
                      ->orWhere('resident_voter', 'Y');
                });
            } elseif ($this->voterFilter === 'unregistered') {
                $query->where(function ($q) {
                    $q->where('registered_national_voter', '!=', 'Y')
                      ->where('registered_sk_voter', '!=', 'Y')
                      ->where('resident_voter', '!=', 'Y');
                });
            }
        }

        // Calculate simple stats for widgets
        $stats = [
            'total' => Resident::count(),
            'households' => Household::count(),
            'voters' => Resident::where('registered_national_voter', 'Y')->orWhere('resident_voter', 'Y')->count(),
            'seniors' => Resident::where('age', '>=', 60)->count(),
        ];

        return view('livewire.admin.manage-rbi', [
            'residents' => $query->paginate(15),
            'stats' => $stats,
        ]);
    }
}
