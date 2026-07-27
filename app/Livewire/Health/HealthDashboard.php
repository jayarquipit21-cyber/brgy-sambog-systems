<?php

namespace App\Livewire\Health;

use App\Models\Resident;
use Livewire\Component;
use Livewire\WithPagination;

class HealthDashboard extends Component
{
    use WithPagination;

    public string $search = '';

    public string $nameLetter = '';

    public string $ageGroupFilter = '';

    public string $healthFilter = '';

    // Selected columns related to health and medical history
    protected array $healthRelatedColumns = [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'extension',
        'age',
        'sex',
        'blood_type',
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
        'has_philhealth',
        'philhealth_no',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingNameLetter(): void
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
        $query = Resident::approved()->select($this->healthRelatedColumns)
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%'.$this->search.'%')
                    ->orWhere('last_name', 'like', '%'.$this->search.'%')
                    ->orWhere('middle_name', 'like', '%'.$this->search.'%')
                    ->orWhere('health_condition', 'like', '%'.$this->search.'%')
                    ->orWhere('blood_type', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->nameLetter) {
            $query->where('first_name', 'like', $this->nameLetter.'%');
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
            } else {
                $query->where('health_condition', 'like', '%'.$this->healthFilter.'%');
            }
        }

        // Generate age-dynamic aggregates for widgets
        $stats = [
            'total_cases' => Resident::approved()->whereNotNull('health_condition')->where('health_condition', '!=', '')->where('health_condition', '!=', 'None')->count(),
            'pediatric_cases' => Resident::approved()->where('age', '<=', 12)->whereNotNull('health_condition')->where('health_condition', '!=', '')->where('health_condition', '!=', 'None')->count(),
            'youth_cases' => Resident::approved()->whereBetween('age', [13, 24])->whereNotNull('health_condition')->where('health_condition', '!=', '')->where('health_condition', '!=', 'None')->count(),
            'adult_cases' => Resident::approved()->whereBetween('age', [25, 59])->whereNotNull('health_condition')->where('health_condition', '!=', '')->where('health_condition', '!=', 'None')->count(),
            'senior_cases' => Resident::approved()->where('age', '>=', 60)->whereNotNull('health_condition')->where('health_condition', '!=', '')->where('health_condition', '!=', 'None')->count(),
            'fully_vaccinated' => Resident::approved()->where('fully_vaccinated', 'Y')->count(),
        ];

        return view('livewire.health.health-dashboard', [
            'healthRecords' => $query->paginate(25),
            'stats' => $stats,
        ]);
    }
}
