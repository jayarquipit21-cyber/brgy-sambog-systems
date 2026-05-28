<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Household extends Model
{
    protected $fillable = [
        'household_no',
        'purok_no',
        'address',
    ];

    /**
     * Get residents of this household.
     */
    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    /**
     * Get the household head.
     */
    public function head()
    {
        return $this->hasOne(Resident::class)->where(function ($query) {
            $query->where('relationship_to_head', 'HH')
                  ->orWhere('relationship_to_head', 'Household Head');
        });
    }
}
