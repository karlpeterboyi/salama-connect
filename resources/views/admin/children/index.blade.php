@extends('layouts.app')
@section('title', 'Children at Centre')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold">Children at the Centre</h1>
        <a href="{{ route('admin.children.create') }}" class="bg-salama text-white px-4 py-2 rounded-lg text-sm font-semibold">+ Add Child</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="GET" class="bg-white rounded-xl shadow p-4 mb-6 grid sm:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name / guardian..." class="border rounded-lg px-3 py-2">
        <select name="program_id" class="border rounded-lg px-3 py-2">
            <option value="">All programs</option>
            @foreach($programs as $prog)
                <option value="{{ $prog->id }}" @selected(request('program_id')==$prog->id)>{{ $prog->title }}</option>
            @endforeach
        </select>
        <select name="status" class="border rounded-lg px-3 py-2">
            <option value="">All statuses</option>
            @foreach(['active','graduated','left','inactive'] as $s)
                <option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-800 text-white rounded-lg px-4 py-2">Filter</button>
    </form>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Age</th>
                    <th class="px-4 py-3">Gender</th>
                    <th class="px-4 py-3">Program</th>
                    <th class="px-4 py-3">Guardian</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($children as $child)
                <tr class="border-t">
                    <td class="px-4 py-3 font-medium">{{ $child->full_name }}</td>
                    <td class="px-4 py-3">{{ $child->age ?? '—' }}</td>
                    <td class="px-4 py-3 capitalize">{{ $child->gender ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $child->program?->title ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $child->guardian_name ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded text-xs {{ $child->status==='active' ? 'bg-green-100 text-green-800' : 'bg-gray-100' }}">{{ $child->status }}</span>
                    </td>
                    <td class="px-4 py-3 space-x-2">
                        <a href="{{ route('admin.children.edit', $child) }}" class="text-salama hover:underline">Edit</a>
                        <form action="{{ route('admin.children.destroy', $child) }}" method="POST" class="inline" onsubmit="return confirm('Delete this record?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">No children records yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $children->links() }}</div>
</div>
@endsection
