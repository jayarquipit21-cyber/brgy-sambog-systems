<?php

namespace App\Livewire;

use App\Models\Resident;
use App\Models\Household;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyHousehold extends Component
{
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
