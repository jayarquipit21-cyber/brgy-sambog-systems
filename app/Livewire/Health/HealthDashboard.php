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

    // Health Card Modal state
    public bool $showHealthCardModal = false;

    public ?Resident $selectedResident = null;

    public string $cardActiveTab = 'health'; // 'health', 'profile', 'household'

    public function openResidentHealthCard(int $id): void
    {
        $this->selectedResident = Resident::with(['household', 'user'])->find($id);
        $this->cardActiveTab = 'health';
        $this->showHealthCardModal = true;
    }

    public function closeResidentHealthCard(): void
    {
        $this->showHealthCardModal = false;
        $this->selectedResident = null;
    }

    public function getBmiProperty(): ?array
    {
        if (! $this->selectedResident) {
            return null;
        }

        $h = floatval($this->selectedResident->height);
        $w = floatval($this->selectedResident->weight);

        if ($h <= 0 || $w <= 0) {
            return null;
        }

        $hm = $h / 100;
        $bmi = round($w / ($hm * $hm), 1);

        $category = match (true) {
            $bmi < 18.5 => ['label' => 'Underweight', 'color' => 'amber'],
            $bmi < 25.0 => ['label' => 'Normal Weight', 'color' => 'emerald'],
            $bmi < 30.0 => ['label' => 'Overweight', 'color' => 'orange'],
            default => ['label' => 'Obese', 'color' => 'rose'],
        };

        return [
            'value' => $bmi,
            'label' => $category['label'],
            'color' => $category['color'],
        ];
    }

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
        'philhealth_id',
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
        $query = Resident::approved()->select($this->healthRelatedColumns)
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc');

        if ($this->search) {
            $term = trim($this->search);
            $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
            $concatFirstLast = $driver === 'sqlite' ? "(first_name || ' ' || last_name)" : "CONCAT(first_name, ' ', last_name)";
            $concatLastFirst = $driver === 'sqlite' ? "(last_name || ', ' || first_name)" : "CONCAT(last_name, ', ', first_name)";

            $query->where(function ($q) use ($term, $concatFirstLast, $concatLastFirst) {
                $q->where('first_name', 'like', '%'.$term.'%')
                    ->orWhere('last_name', 'like', '%'.$term.'%')
                    ->orWhere('middle_name', 'like', '%'.$term.'%')
                    ->orWhereRaw("{$concatFirstLast} LIKE ?", ['%'.$term.'%'])
                    ->orWhereRaw("{$concatLastFirst} LIKE ?", ['%'.$term.'%'])
                    ->orWhere('health_condition', 'like', '%'.$term.'%')
                    ->orWhere('blood_type', 'like', '%'.$term.'%')
                    ->orWhere('vulnerable_sector', 'like', '%'.$term.'%')
                    ->orWhere('nutritional_classification', 'like', '%'.$term.'%')
                    ->orWhere('philhealth_id', 'like', '%'.$term.'%');

                if (is_numeric($term) && (int) $term <= 125) {
                    $q->orWhere('age', (int) $term);
                }
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
