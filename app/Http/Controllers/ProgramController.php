<?php

namespace App\Http\Controllers;

use App\Models\Program;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::published()->latest()->paginate(9);
        return view('programs.index', compact('programs'));
    }

    public function show(string $slug)
    {
        $program = Program::where('slug', $slug)->published()->firstOrFail();
        return view('programs.show', compact('program'));
    }
}
