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

    public string $nameLetter = '';

    public string $sexFilter = '';

    public string $voterFilter = '';

    public string $ageGroup = '';

    public string $sortField = 'first_name';

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

    public function updatingNameLetter(): void
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

    public function updatingAgeGroup(): void
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

    public function render()
    {
        $query = Resident::approved()->with('household');

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
                    ->orWhere('mobile_number', 'like', '%'.$this->search.'%')
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

        if ($this->nameLetter) {
            $query->where('first_name', 'like', $this->nameLetter.'%');
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

        if ($this->ageGroup) {
            match ($this->ageGroup) {
                'infant' => $query->whereBetween('age', [0, 5]),
                'child' => $query->whereBetween('age', [6, 12]),
                'teen' => $query->whereBetween('age', [13, 17]),
                'young_adult' => $query->whereBetween('age', [18, 30]),
                'adult' => $query->whereBetween('age', [31, 59]),
                'senior' => $query->where('age', '>=', 60),
                default => null,
            };
        }

        $stats = [
            'total' => Resident::approved()->count(),
            'households' => Household::count(),
            'voters' => Resident::approved()->where(function ($q) {
                $q->where('registered_national_voter', 'Y')->orWhere('resident_voter', 'Y');
            })->count(),
            'fully_vaccinated' => Resident::approved()->where('fully_vaccinated', 'Y')->count(),
        ];

        return view('livewire.admin.rbi-data-table', [
            'residents' => $query->paginate(25),
            'stats' => $stats,
        ]);
    }
}
