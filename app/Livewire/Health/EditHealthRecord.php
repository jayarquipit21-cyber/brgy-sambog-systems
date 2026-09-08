<?php

namespace App\Livewire\Health;

use App\Models\Resident;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class EditHealthRecord extends Component
{
    use WithPagination;

    // ─── Search / Filter state ───────────────────────────────────────────────
    public string $search = '';
    public string $ageGroupFilter = '';
    public string $healthFilter = '';

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

    // ─── Modal state ─────────────────────────────────────────────────────────
    public bool $showEditModal = false;
    public ?int $editingId = null;

    // ─── Editable health fields ───────────────────────────────────────────────
    public string $health_condition       = '';
    public string $nutritional_classification = '';
    public string $vulnerable_sector      = '';
    public string $blood_type             = '';
    public string $height                 = '';
    public string $weight                 = '';

    // Vaccination
    public string $unvaccinated           = '';
    public string $partially_vaccinated   = '';
    public string $fully_vaccinated       = '';
    public string $covid_dose_1_date      = '';
    public string $covid_dose_2_date      = '';
    public string $covid_brand            = '';
    public string $has_booster            = '';
    public string $booster_date           = '';
    public string $booster_brand          = '';

    // PhilHealth
    public string $has_philhealth         = '';
    public string $philhealth_id          = '';
    public string $philhealth_membership_type = '';

    // ─── Selected columns for the table list ─────────────────────────────────
    protected array $listColumns = [
        'id', 'first_name', 'middle_name', 'last_name', 'extension',
        'age', 'sex', 'blood_type', 'health_condition',
        'nutritional_classification', 'vulnerable_sector',
        'unvaccinated', 'partially_vaccinated', 'fully_vaccinated',
        'has_philhealth',
    ];

    protected function rules(): array
    {
        return [
            'health_condition'         => 'nullable|string|max:500',
            'nutritional_classification' => 'nullable|string|max:255',
            'vulnerable_sector'        => 'nullable|string|max:255',
            'blood_type'               => 'nullable|string|max:10',
            'height'                   => 'nullable|string|max:20',
            'weight'                   => 'nullable|string|max:20',
            'unvaccinated'             => 'nullable|string|max:1',
            'partially_vaccinated'     => 'nullable|string|max:1',
            'fully_vaccinated'         => 'nullable|string|max:1',
            'covid_dose_1_date'        => 'nullable|string|max:50',
            'covid_dose_2_date'        => 'nullable|string|max:50',
            'covid_brand'              => 'nullable|string|max:100',
            'has_booster'              => 'nullable|string|max:1',
            'booster_date'             => 'nullable|string|max:50',
            'booster_brand'            => 'nullable|string|max:100',
            'has_philhealth'           => 'nullable|string|max:1',
            'philhealth_id'            => 'nullable|string|max:50',
            'philhealth_membership_type' => 'nullable|string|max:100',
        ];
    }

    /** Open the edit modal and populate fields from the selected resident. */
    public function openEdit(int $id): void
    {
        $resident = Resident::findOrFail($id);
        $this->editingId = $id;

        $this->health_condition            = $resident->health_condition ?? '';
        $this->nutritional_classification  = $resident->nutritional_classification ?? '';
        $this->vulnerable_sector           = $resident->vulnerable_sector ?? '';
        $this->blood_type                  = $resident->blood_type ?? '';
        $this->height                      = $resident->height ?? '';
        $this->weight                      = $resident->weight ?? '';
        $this->unvaccinated                = $resident->unvaccinated ?? '';
        $this->partially_vaccinated        = $resident->partially_vaccinated ?? '';
        $this->fully_vaccinated            = $resident->fully_vaccinated ?? '';
        $this->covid_dose_1_date           = $resident->covid_dose_1_date ?? '';
        $this->covid_dose_2_date           = $resident->covid_dose_2_date ?? '';
        $this->covid_brand                 = $resident->covid_brand ?? '';
        $this->has_booster                 = $resident->has_booster ?? '';
        $this->booster_date                = $resident->booster_date ?? '';
        $this->booster_brand               = $resident->booster_brand ?? '';
        $this->has_philhealth              = $resident->has_philhealth ?? '';
        $this->philhealth_id               = $resident->philhealth_id ?? '';
        $this->philhealth_membership_type  = $resident->philhealth_membership_type ?? '';

        $this->showEditModal = true;
    }

    /** Save the edited health record. */
    public function save(): void
    {
        $this->validate();

        // Enforce vaccine mutual exclusivity
        if ($this->fully_vaccinated === 'Y') {
            $this->partially_vaccinated = 'N';
            $this->unvaccinated         = 'N';
        } elseif ($this->partially_vaccinated === 'Y') {
            $this->fully_vaccinated = 'N';
            $this->unvaccinated     = 'N';
        } else {
            $this->unvaccinated        = 'Y';
            $this->fully_vaccinated    = 'N';
            $this->partially_vaccinated = 'N';
        }

        Resident::findOrFail($this->editingId)->update([
            'health_condition'            => $this->health_condition ?: null,
            'nutritional_classification'  => $this->nutritional_classification ?: null,
            'vulnerable_sector'           => $this->vulnerable_sector ?: null,
            'blood_type'                  => $this->blood_type ?: null,
            'height'                      => $this->height ?: null,
            'weight'                      => $this->weight ?: null,
            'unvaccinated'                => $this->unvaccinated ?: null,
            'partially_vaccinated'        => $this->partially_vaccinated ?: null,
            'fully_vaccinated'            => $this->fully_vaccinated ?: null,
            'covid_dose_1_date'           => $this->covid_dose_1_date ?: null,
            'covid_dose_2_date'           => $this->covid_dose_2_date ?: null,
            'covid_brand'                 => $this->covid_brand ?: null,
            'has_booster'                 => $this->has_booster ?: null,
            'booster_date'                => $this->booster_date ?: null,
            'booster_brand'               => $this->booster_brand ?: null,
            'has_philhealth'              => $this->has_philhealth ?: null,
            'philhealth_id'               => $this->philhealth_id ?: null,
            'philhealth_membership_type'  => $this->philhealth_membership_type ?: null,
        ]);

        $this->showEditModal = false;
        $this->editingId = null;
        Flux::toast('Health record updated successfully.', variant: 'success');
    }

    public function closeModal(): void
    {
        $this->showEditModal = false;
        $this->editingId = null;
        $this->reset([
            'health_condition', 'nutritional_classification', 'vulnerable_sector',
            'blood_type', 'height', 'weight',
            'unvaccinated', 'partially_vaccinated', 'fully_vaccinated',
            'covid_dose_1_date', 'covid_dose_2_date', 'covid_brand',
            'has_booster', 'booster_date', 'booster_brand',
            'has_philhealth', 'philhealth_id', 'philhealth_membership_type',
        ]);
    }

    public function render()
    {
        $query = Resident::approved()
            ->select($this->listColumns)
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

        if ($this->ageGroupFilter) {
            match ($this->ageGroupFilter) {
                'pediatric' => $query->where('age', '<=', 12),
                'youth'     => $query->whereBetween('age', [13, 24]),
                'adult'     => $query->whereBetween('age', [25, 59]),
                'senior'    => $query->where('age', '>=', 60),
                default     => null,
            };
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

        // Editing resident full record (with all health fields for the modal)
        $editingResident = $this->editingId ? Resident::find($this->editingId) : null;

        return view('livewire.health.edit-health-record', [
            'residents'        => $query->paginate(25),
            'editingResident'  => $editingResident,
        ]);
    }
}
