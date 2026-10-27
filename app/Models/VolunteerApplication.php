<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'email', 'phone', 'nationality', 'skills',
        'availability', 'motivation', 'preferred_program', 'status', 'admin_notes',
    ];
}
