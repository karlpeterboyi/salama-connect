<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Illuminate\Http\Request;

class SupportRequestController extends Controller
{
    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'requester_name' => 'required|string|max:255',
            'requester_phone' => 'nullable|string|max:30',
            'requester_email' => 'nullable|email|max:255',
            'relationship_to_child' => 'nullable|string|max:100',
            'child_age_range' => 'nullable|string|max:50',
            'preferred_location' => 'nullable|string|max:100',
            'request_type' => 'required|string|max:100',
            'message' => 'required|string|max:5000',
            'consent_given' => 'accepted',
        ]);

        $supportRequest = SupportRequest::create($validated);

        return redirect()->route('support.thanks', $supportRequest->reference);
    }

    public function thanks(string $reference)
    {
        $supportRequest = SupportRequest::where('reference', $reference)->firstOrFail();
        return view('support.thanks', compact('supportRequest'));
    }
}
