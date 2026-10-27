<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_reference', 'donor_name', 'donor_email', 'donor_phone',
        'amount', 'currency', 'payment_method', 'transaction_reference',
        'pesapal_tracking_id', 'campaign', 'message', 'is_anonymous',
        'is_recurring', 'status', 'pesapal_status', 'pesapal_response', 'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'is_recurring' => 'boolean',
        'paid_at' => 'datetime',
        'pesapal_response' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($donation) {
            if (empty($donation->merchant_reference)) {
                $donation->merchant_reference = 'SC-DON-' . strtoupper(Str::random(10));
            }
        });
    }

    public function isPaid(): bool
    {
        return in_array($this->status, ['completed']) || $this->pesapal_status === 'COMPLETED';
    }
}
