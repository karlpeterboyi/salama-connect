<?php

namespace App\Http\Controllers;

use App\Models\VolunteerApplication;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function create()
    {
        return view('volunteer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'nationality' => 'nullable|string|max:100',
            'skills' => 'nullable|string|max:2000',
            'availability' => 'nullable|string|max:1000',
            'motivation' => 'required|string|max:3000',
            'preferred_program' => 'nullable|string|max:100',
        ]);

        VolunteerApplication::create($validated);

        return view('volunteer.thanks');
    }
}
