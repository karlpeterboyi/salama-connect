@extends('layouts.app')

@section('title', 'Request Help')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-2">Request Help</h1>
    <p class="text-gray-600 mb-8">Submit a confidential request. We will respond as soon as possible. You do not need to share a diagnosis or sensitive details publicly.</p>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('support.store') }}" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Your full name *</label>
            <input type="text" name="requester_name" value="{{ old('requester_name') }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Phone</label>
                <input type="text" name="requester_phone" value="{{ old('requester_phone') }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="requester_email" value="{{ old('requester_email') }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Your relationship to the child</label>
            <select name="relationship_to_child" class="w-full border rounded-lg px-3 py-2">
                <option value="">Select...</option>
                <option value="parent">Parent</option>
                <option value="guardian">Guardian</option>
                <option value="social_worker">Social worker / Official</option>
                <option value="relative">Relative</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Type of help needed *</label>
            <select name="request_type" required class="w-full border rounded-lg px-3 py-2">
                <option value="">Select...</option>
                <option value="admission_info">Admission / Program information</option>
                <option value="referral">Referral to services</option>
                <option value="emergency">Emergency / Urgent support</option>
                <option value="counselling">Counselling / Psychosocial</option>
                <option value="material_support">Material support guidance</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Message *</label>
            <textarea name="message" rows="5" required class="w-full border rounded-lg px-3 py-2">{{ old('message') }}</textarea>
        </div>
        <div class="flex items-start gap-2">
            <input type="checkbox" name="consent_given" value="1" required id="consent" class="mt-1">
            <label for="consent" class="text-sm text-gray-600">I consent to Salama Children’s Home contacting me about this request and processing the information provided in accordance with the privacy policy.</label>
        </div>
        <button type="submit" class="w-full bg-salama text-white font-semibold py-3 rounded-lg hover:opacity-90">Submit Confidential Request</button>
    </form>
</div>
@endsection
