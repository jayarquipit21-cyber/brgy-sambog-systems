<?php

namespace App\Livewire;

use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyHousehold extends Component
{
    // Modal state
    public bool $showCreateModal = false;
    public ?int $editingResidentId = null;

    // Form fields
    public string $first_name = '';

    public string $middle_name = '';

    public string $last_name = '';

    public string $extension = '';

    public string $relationship_to_head = '';

    public string $birthdate = '';

    public string $sex = '';

    public string $civil_status = '';

    public string $citizenship = 'Filipino';

    public string $mobile_number = '';

    public string $email_address = '';

    // Voter fields
    public string $registered_national_voter = '';

    public string $registered_sk_voter = '';

    public string $resident_voter = '';

    // Health fields
    public string $fully_vaccinated = '';

    public string $has_philhealth = '';

    public string $health_condition = 'None';

    // Education & Employment fields
    public string $educational_status = '';

    public string $work_status = '';

    public string $blood_type = '';

    public string $religion = '';

    public string $height = '';

    public string $weight = '';


    protected function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'extension' => 'nullable|string|max:10',
            'relationship_to_head' => 'required|string|max:100',
            'birthdate' => 'required|date|before:today',
            'sex' => 'required|in:Male,Female',
            'civil_status' => 'required|string|max:50',
            'citizenship' => 'required|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',

            'registered_national_voter' => 'required|in:Y,N',
            'registered_sk_voter' => 'required|in:Y,N',
            'resident_voter' => 'required|in:Y,N',

            'fully_vaccinated' => 'required|in:Y,N',
            'has_philhealth' => 'required|in:Y,N',
            'health_condition' => 'nullable|string|max:255',

            'educational_status' => 'required|string|max:255',
            'work_status' => 'required|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'religion' => 'nullable|string|max:255',
            'height' => 'nullable|string|max:50',
            'weight' => 'nullable|string|max:50',
        ];
    }

    public function openCreateModal(): void
    {
        $this->resetErrorBag();
        $this->reset([
            'editingResidentId',
            'first_name', 'middle_name', 'last_name', 'extension',
            'relationship_to_head', 'birthdate', 'sex', 'civil_status',
            'citizenship', 'mobile_number', 'email_address',
            'registered_national_voter', 'registered_sk_voter', 'resident_voter',
            'fully_vaccinated', 'has_philhealth', 'health_condition',
            'educational_status', 'work_status', 'blood_type', 'religion',
            'height', 'weight',
        ]);
        $this->citizenship = 'Filipino';
        $this->health_condition = 'None';
        $this->showCreateModal = true;
    }

    public function editResident(int $residentId): void
    {
        $this->resetErrorBag();
        $resident = Resident::find($residentId);
        
        if (!$resident || $resident->household_id !== Auth::user()->resident->household_id) {
            Flux::toast(variant: 'danger', text: __('Resident not found or unauthorized.'));
            return;
        }

        $this->editingResidentId = $resident->id;
        $this->first_name = $resident->first_name ?? '';
        $this->middle_name = $resident->middle_name ?? '';
        $this->last_name = $resident->last_name ?? '';
        $this->extension = $resident->extension ?? '';
        $this->relationship_to_head = $resident->relationship_to_head ?? '';
        $this->birthdate = $resident->birthdate ?? '';
        $this->sex = $resident->sex ?? '';
        $this->civil_status = $resident->civil_status ?? '';
        $this->citizenship = $resident->citizenship ?? '';
        $this->mobile_number = $resident->mobile_number ?? '';
        $this->email_address = $resident->email_address ?? '';
        $this->registered_national_voter = $resident->registered_national_voter ?? '';
        $this->registered_sk_voter = $resident->registered_sk_voter ?? '';
        $this->resident_voter = $resident->resident_voter ?? '';
        $this->fully_vaccinated = $resident->fully_vaccinated ?? '';
        $this->has_philhealth = $resident->has_philhealth ?? '';
        $this->health_condition = $resident->health_condition ?? 'None';
        $this->educational_status = $resident->educational_status ?? '';
        $this->work_status = $resident->work_status ?? '';
        $this->blood_type = $resident->blood_type ?? '';
        $this->religion = $resident->religion ?? '';
        $this->height = $resident->height ?? '';
        $this->weight = $resident->weight ?? '';

        $this->showCreateModal = true;
    }

    public function saveResident()
    {
        $this->validate();

        $user = Auth::user();
        $headResident = $user->resident;

        if (! $headResident || ! $headResident->household_id) {
            Flux::toast(variant: 'danger', text: __('You must be linked to a Household to add members.'));
            return;
        }

        // Calculate age
        $birthDateCarbon = Carbon::parse($this->birthdate);
        $age = $birthDateCarbon->age;

        // Try to locate an existing User account matching the email
        $existingUser = null;
        if ($this->email_address) {
            $existingUser = User::where('email', strtolower($this->email_address))->first();
        }

        $data = [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'extension' => $this->extension,
            'relationship_to_head' => $this->relationship_to_head,
            'birthdate' => $this->birthdate,
            'age' => $age,
            'sex' => $this->sex,
            'civil_status' => $this->civil_status,
            'citizenship' => $this->citizenship,
            'mobile_number' => $this->mobile_number,
            'email_address' => $this->email_address ? strtolower($this->email_address) : null,
            'registered_national_voter' => $this->registered_national_voter,
            'registered_sk_voter' => $this->registered_sk_voter,
            'resident_voter' => $this->resident_voter,
            'fully_vaccinated' => $this->fully_vaccinated,
            'has_philhealth' => $this->has_philhealth,
            'health_condition' => $this->health_condition,
            'educational_status' => $this->educational_status,
            'work_status' => $this->work_status,
            'blood_type' => $this->blood_type ?: null,
            'religion' => $this->religion ?: null,
            'height' => $this->height ?: null,
            'weight' => $this->weight ?: null,
        ];

        if ($existingUser) {
            $data['user_id'] = $existingUser->id;
        }

        if ($this->editingResidentId) {
            $resident = Resident::find($this->editingResidentId);
            if ($resident && $resident->household_id === $headResident->household_id) {
                // Only overwrite user_id if we found one, otherwise keep existing
                // (Unless email is cleared out, but usually we just want to link)
                if (!$existingUser && !$this->email_address) {
                    $data['user_id'] = null; // Unlink if email is empty
                }
                
                $resident->update($data);
                Flux::toast(variant: 'success', text: __('Household member updated successfully.'));
            }
        } else {
            $data['household_id'] = $headResident->household_id;
            $data['registration_status'] = 'pending';
            Resident::create($data);
            Flux::toast(variant: 'success', text: __('Household member added successfully.'));
        }

        $this->showCreateModal = false;
    }

    public function render()
    {
        $user = Auth::user();
        $resident = $user->resident;

        $household = null;
        $members = collect();

        if ($resident && $resident->household_id) {
            $household = Household::find($resident->household_id);
            if ($household) {
                $members = Resident::where('household_id', $household->id)
                    ->orderBy('age', 'desc')
                    ->get();
            }
        }

        return view('livewire.my-household', [
            'household' => $household,
            'members' => $members,
            'resident' => $resident,
        ]);
    }
}
