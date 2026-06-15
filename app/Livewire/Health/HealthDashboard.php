<?php

namespace App\Livewire\Health;

use App\Models\Resident;
use Livewire\Component;
use Livewire\WithPagination;

class HealthDashboard extends Component
{
    use WithPagination;

    public string $search = '';

    public string $ageGroupFilter = '';

    public string $healthFilter = '';

    // Selected columns that are related ONLY to health concerns, preventing exposure of sensitive info
    protected array $healthRelatedColumns = [
        'id',
        'first_name',
        'last_name',
        'age',
        'sex',
        'age_classification',
        'health_condition',
        'unvaccinated',
        'partially_vaccinated',
        'fully_vaccinated',
        'covid_dose_1_date',
        'covid_dose_2_date',
        'covid_brand',
        'has_booster',
        'booster_date',
        'booster_brand',
        'nutritional_classification',
        'vulnerable_sector',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingAgeGroupFilter(): void
    {
        $this->resetPage();
    }

    public function updatingHealthFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        // Enforce column selection strictly in the database query layer!
        $query = Resident::approved()->select($this->healthRelatedColumns)
            ->whereNotNull('health_condition')
            ->where('health_condition', '!=', '')
            ->orderBy('age', 'asc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%'.$this->search.'%')
                    ->orWhere('last_name', 'like', '%'.$this->search.'%')
                    ->orWhere('health_condition', 'like', '%'.$this->search.'%');
            });
        }

        // Age-Dynamic classification filters
        if ($this->ageGroupFilter) {
            if ($this->ageGroupFilter === 'pediatric') {
                $query->where('age', '<=', 12);
            } elseif ($this->ageGroupFilter === 'youth') {
                $query->whereBetween('age', [13, 24]);
            } elseif ($this->ageGroupFilter === 'adult') {
                $query->whereBetween('age', [25, 59]);
            } elseif ($this->ageGroupFilter === 'senior') {
                $query->where('age', '>=', 60);
            }
        }

        if ($this->healthFilter) {
            $query->where('health_condition', 'like', '%'.$this->healthFilter.'%');
        }

        // Generate age-dynamic aggregates for widgets
        $stats = [
            'total_cases' => Resident::approved()->whereNotNull('health_condition')->where('health_condition', '!=', '')->count(),
            'pediatric_cases' => Resident::approved()->where('age', '<=', 12)->whereNotNull('health_condition')->where('health_condition', '!=', '')->count(),
            'youth_cases' => Resident::approved()->whereBetween('age', [13, 24])->whereNotNull('health_condition')->where('health_condition', '!=', '')->count(),
            'adult_cases' => Resident::approved()->whereBetween('age', [25, 59])->whereNotNull('health_condition')->where('health_condition', '!=', '')->count(),
            'senior_cases' => Resident::approved()->where('age', '>=', 60)->whereNotNull('health_condition')->where('health_condition', '!=', '')->count(),
            'fully_vaccinated' => Resident::approved()->where('fully_vaccinated', 'Y')->count(),
        ];

        return view('livewire.health.health-dashboard', [
            'healthRecords' => $query->paginate(10),
            'stats' => $stats,
        ]);
    }
}
