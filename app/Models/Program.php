<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category', 'description', 'eligibility',
        'location', 'start_date', 'end_date', 'start_time', 'end_time',
        'capacity', 'enrolled_count', 'is_open_for_registration',
        'image', 'status', 'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_open_for_registration' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($program) {
            if (empty($program->slug)) {
                $program->slug = Str::slug($program->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }
}
