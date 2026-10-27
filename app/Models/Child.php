<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $table = 'children';

    protected $fillable = [
        'first_name', 'last_name', 'date_of_birth', 'age', 'gender',
        'program_id', 'guardian_name', 'guardian_phone', 'guardian_relationship',
        'notes', 'admission_date', 'status', 'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . ($this->last_name ?? ''));
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
