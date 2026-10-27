<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::active();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        $facilities = $query->orderBy('name')->paginate(12);

        return view('facilities.index', compact('facilities'));
    }

    public function show(string $slug)
    {
        $facility = Facility::where('slug', $slug)->firstOrFail();
        return view('facilities.show', compact('facility'));
    }
}
