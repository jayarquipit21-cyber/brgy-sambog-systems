<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'appointment_id',
        'user_id',
        'payer_name',
        'payer_address',
        'service_type',
        'item_name',
        'quantity',
        'unit_price',
        'total_amount',
        'amount_paid',
        'payment_status',
        'payment_method',
        'official_receipt_number',
        'processed_by',
        'notes',
        'paid_at',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Boot model to auto-generate unique transaction code if not set.
     */
    protected static function booted(): void
    {
        static::creating(function (Transaction $transaction) {
            if (empty($transaction->transaction_code)) {
                $datePrefix = now()->format('Ymd');
                $countToday = static::whereDate('created_at', now()->toDateString())->count() + 1;
                $transaction->transaction_code = sprintf('TXN-%s-%04d', $datePrefix, $countToday);
            }
        });
    }

    /**
     * Relate to User (Resident/Requester).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relate to Appointment.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Relate to Admin Processor.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scope: Paid transactions.
     */
    public function scopePaid(Builder $query): Builder
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope: Pending transactions.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope: Document services.
     */
    public function scopeDocuments(Builder $query): Builder
    {
        return $query->where('service_type', 'document');
    }

    /**
     * Scope: Rental services.
     */
    public function scopeRentals(Builder $query): Builder
    {
        return $query->where('service_type', 'rental');
    }

    /**
     * Mark transaction as paid.
     */
    public function markAsPaid(float $amount, string $method = 'cash', ?string $orNumber = null, ?int $processedById = null, ?string $notes = null): bool
    {
        return $this->update([
            'amount_paid' => $amount,
            'payment_status' => 'paid',
            'payment_method' => $method,
            'official_receipt_number' => $orNumber ?: $this->official_receipt_number,
            'processed_by' => $processedById,
            'notes' => $notes ?: $this->notes,
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark transaction as waived (e.g. Indigency / RA 11261).
     */
    public function markAsWaived(?int $processedById = null, ?string $reason = 'Statutory Fee Exemption / Indigency'): bool
    {
        return $this->update([
            'amount_paid' => 0.00,
            'payment_status' => 'waived',
            'payment_method' => 'free_exemption',
            'processed_by' => $processedById,
            'notes' => $reason,
            'paid_at' => now(),
        ]);
    }
}
