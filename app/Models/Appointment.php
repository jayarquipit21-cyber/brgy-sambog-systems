<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'appointment_date',
        'appointment_time',
        'purpose',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    /**
     * Get the user who booked the appointment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
