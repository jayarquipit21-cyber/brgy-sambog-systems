<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentClosure extends Model
{
    protected $fillable = ['weekday', 'closed', 'reason'];

    protected $casts = [
        'weekday' => 'integer',
        'closed' => 'boolean',
    ];
}
