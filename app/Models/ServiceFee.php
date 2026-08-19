<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceFee extends Model
{
    protected $fillable = [
        'category',
        'name',
        'code',
        'default_fee',
        'fee_unit',
        'description',
        'is_active',
        'is_free_exemption_eligible',
    ];

    protected $casts = [
        'default_fee' => 'decimal:2',
        'is_active' => 'boolean',
        'is_free_exemption_eligible' => 'boolean',
    ];

    /**
     * Get active fees for a specific category or all.
     */
    public static function getFeesForCategory(?string $category = null)
    {
        $query = static::where('is_active', true);
        if ($category) {
            $query->where('category', $category);
        }

        return $query->orderBy('name')->get();
    }

    /**
     * Find fee amount by service name.
     */
    public static function getFeeByName(string $name): float
    {
        $fee = static::where('name', $name)->first();

        return $fee ? (float) $fee->default_fee : 0.00;
    }
}
