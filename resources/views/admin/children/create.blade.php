@extends('layouts.app')
@section('title', 'Add Child')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Add Child</h1>
    <form method="POST" action="{{ route('admin.children.store') }}" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf
        @include('admin.children._form')
        <button type="submit" class="bg-salama text-white px-6 py-2 rounded-lg font-semibold">Save</button>
        <a href="{{ route('admin.children.index') }}" class="ml-3 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
