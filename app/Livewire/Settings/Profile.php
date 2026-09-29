<?php

namespace App\Livewire\Settings;

use App\Concerns\ProfileValidationRules;
use App\Models\Household;
use App\Models\Resident;
use Flux\Flux;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('My Profile')]
class Profile extends Component
{
    use ProfileValidationRules, WithFileUploads;

    // Account fields
    public string $name = '';

    public string $email = '';

    // Avatar upload
    public $avatarFile = null;

    // Personal & Basic Info
    public string $first_name = '';

    public string $middle_name = '';

    public string $last_name = '';

    public string $extension = '';

    public string $sex = '';

    public string $birthdate = '';

    public string $place_of_birth = '';

    public string $civil_status = '';

    public string $citizenship = '';

    public string $religion = '';

    public string $blood_type = '';

    public string $height = '';

    public string $weight = '';

    public string $mobile_number = '';

    // Education & Skills
    public string $educational_status = '';

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

    public string $last_period_of_unemployment = '';

    public string $reason_of_unemployment = '';

    // Voter
    public string $registered_national_voter = '';

    public string $registered_sk_voter = '';

    public string $resident_voter = '';

    public string $last_voted_year = '';

    public string $attended_kk_assembly = '';

    public string $kk_assembly_times = '';

    public string $kk_assembly_no_reason = '';

    // PhilHealth & Health
    public string $has_philhealth = '';

    public string $philhealth_id = '';

    public string $philhealth_membership_type = '';

    public string $health_condition = '';

    public string $nutritional_classification = '';

    public string $vulnerable_sector = '';

    public string $social_welfare_availed = '';

    // COVID-19 details
    public string $fully_vaccinated = '';

    public string $covid_dose_1_date = '';

    public string $covid_dose_2_date = '';

    public string $covid_brand = '';

    public string $has_booster = '';

    public string $booster_date = '';

    public string $booster_brand = '';

    // Household-level (for Household Heads)
    public string $is_house_owner = '';

    public string $is_renter = '';

    public string $is_farmer = '';

    public string $water_source = '';

    public string $sanitary_toilet = '';

    public string $waste_management = '';

    public string $has_blind_drainage = '';

    public string $renter_months = '';

    public bool $profileLinked = false;

    public string $activeTab = 'overview';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';

        $resident = $user->resident;

        if ($resident) {
            $this->profileLinked = true;
            $this->first_name = $resident->first_name ?? '';
            $this->middle_name = $resident->middle_name ?? '';
            $this->last_name = $resident->last_name ?? '';
            $this->extension = $resident->extension ?? '';
            $this->sex = $resident->sex ?? '';
            $this->birthdate = $resident->birthdate ?? '';
            $this->place_of_birth = $resident->place_of_birth ?? '';
            $this->civil_status = $resident->civil_status ?? '';
            $this->citizenship = $resident->citizenship ?? 'Filipino';
            $this->religion = $resident->religion ?? '';
            $this->blood_type = $resident->blood_type ?? '';
            $this->height = $resident->height ?? '';
            $this->weight = $resident->weight ?? '';
            $this->mobile_number = $resident->mobile_number ?? '';

            $this->educational_status = $resident->educational_status ?? '';
            $this->highest_educational_attainment = $resident->highest_educational_attainment ?? '';
            $this->school_attended = $resident->school_attended ?? '';
            $this->course_completed = $resident->course_completed ?? '';
            $this->eligibility = $resident->eligibility ?? '';
            $this->primary_skills = $resident->primary_skills ?? '';
            $this->secondary_skills = $resident->secondary_skills ?? '';
            $this->other_skills = $resident->other_skills ?? '';

            $this->work_status = $resident->work_status ?? '';
            $this->occupation = $resident->occupation ?? '';
            $this->income = $resident->income !== null ? (string) $resident->income : '';
            $this->days_work_per_week = $resident->days_work_per_week !== null ? (string) $resident->days_work_per_week : '';
            $this->last_period_of_unemployment = $resident->last_period_of_unemployment ?? '';
            $this->reason_of_unemployment = $resident->reason_of_unemployment ?? '';

            $this->registered_national_voter = $resident->registered_national_voter ?? '';
            $this->registered_sk_voter = $resident->registered_sk_voter ?? '';
            $this->resident_voter = $resident->resident_voter ?? '';
            $this->last_voted_year = $resident->last_voted_year !== null ? (string) $resident->last_voted_year : '';
            $this->attended_kk_assembly = $resident->attended_kk_assembly ?? '';
            $this->kk_assembly_times = $resident->kk_assembly_times ?? '';
            $this->kk_assembly_no_reason = $resident->kk_assembly_no_reason ?? '';

            $this->has_philhealth = $resident->has_philhealth ?? '';
            $this->philhealth_id = $resident->philhealth_id ?? '';
            $this->philhealth_membership_type = $resident->philhealth_membership_type ?? '';
            $this->health_condition = $resident->health_condition ?? '';
            $this->nutritional_classification = $resident->nutritional_classification ?? '';
            $this->vulnerable_sector = $resident->vulnerable_sector ?? '';
            $this->social_welfare_availed = $resident->social_welfare_availed ?? '';

            $this->fully_vaccinated = $resident->fully_vaccinated ?? '';
            $this->covid_dose_1_date = $resident->covid_dose_1_date ?? '';
            $this->covid_dose_2_date = $resident->covid_dose_2_date ?? '';
            $this->covid_brand = $resident->covid_brand ?? '';
            $this->has_booster = $resident->has_booster ?? '';
            $this->booster_date = $resident->booster_date ?? '';
            $this->booster_brand = $resident->booster_brand ?? '';

            $this->is_house_owner = $resident->is_house_owner ?? '';
            $this->is_renter = $resident->is_renter ?? '';
            $this->is_farmer = $resident->is_farmer ?? '';
            $this->water_source = $resident->water_source ?? '';
            $this->sanitary_toilet = $resident->sanitary_toilet ?? '';
            $this->waste_management = $resident->waste_management ?? '';
            $this->has_blind_drainage = $resident->has_blind_drainage ?? '';
            $this->renter_months = $resident->renter_months !== null ? (string) $resident->renter_months : '';
        }
    }

    public function updatedAvatarFile(): void
    {
        $this->validate([
            'avatarFile' => 'image|max:3072', // 3MB Max
        ]);

        Flux::toast(variant: 'info', text: __('New photo selected. Please click Confirm & Save to update your profile.'));
    }

    public function saveAvatar(): void
    {
        $this->validate([
            'avatarFile' => 'required|image|max:3072', // 3MB Max
        ]);

        $user = Auth::user();

        // Delete old avatar if present
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $this->avatarFile->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        $this->avatarFile = null;
        $this->dispatch('avatar-saved');

        Flux::toast(variant: 'success', text: __('Profile picture updated successfully!'));
    }

    public function cancelAvatarUpload(): void
    {
        $this->avatarFile = null;
        $this->resetErrorBag('avatarFile');
        $this->dispatch('avatar-saved');
    }

    public function removeAvatar(): void
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        $this->dispatch('avatar-saved');
        $this->dispatch('profile-updated');

        Flux::toast(variant: 'success', text: __('Profile picture removed.'));
    }

    /**
     * Update account info (Name & Email).
     */
    public function updateAccountInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated');

        Flux::toast(variant: 'success', text: __('Account details updated successfully.'));
    }

    /**
     * Alias for updating profile account information.
     */
    public function updateProfileInformation(): void
    {
        $this->updateAccountInformation();
    }

    /**
     * Update extended Resident Profile information.
     */
    public function updateResidentDetails(): void
    {
        $this->validate([
            'place_of_birth' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'height' => 'nullable|string|max:50',
            'weight' => 'nullable|string|max:50',
            'mobile_number' => 'nullable|string|max:20',
            'civil_status' => 'nullable|string|max:50',
            'citizenship' => 'nullable|string|max:255',
            'highest_educational_attainment' => 'nullable|string|max:255',
            'school_attended' => 'nullable|string|max:255',
            'course_completed' => 'nullable|string|max:255',
            'eligibility' => 'nullable|string|max:255',
            'primary_skills' => 'nullable|string|max:255',
            'secondary_skills' => 'nullable|string|max:255',
            'other_skills' => 'nullable|string|max:255',
            'work_status' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'income' => 'nullable|numeric|min:0',
            'days_work_per_week' => 'nullable|integer|min:0|max:7',
            'last_voted_year' => 'nullable|digits:4|integer|min:1900|max:'.date('Y'),
            'attended_kk_assembly' => 'nullable|in:Y,N',
            'kk_assembly_times' => 'nullable|string|max:100',
            'kk_assembly_no_reason' => 'nullable|string|max:255',
            'philhealth_id' => 'nullable|string|max:50',
            'philhealth_membership_type' => 'nullable|string|max:100',
            'covid_dose_1_date' => 'nullable|date',
            'covid_dose_2_date' => 'nullable|date',
            'covid_brand' => 'nullable|string|max:100',
            'has_booster' => 'nullable|in:Y,N',
            'booster_date' => 'nullable|date',
            'booster_brand' => 'nullable|string|max:100',
            'health_condition' => 'nullable|string|max:255',
            'nutritional_classification' => 'nullable|string|max:255',
            'vulnerable_sector' => 'nullable|string|max:255',
            'social_welfare_availed' => 'nullable|string|max:255',
            'is_house_owner' => 'nullable|in:Y,N',
            'is_renter' => 'nullable|in:Y,N',
            'is_farmer' => 'nullable|in:Y,N',
            'water_source' => 'nullable|string|max:255',
            'sanitary_toilet' => 'nullable|string|max:255',
            'waste_management' => 'nullable|string|max:255',
            'has_blind_drainage' => 'nullable|in:Y,N',
            'renter_months' => 'nullable|integer|min:0',
            'last_period_of_unemployment' => 'nullable|string|max:255',
            'reason_of_unemployment' => 'nullable|string|max:255',
        ]);

        $resident = Auth::user()->resident;

        if (! $resident) {
            Flux::toast(variant: 'danger', text: __('No resident profile is linked to your account yet.'));

            return;
        }

        $resident->update([
            'place_of_birth' => $this->place_of_birth ?: null,
            'religion' => $this->religion ?: null,
            'blood_type' => $this->blood_type ?: null,
            'height' => $this->height ?: null,
            'weight' => $this->weight ?: null,
            'mobile_number' => $this->mobile_number ?: null,
            'civil_status' => $this->civil_status ?: null,
            'citizenship' => $this->citizenship ?: 'Filipino',
            'highest_educational_attainment' => $this->highest_educational_attainment ?: null,
            'school_attended' => $this->school_attended ?: null,
            'course_completed' => $this->course_completed ?: null,
            'eligibility' => $this->eligibility ?: null,
            'primary_skills' => $this->primary_skills ?: null,
            'secondary_skills' => $this->secondary_skills ?: null,
            'other_skills' => $this->other_skills ?: null,
            'work_status' => $this->work_status ?: null,
            'occupation' => $this->occupation ?: null,
            'income' => $this->income !== '' ? $this->income : null,
            'days_work_per_week' => $this->days_work_per_week !== '' ? $this->days_work_per_week : null,
            'last_voted_year' => $this->last_voted_year !== '' ? $this->last_voted_year : null,
            'attended_kk_assembly' => $this->attended_kk_assembly ?: null,
            'kk_assembly_times' => $this->kk_assembly_times ?: null,
            'kk_assembly_no_reason' => $this->kk_assembly_no_reason ?: null,
            'has_philhealth' => $this->has_philhealth ?: null,
            'philhealth_id' => $this->philhealth_id ?: null,
            'philhealth_membership_type' => $this->philhealth_membership_type ?: null,
            'covid_dose_1_date' => $this->covid_dose_1_date ?: null,
            'covid_dose_2_date' => $this->covid_dose_2_date ?: null,
            'covid_brand' => $this->covid_brand ?: null,
            'has_booster' => $this->has_booster ?: null,
            'booster_date' => $this->booster_date ?: null,
            'booster_brand' => $this->booster_brand ?: null,
            'health_condition' => $this->health_condition ?: null,
            'nutritional_classification' => $this->nutritional_classification ?: null,
            'vulnerable_sector' => $this->vulnerable_sector ?: null,
            'social_welfare_availed' => $this->social_welfare_availed ?: null,
            'is_house_owner' => Auth::user()->isHouseholdHead() ? ($this->is_house_owner ?: null) : ($resident->is_house_owner ?? null),
            'is_renter' => Auth::user()->isHouseholdHead() ? ($this->is_renter ?: null) : ($resident->is_renter ?? null),
            'is_farmer' => Auth::user()->isHouseholdHead() ? ($this->is_farmer ?: null) : ($resident->is_farmer ?? null),
            'water_source' => Auth::user()->isHouseholdHead() ? ($this->water_source ?: null) : ($resident->water_source ?? null),
            'sanitary_toilet' => Auth::user()->isHouseholdHead() ? ($this->sanitary_toilet ?: null) : ($resident->sanitary_toilet ?? null),
            'waste_management' => Auth::user()->isHouseholdHead() ? ($this->waste_management ?: null) : ($resident->waste_management ?? null),
            'has_blind_drainage' => Auth::user()->isHouseholdHead() ? ($this->has_blind_drainage ?: null) : ($resident->has_blind_drainage ?? null),
            'renter_months' => Auth::user()->isHouseholdHead() ? ($this->renter_months !== '' ? $this->renter_months : null) : ($resident->renter_months ?? null),
            'last_period_of_unemployment' => $this->last_period_of_unemployment ?: null,
            'reason_of_unemployment' => $this->reason_of_unemployment ?: null,
        ]);

        $this->activeTab = 'overview';

        Flux::toast(variant: 'success', text: __('Your resident details have been updated successfully.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: __('A new verification link has been sent to your email address.'));
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }

    public function render()
    {
        $user = Auth::user();
        $resident = $user->resident;
        $household = $resident && $resident->household_id ? Household::find($resident->household_id) : null;

        return view('livewire.settings.profile', [
            'user' => $user,
            'resident' => $resident,
            'household' => $household,
        ]);
    }
}
