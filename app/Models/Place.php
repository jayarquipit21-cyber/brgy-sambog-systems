<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $guarded = [];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'is_featured' => 'boolean',
    ];
}
