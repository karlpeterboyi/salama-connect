<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SupportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference', 'requester_name', 'requester_phone', 'requester_email',
        'relationship_to_child', 'child_age_range', 'preferred_location',
        'request_type', 'message', 'priority', 'status', 'assigned_to',
        'assigned_at', 'resolved_at', 'internal_notes', 'consent_given',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'resolved_at' => 'datetime',
        'consent_given' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($request) {
            if (empty($request->reference)) {
                $request->reference = 'SC-' . strtoupper(Str::random(8));
            }
        });
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
