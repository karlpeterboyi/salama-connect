@extends('layouts.app')
@section('title', 'Manage Programs')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Programs</h1>
        <a href="{{ route('admin.programs.create') }}" class="bg-salama text-white px-4 py-2 rounded-lg text-sm font-semibold">+ New Program</a>
    </div>
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Open?</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $p)
                <tr class="border-t">
                    <td class="px-4 py-3 font-medium">{{ $p->title }}</td>
                    <td class="px-4 py-3 capitalize">{{ $p->category }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded text-xs bg-gray-100">{{ $p->status }}</span></td>
                    <td class="px-4 py-3">{{ $p->is_open_for_registration ? 'Yes' : 'No' }}</td>
                    <td class="px-4 py-3 space-x-2">
                        <a href="{{ route('admin.programs.edit', $p) }}" class="text-salama hover:underline">Edit</a>
                        <form action="{{ route('admin.programs.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Delete this program?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No programs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $programs->links() }}</div>
</div>
@endsection
