<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'type', 'description', 'region', 'district',
        'address', 'latitude', 'longitude', 'phone', 'email', 'website',
        'services', 'accessibility_info', 'status', 'verified_at',
        'next_review_at', 'verification_source', 'is_salama_owned',
    ];

    protected $casts = [
        'services' => 'array',
        'verified_at' => 'date',
        'next_review_at' => 'date',
        'is_salama_owned' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facility) {
            if (empty($facility->slug)) {
                $facility->slug = Str::slug($facility->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeNearby($query, $lat, $lng, $radiusKm = 50)
    {
        // Simple bounding box approximation; for production use spatial queries
        $latDelta = $radiusKm / 111;
        $lngDelta = $radiusKm / (111 * cos(deg2rad($lat)));

        return $query->whereBetween('latitude', [$lat - $latDelta, $lat + $latDelta])
                     ->whereBetween('longitude', [$lng - $lngDelta, $lng + $lngDelta]);
    }
}
