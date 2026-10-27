@extends('layouts.app')
@section('title', 'Edit Child')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Child</h1>
    <form method="POST" action="{{ route('admin.children.update', $child) }}" class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf @method('PUT')
        @include('admin.children._form')
        <button type="submit" class="bg-salama text-white px-6 py-2 rounded-lg font-semibold">Update</button>
        <a href="{{ route('admin.children.index') }}" class="ml-3 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
