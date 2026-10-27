<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->paginate(15);
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'eligibility' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'capacity' => 'nullable|integer|min:1',
            'is_open_for_registration' => 'boolean',
            'status' => 'required|in:draft,published,closed,archived',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_open_for_registration'] = $request->boolean('is_open_for_registration');

        Program::create($data);

        return redirect()->route('admin.programs.index')->with('success', 'Program created.');
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'eligibility' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'capacity' => 'nullable|integer|min:1',
            'is_open_for_registration' => 'boolean',
            'status' => 'required|in:draft,published,closed,archived',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_open_for_registration'] = $request->boolean('is_open_for_registration');

        $program->update($data);

        return redirect()->route('admin.programs.index')->with('success', 'Program updated.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program deleted.');
    }
}
