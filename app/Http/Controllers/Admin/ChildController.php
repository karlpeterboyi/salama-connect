<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Program;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function index(Request $request)
    {
        $query = Child::with('program')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('first_name', 'like', "%{$q}%")
                   ->orWhere('last_name', 'like', "%{$q}%")
                   ->orWhere('guardian_name', 'like', "%{$q}%");
            });
        }

        $children = $query->paginate(20)->withQueryString();
        $programs = Program::orderBy('title')->get();

        return view('admin.children.index', compact('children', 'programs'));
    }

    public function create()
    {
        $programs = Program::orderBy('title')->get();
        return view('admin.children.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date|before:today',
            'age' => 'nullable|integer|min:0|max:25',
            'gender' => 'nullable|in:male,female,other',
            'program_id' => 'nullable|exists:programs,id',
            'guardian_name' => 'nullable|string|max:150',
            'guardian_phone' => 'nullable|string|max:30',
            'guardian_relationship' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'admission_date' => 'nullable|date',
            'status' => 'required|in:active,graduated,left,inactive',
        ]);

        // Auto-calculate age if DOB given and age empty
        if (!empty($data['date_of_birth']) && empty($data['age'])) {
            $data['age'] = \Carbon\Carbon::parse($data['date_of_birth'])->age;
        }

        Child::create($data);

        return redirect()->route('admin.children.index')->with('success', 'Child record created.');
    }

    public function edit(Child $child)
    {
        $programs = Program::orderBy('title')->get();
        return view('admin.children.edit', compact('child', 'programs'));
    }

    public function update(Request $request, Child $child)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date|before:today',
            'age' => 'nullable|integer|min:0|max:25',
            'gender' => 'nullable|in:male,female,other',
            'program_id' => 'nullable|exists:programs,id',
            'guardian_name' => 'nullable|string|max:150',
            'guardian_phone' => 'nullable|string|max:30',
            'guardian_relationship' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'admission_date' => 'nullable|date',
            'status' => 'required|in:active,graduated,left,inactive',
        ]);

        if (!empty($data['date_of_birth']) && empty($data['age'])) {
            $data['age'] = \Carbon\Carbon::parse($data['date_of_birth'])->age;
        }

        $child->update($data);

        return redirect()->route('admin.children.index')->with('success', 'Child record updated.');
    }

    public function destroy(Child $child)
    {
        $child->delete();
        return redirect()->route('admin.children.index')->with('success', 'Child record deleted.');
    }
}
