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
    public string $religion = '';
    public string $blood_type = '';
    public string $height = '';
    public string $weight = '';
    public string $highest_educational_attainment = '';
    public string $school_attended = '';
    public string $course_completed = '';
    public string $eligibility = '';
    public string $primary_skills = '';
    public string $secondary_skills = '';
    public string $other_skills = '';

    // Employment
    public string $work_status = '';
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
    public string $health_condition = '';
    public string $nutritional_classification = '';
    public string $vulnerable_sector = '';
    public string $social_welfare_availed = '';

    // Household-level (For Household Heads)
    public string $is_house_owner = '';
    public string $is_renter = '';
    public string $is_farmer = '';
    public string $water_source = '';
    public string $sanitary_toilet = '';
    public string $waste_management = '';
    public string $has_blind_drainage = '';
    public string $renter_months = '';

    // Unemployment conditional fields
    public string $last_period_of_unemployment = '';
    public string $reason_of_unemployment = '';

    public bool $profileLinked = false;

    public function mount(): void
    {
        $resident = Auth::user()->resident;

        if ($resident) {
            $this->profileLinked = true;
            $this->place_of_birth                 = $resident->place_of_birth ?? '';
            $this->religion                       = $resident->religion ?? '';
            $this->blood_type                     = $resident->blood_type ?? '';
            $this->height                         = $resident->height ?? '';
            $this->weight                         = $resident->weight ?? '';
            $this->highest_educational_attainment = $resident->highest_educational_attainment ?? '';
            $this->school_attended                = $resident->school_attended ?? '';
            $this->course_completed               = $resident->course_completed ?? '';
            $this->eligibility                    = $resident->eligibility ?? '';
            $this->primary_skills                 = $resident->primary_skills ?? '';
            $this->secondary_skills               = $resident->secondary_skills ?? '';
            $this->other_skills                   = $resident->other_skills ?? '';
            $this->work_status                    = $resident->work_status ?? '';
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
            $this->health_condition               = $resident->health_condition ?? '';
            $this->nutritional_classification     = $resident->nutritional_classification ?? '';
            $this->vulnerable_sector              = $resident->vulnerable_sector ?? '';
            $this->social_welfare_availed         = $resident->social_welfare_availed ?? '';
            $this->is_house_owner                 = $resident->is_house_owner ?? '';
            $this->is_renter                      = $resident->is_renter ?? '';
            $this->is_farmer                      = $resident->is_farmer ?? '';
            $this->water_source                   = $resident->water_source ?? '';
            $this->sanitary_toilet                = $resident->sanitary_toilet ?? '';
            $this->waste_management               = $resident->waste_management ?? '';
            $this->has_blind_drainage             = $resident->has_blind_drainage ?? '';
            $this->renter_months                   = $resident->renter_months ?? '';
            $this->last_period_of_unemployment     = $resident->last_period_of_unemployment ?? '';
            $this->reason_of_unemployment          = $resident->reason_of_unemployment ?? '';
        }
    }

    protected function rules(): array
    {
        return [
            'place_of_birth'                 => 'nullable|string|max:255',
            'religion'                       => 'nullable|string|max:255',
            'blood_type'                     => 'nullable|string|max:10',
            'height'                         => 'nullable|string|max:50',
            'weight'                         => 'nullable|string|max:50',
            'highest_educational_attainment' => 'nullable|string|max:255',
            'school_attended'                => 'nullable|string|max:255',
            'course_completed'               => 'nullable|string|max:255',
            'eligibility'                    => 'nullable|string|max:255',
            'primary_skills'                 => 'nullable|string|max:255',
            'secondary_skills'               => 'nullable|string|max:255',
            'other_skills'                   => 'nullable|string|max:255',
            'work_status'                    => 'nullable|string|max:255',
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
            'health_condition'               => 'nullable|string|max:255',
            'nutritional_classification'     => 'nullable|string|max:255',
            'vulnerable_sector'              => 'nullable|string|max:255',
            'social_welfare_availed'         => 'nullable|string|max:255',
            'is_house_owner'                 => 'nullable|in:Y,N',
            'is_renter'                      => 'nullable|in:Y,N',
            'is_farmer'                      => 'nullable|in:Y,N',
            'water_source'                   => 'nullable|string|max:255',
            'sanitary_toilet'                => 'nullable|string|max:255',
            'waste_management'               => 'nullable|string|max:255',
            'has_blind_drainage'             => 'nullable|in:Y,N',
            'renter_months'                  => 'nullable|integer|min:0',
            'last_period_of_unemployment'    => 'nullable|string|max:255',
            'reason_of_unemployment'         => 'nullable|string|max:255',
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
            'religion'                       => $this->religion ?: null,
            'blood_type'                     => $this->blood_type ?: null,
            'height'                         => $this->height ?: null,
            'weight'                         => $this->weight ?: null,
            'highest_educational_attainment' => $this->highest_educational_attainment ?: null,
            'school_attended'                => $this->school_attended ?: null,
            'course_completed'               => $this->course_completed ?: null,
            'eligibility'                    => $this->eligibility ?: null,
            'primary_skills'                 => $this->primary_skills ?: null,
            'secondary_skills'               => $this->secondary_skills ?: null,
            'other_skills'                   => $this->other_skills ?: null,
            'work_status'                    => $this->work_status ?: null,
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
            'health_condition'               => $this->health_condition ?: null,
            'nutritional_classification'     => $this->nutritional_classification ?: null,
            'vulnerable_sector'              => $this->vulnerable_sector ?: null,
            'social_welfare_availed'         => $this->social_welfare_availed ?: null,
            'is_house_owner'                 => Auth::user()->isHouseholdHead() ? ($this->is_house_owner ?: null) : ($resident->is_house_owner ?? null),
            'is_renter'                      => Auth::user()->isHouseholdHead() ? ($this->is_renter ?: null) : ($resident->is_renter ?? null),
            'is_farmer'                      => Auth::user()->isHouseholdHead() ? ($this->is_farmer ?: null) : ($resident->is_farmer ?? null),
            'water_source'                   => Auth::user()->isHouseholdHead() ? ($this->water_source ?: null) : ($resident->water_source ?? null),
            'sanitary_toilet'                => Auth::user()->isHouseholdHead() ? ($this->sanitary_toilet ?: null) : ($resident->sanitary_toilet ?? null),
            'waste_management'               => Auth::user()->isHouseholdHead() ? ($this->waste_management ?: null) : ($resident->waste_management ?? null),
            'has_blind_drainage'             => Auth::user()->isHouseholdHead() ? ($this->has_blind_drainage ?: null) : ($resident->has_blind_drainage ?? null),
            'renter_months'                  => Auth::user()->isHouseholdHead() ? ($this->renter_months ?: null) : ($resident->renter_months ?? null),
            'last_period_of_unemployment'    => $this->last_period_of_unemployment ?: null,
            'reason_of_unemployment'         => $this->reason_of_unemployment ?: null,
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
