@extends('layouts.app')
@section('title', 'New Program')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Create Program</h1>
    <form method="POST" action="{{ route('admin.programs.store') }}" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf
        @include('admin.programs._form')
        <button type="submit" class="bg-salama text-white px-6 py-2 rounded-lg font-semibold">Save Program</button>
        <a href="{{ route('admin.programs.index') }}" class="ml-3 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
