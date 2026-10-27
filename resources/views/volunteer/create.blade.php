@extends('layouts.app')
@section('title', 'Volunteer')
@section('content')
<div class="max-w-xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-2">Become a Volunteer</h1>
    <p class="text-gray-600 mb-8">Share your skills and time with the children at Salama Children’s Home in Bagamoyo.</p>

    <form method="POST" action="{{ route('volunteer.store') }}" class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Full name *</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nationality</label>
            <input type="text" name="nationality" value="{{ old('nationality') }}" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Preferred area</label>
            <select name="preferred_program" class="w-full border rounded-lg px-3 py-2">
                <option value="">Any / General</option>
                <option value="kindergarten">Kindergarten</option>
                <option value="mechanics">Mechanics training</option>
                <option value="tailoring">Tailoring</option>
                <option value="general">General support</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Skills & experience</label>
            <textarea name="skills" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('skills') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Availability</label>
            <textarea name="availability" rows="2" class="w-full border rounded-lg px-3 py-2" placeholder="e.g. Weekends, 2 weeks in July...">{{ old('availability') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Why do you want to volunteer? *</label>
            <textarea name="motivation" rows="4" required class="w-full border rounded-lg px-3 py-2">{{ old('motivation') }}</textarea>
        </div>
        <button type="submit" class="w-full bg-salama text-white font-semibold py-3 rounded-lg hover:opacity-90">Submit Application</button>
    </form>
</div>
@endsection
