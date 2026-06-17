<?php

namespace App\Livewire;

use App\Models\Resident;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompleteProfile extends Component
{
    // Personal extended info
    public string $place_of_birth = '';
    public string $highest_educational_attainment = '';
    public string $school_attended = '';
    public string $eligibility = '';
    public string $primary_skills = '';
    public string $secondary_skills = '';
    public string $other_skills = '';

    // Employment
    public string $occupation = '';
    public string $income = '';
    public string $days_work_per_week = '';

    // Voter extended
    public string $last_voted_year = '';
    public string $attended_kk_assembly = '';
    public string $kk_assembly_times = '';
    public string $kk_assembly_no_reason = '';

    // PhilHealth
    public string $philhealth_id = '';
    public string $philhealth_membership_type = '';

    // COVID Vaccination details
    public string $covid_dose_1_date = '';
    public string $covid_dose_2_date = '';
    public string $covid_brand = '';
    public string $has_booster = '';
    public string $booster_date = '';
    public string $booster_brand = '';

    // Social / Welfare
    public string $nutritional_classification = '';
    public string $vulnerable_sector = '';
    public string $social_welfare_availed = '';

    public bool $profileLinked = false;

    public function mount(): void
    {
        $resident = Auth::user()->resident;

        if ($resident) {
            $this->profileLinked = true;
            $this->place_of_birth                 = $resident->place_of_birth ?? '';
            $this->highest_educational_attainment = $resident->highest_educational_attainment ?? '';
            $this->school_attended                = $resident->school_attended ?? '';
            $this->eligibility                    = $resident->eligibility ?? '';
            $this->primary_skills                 = $resident->primary_skills ?? '';
            $this->secondary_skills               = $resident->secondary_skills ?? '';
            $this->other_skills                   = $resident->other_skills ?? '';
            $this->occupation                     = $resident->occupation ?? '';
            $this->income                         = $resident->income ?? '';
            $this->days_work_per_week             = $resident->days_work_per_week ?? '';
            $this->last_voted_year                = $resident->last_voted_year ?? '';
            $this->attended_kk_assembly           = $resident->attended_kk_assembly ?? '';
            $this->kk_assembly_times              = $resident->kk_assembly_times ?? '';
            $this->kk_assembly_no_reason          = $resident->kk_assembly_no_reason ?? '';
            $this->philhealth_id                  = $resident->philhealth_id ?? '';
            $this->philhealth_membership_type     = $resident->philhealth_membership_type ?? '';
            $this->covid_dose_1_date              = $resident->covid_dose_1_date ?? '';
            $this->covid_dose_2_date              = $resident->covid_dose_2_date ?? '';
            $this->covid_brand                    = $resident->covid_brand ?? '';
            $this->has_booster                    = $resident->has_booster ?? '';
            $this->booster_date                   = $resident->booster_date ?? '';
            $this->booster_brand                  = $resident->booster_brand ?? '';
            $this->nutritional_classification     = $resident->nutritional_classification ?? '';
            $this->vulnerable_sector              = $resident->vulnerable_sector ?? '';
            $this->social_welfare_availed         = $resident->social_welfare_availed ?? '';
        }
    }

    protected function rules(): array
    {
        return [
            'place_of_birth'                 => 'nullable|string|max:255',
            'highest_educational_attainment' => 'nullable|string|max:255',
            'school_attended'                => 'nullable|string|max:255',
            'eligibility'                    => 'nullable|string|max:255',
            'primary_skills'                 => 'nullable|string|max:255',
            'secondary_skills'               => 'nullable|string|max:255',
            'other_skills'                   => 'nullable|string|max:255',
            'occupation'                     => 'nullable|string|max:255',
            'income'                         => 'nullable|numeric|min:0',
            'days_work_per_week'             => 'nullable|integer|min:0|max:7',
            'last_voted_year'                => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'attended_kk_assembly'           => 'nullable|in:Y,N',
            'kk_assembly_times'              => 'nullable|string|max:100',
            'kk_assembly_no_reason'          => 'nullable|string|max:255',
            'philhealth_id'                  => 'nullable|string|max:50',
            'philhealth_membership_type'     => 'nullable|string|max:100',
            'covid_dose_1_date'              => 'nullable|date',
            'covid_dose_2_date'              => 'nullable|date',
            'covid_brand'                    => 'nullable|string|max:100',
            'has_booster'                    => 'nullable|in:Y,N',
            'booster_date'                   => 'nullable|date',
            'booster_brand'                  => 'nullable|string|max:100',
            'nutritional_classification'     => 'nullable|string|max:255',
            'vulnerable_sector'              => 'nullable|string|max:255',
            'social_welfare_availed'         => 'nullable|string|max:255',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $resident = Auth::user()->resident;

        if (! $resident) {
            Flux::toast(variant: 'danger', text: __('No resident profile is linked to your account yet.'));
            return;
        }

        $resident->update([
            'place_of_birth'                 => $this->place_of_birth ?: null,
            'highest_educational_attainment' => $this->highest_educational_attainment ?: null,
            'school_attended'                => $this->school_attended ?: null,
            'eligibility'                    => $this->eligibility ?: null,
            'primary_skills'                 => $this->primary_skills ?: null,
            'secondary_skills'               => $this->secondary_skills ?: null,
            'other_skills'                   => $this->other_skills ?: null,
            'occupation'                     => $this->occupation ?: null,
            'income'                         => $this->income ?: null,
            'days_work_per_week'             => $this->days_work_per_week ?: null,
            'last_voted_year'                => $this->last_voted_year ?: null,
            'attended_kk_assembly'           => $this->attended_kk_assembly ?: null,
            'kk_assembly_times'              => $this->kk_assembly_times ?: null,
            'kk_assembly_no_reason'          => $this->kk_assembly_no_reason ?: null,
            'philhealth_id'                  => $this->philhealth_id ?: null,
            'philhealth_membership_type'     => $this->philhealth_membership_type ?: null,
            'covid_dose_1_date'              => $this->covid_dose_1_date ?: null,
            'covid_dose_2_date'              => $this->covid_dose_2_date ?: null,
            'covid_brand'                    => $this->covid_brand ?: null,
            'has_booster'                    => $this->has_booster ?: null,
            'booster_date'                   => $this->booster_date ?: null,
            'booster_brand'                  => $this->booster_brand ?: null,
            'nutritional_classification'     => $this->nutritional_classification ?: null,
            'vulnerable_sector'              => $this->vulnerable_sector ?: null,
            'social_welfare_availed'         => $this->social_welfare_availed ?: null,
        ]);

        Flux::toast(variant: 'success', text: __('Your profile has been updated successfully.'));
    }

    public function render()
    {
        return view('livewire.complete-profile', [
            'resident' => Auth::user()->resident,
        ]);
    }
}
