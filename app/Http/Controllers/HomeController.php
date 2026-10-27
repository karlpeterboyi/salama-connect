<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Facility;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPrograms = collect();
        $salamaFacility = null;

        if (Schema::hasTable('programs')) {
            $featuredPrograms = Program::published()->latest()->take(3)->get();
        }
        if (Schema::hasTable('facilities')) {
            $salamaFacility = Facility::where('is_salama_owned', true)->first();
        }

        return view('home', compact('featuredPrograms', 'salamaFacility'));
    }
}
