<?php

namespace App\Livewire\Admin;

use App\Models\Household;
use App\Models\Resident;
use Livewire\Component;
use Livewire\WithPagination;

class RbiDataTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $purokFilter = '';

    public string $sexFilter = '';

    public string $voterFilter = '';

    public string $vaccineFilter = '';

    public string $healthFilter = '';

    public string $sortField = 'last_name';

    public string $sortDirection = 'asc';

    // Reset pagination when filter/search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPurokFilter(): void
    {
        $this->resetPage();
    }

    public function updatingSexFilter(): void
    {
        $this->resetPage();
    }

    public function updatingVoterFilter(): void
    {
        $this->resetPage();
    }

    public function updatingVaccineFilter(): void
    {
        $this->resetPage();
    }

    public function updatingSortField(): void
    {
        $this->resetPage();
    }

    public function updatingSortDirection(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingHealthFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Resident::with('household');

        if (in_array($this->sortField, ['household_no', 'purok_no'])) {
            $query = $query->leftJoin('households', 'residents.household_id', '=', 'households.id')
                ->select('residents.*')
                ->orderBy('households.'.$this->sortField, $this->sortDirection);
        } else {
            $query = $query->orderBy($this->sortField ?: 'last_name', $this->sortDirection)
                ->orderBy('first_name', 'asc');
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%'.$this->search.'%')
                    ->orWhere('last_name', 'like', '%'.$this->search.'%')
                    ->orWhere('middle_name', 'like', '%'.$this->search.'%')
                    ->orWhere('email_address', 'like', '%'.$this->search.'%')
                    ->orWhere('occupation', 'like', '%'.$this->search.'%')
                    ->orWhereHas('household', function ($hq) {
                        $hq->where('household_no', 'like', '%'.$this->search.'%')
                            ->orWhere('address', 'like', '%'.$this->search.'%');
                    });
            });
        }

        if ($this->purokFilter) {
            $query->whereHas('household', function ($hq) {
                $hq->where('purok_no', $this->purokFilter);
            });
        }

        if ($this->sexFilter) {
            $query->where('sex', $this->sexFilter);
        }

        if ($this->voterFilter) {
            if ($this->voterFilter === 'national') {
                $query->where('registered_national_voter', 'Y');
            } elseif ($this->voterFilter === 'sk') {
                $query->where('registered_sk_voter', 'Y');
            } elseif ($this->voterFilter === 'resident') {
                $query->where('resident_voter', 'Y');
            } elseif ($this->voterFilter === 'unregistered') {
                $query->where(function ($q) {
                    $q->where('registered_national_voter', '!=', 'Y')
                        ->where('registered_sk_voter', '!=', 'Y')
                        ->where('resident_voter', '!=', 'Y');
                });
            }
        }

        if ($this->vaccineFilter) {
            if ($this->vaccineFilter === 'fully') {
                $query->where('fully_vaccinated', 'Y');
            } elseif ($this->vaccineFilter === 'partially') {
                $query->where('partially_vaccinated', 'Y');
            } elseif ($this->vaccineFilter === 'unvaccinated') {
                $query->where('unvaccinated', 'Y');
            }
        }

        if ($this->healthFilter) {
            if ($this->healthFilter === 'has_condition') {
                $query->whereNotNull('health_condition')
                    ->where('health_condition', '!=', '')
                    ->where('health_condition', '!=', 'None');
            } elseif ($this->healthFilter === 'none') {
                $query->where(function ($q) {
                    $q->whereNull('health_condition')
                        ->orWhere('health_condition', '')
                        ->orWhere('health_condition', 'None');
                });
            }
        }

        $stats = [
            'total' => Resident::count(),
            'households' => Household::count(),
            'voters' => Resident::where('registered_national_voter', 'Y')->orWhere('resident_voter', 'Y')->count(),
            'fully_vaccinated' => Resident::where('fully_vaccinated', 'Y')->count(),
        ];

        return view('livewire.admin.rbi-data-table', [
            'residents' => $query->paginate(25),
            'stats' => $stats,
        ]);
    }
}
