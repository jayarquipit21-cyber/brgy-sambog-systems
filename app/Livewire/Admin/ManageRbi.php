<?php

namespace App\Livewire\Admin;

use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class ManageRbi extends Component
{
    use WithPagination;

    public string $search = '';

    public string $purokFilter = '';

    public string $voterFilter = '';

    public string $sortField = 'last_name';

    public string $sortDirection = 'asc';

    // Form fields for Household Head creation
    public bool $showCreateModal = false;

    public string $household_no = '';

    public string $purok_no = '';

    public string $address = '';

    public string $first_name = '';

    public string $middle_name = '';

    public string $last_name = '';

    public string $extension = '';

    public string $birthdate = '';

    public string $sex = '';

    public string $civil_status = '';

    public string $citizenship = 'Filipino';

    public string $mobile_number = '';

    public string $email = '';

    public string $password = '';

    protected function rules(): array
    {
        return [
            'household_no' => 'required|string|max:255',
            'purok_no' => 'required|integer|between:1,8',
            'address' => 'required|string|max:255',

            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'extension' => 'nullable|string|max:10',
            'birthdate' => 'required|date|before:today',
            'sex' => 'required|in:Male,Female',
            'civil_status' => 'required|string|max:50',
            'citizenship' => 'required|string|max:255',
            'mobile_number' => 'nullable|string|max:20',

            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ];
    }

    public function openCreateModal(): void
    {
        $this->resetErrorBag();
        $this->reset([
            'household_no', 'purok_no', 'address',
            'first_name', 'middle_name', 'last_name', 'extension',
            'birthdate', 'sex', 'civil_status', 'citizenship', 'mobile_number',
            'email', 'password',
        ]);
        $this->citizenship = 'Filipino';
        $this->showCreateModal = true;
    }

    public function saveHouseholdHead()
    {
        $this->validate();

        // 1. Create Household
        $household = Household::create([
            'household_no' => $this->household_no,
            'purok_no' => $this->purok_no,
            'address' => $this->address,
        ]);

        // 2. Create User account
        $user = User::create([
            'name' => trim($this->first_name.' '.$this->last_name),
            'email' => strtolower($this->email),
            'password' => bcrypt($this->password),
            'role' => 'household_head',
        ]);

        // 3. Create Resident profile
        $birthDateCarbon = Carbon::parse($this->birthdate);
        $age = $birthDateCarbon->age;

        Resident::create([
            'household_id' => $household->id,
            'user_id' => $user->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'extension' => $this->extension,
            'birthdate' => $this->birthdate,
            'age' => $age,
            'sex' => $this->sex,
            'civil_status' => $this->civil_status,
            'citizenship' => $this->citizenship,
            'mobile_number' => $this->mobile_number,
            'email_address' => strtolower($this->email),
            'relationship_to_head' => 'Household Head',
        ]);

        $this->showCreateModal = false;

        Flux::toast(variant: 'success', text: __('Household Head and Household created successfully.'));
    }

    // Reset pagination when search or filters change
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPurokFilter(): void
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

    public function updatingVoterFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Resident::with('household');

        // Apply sorting
        if (in_array($this->sortField, ['household_no', 'purok_no'])) {
            // join households table for sorting by household fields
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
                    ->orWhereHas('household', function ($hq) {
                        $hq->where('household_no', 'like', '%'.$this->search.'%');
                    });
            });
        }

        if ($this->purokFilter) {
            $query->whereHas('household', function ($hq) {
                $hq->where('purok_no', $this->purokFilter);
            });
        }

        if ($this->voterFilter) {
            if ($this->voterFilter === 'registered') {
                $query->where(function ($q) {
                    $q->where('registered_national_voter', 'Y')
                        ->orWhere('registered_sk_voter', 'Y')
                        ->orWhere('resident_voter', 'Y');
                });
            } elseif ($this->voterFilter === 'unregistered') {
                $query->where(function ($q) {
                    $q->where('registered_national_voter', '!=', 'Y')
                        ->where('registered_sk_voter', '!=', 'Y')
                        ->where('resident_voter', '!=', 'Y');
                });
            }
        }

        // Calculate simple stats for widgets
        $stats = [
            'total' => Resident::count(),
            'households' => Household::count(),
            'voters' => Resident::where('registered_national_voter', 'Y')->orWhere('resident_voter', 'Y')->count(),
            'seniors' => Resident::where('age', '>=', 60)->count(),
        ];

        return view('livewire.admin.manage-rbi', [
            'residents' => $query->paginate(15),
            'stats' => $stats,
        ]);
    }
}
