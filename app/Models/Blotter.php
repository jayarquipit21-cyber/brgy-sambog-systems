<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blotter extends Model
{
    protected $fillable = [
        'complainant_name',
        'respondent_name',
        'incident_type',
        'incident_date',
        'incident_location',
        'narrative',
        'status',
        'hearing_date',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'hearing_date' => 'datetime',
    ];
}
