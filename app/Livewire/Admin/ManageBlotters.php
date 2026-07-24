<?php

namespace App\Livewire\Admin;

use App\Models\Blotter;
use Flux\Flux;
use Livewire\Component;

class ManageBlotters extends Component
{
    public string $search = '';

    public string $statusFilter = '';

    // Create / Edit modal state
    public bool $showFormModal = false;

    public ?int $editingId = null;

    public string $complainant_name = '';

    public string $respondent_name = '';

    public string $incident_type = '';

    public string $incident_date = '';

    public string $incident_location = '';

    public string $narrative = '';

    public string $status = 'Pending';

    public string $hearing_date = '';

    public string $hearing_time = '09:00 AM';

    public function create()
    {
        $this->resetValidation();
        $this->reset(['editingId', 'complainant_name', 'respondent_name', 'incident_type', 'incident_date', 'incident_location', 'narrative', 'hearing_date']);
        $this->status = 'Pending';
        $this->showFormModal = true;
    }

    public function edit(int $id)
    {
        $this->resetValidation();
        $blotter = Blotter::findOrFail($id);
        $this->editingId = $blotter->id;
        $this->complainant_name = $blotter->complainant_name;
        $this->respondent_name = $blotter->respondent_name;
        $this->incident_type = $blotter->incident_type;
        $this->incident_date = $blotter->incident_date ? $blotter->incident_date->format('Y-m-d') : '';
        $this->incident_location = $blotter->incident_location;
        $this->narrative = $blotter->narrative ?: '';
        $this->status = $blotter->status;
        $this->hearing_date = $blotter->hearing_date ? $blotter->hearing_date->format('Y-m-d') : '';
        $this->hearing_time = $blotter->hearing_date ? $blotter->hearing_date->format('h:i A') : '09:00 AM';
        $this->showFormModal = true;
    }

    public function save()
    {
        $this->validate([
            'complainant_name' => 'required|string|max:255',
            'respondent_name' => 'required|string|max:255',
            'incident_type' => 'required|string|max:255',
            'incident_date' => 'nullable|date',
            'incident_location' => 'nullable|string|max:255',
            'narrative' => 'nullable|string',
            'status' => 'required|string',
            'hearing_date' => 'nullable|date',
        ]);

        $hearingDateTime = null;
        if ($this->hearing_date) {
            $hearingDateTime = date('Y-m-d H:i:s', strtotime($this->hearing_date.' '.$this->hearing_time));
        }

        Blotter::updateOrCreate(
            ['id' => $this->editingId],
            [
                'complainant_name' => $this->complainant_name,
                'respondent_name' => $this->respondent_name,
                'incident_type' => $this->incident_type,
                'incident_date' => $this->incident_date ?: null,
                'incident_location' => $this->incident_location,
                'narrative' => $this->narrative,
                'status' => $this->status,
                'hearing_date' => $hearingDateTime,
            ]
        );

        $this->showFormModal = false;
        Flux::toast(variant: 'success', text: $this->editingId ? __('Blotter updated successfully.') : __('Blotter created successfully.'));
    }

    public function delete(int $id)
    {
        Blotter::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: __('Blotter record deleted.'));
    }

    public function render()
    {
        $query = Blotter::query()->orderBy('created_at', 'desc');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('complainant_name', 'like', '%'.$this->search.'%')
                    ->orWhere('respondent_name', 'like', '%'.$this->search.'%');
            });
        }

        return view('livewire.admin.manage-blotters', [
            'blotters' => $query->get(),
        ]);
    }
}
