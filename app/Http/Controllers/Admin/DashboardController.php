<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Program;
use App\Models\SupportRequest;
use App\Models\Donation;
use App\Models\VolunteerApplication;
use App\Models\Child;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'facilitiesCount' => Facility::count(),
            'activeFacilities' => Facility::where('status', 'active')->count(),
            'programsCount' => Program::count(),
            'childrenCount' => Child::count(),
            'activeChildren' => Child::where('status', 'active')->count(),
            'openRequests' => SupportRequest::whereIn('status', ['new', 'assigned', 'in_progress'])->count(),
            'newRequests' => SupportRequest::where('status', 'new')->count(),
            'donationsCount' => Donation::where('status', 'completed')->count(),
            'donationsTotal' => Donation::where('status', 'completed')->sum('amount'),
            'pendingVolunteers' => VolunteerApplication::where('status', 'new')->count(),
            'recentRequests' => SupportRequest::latest()->take(5)->get(),
            'recentDonations' => Donation::latest()->take(5)->get(),
        ]);
    }
}
