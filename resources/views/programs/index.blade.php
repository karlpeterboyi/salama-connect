@extends('layouts.app')

@section('title', 'Programs')
@section('meta_description', 'Kindergarten, Mechanics and Tailoring programmes at Salama Children’s Home, Bagamoyo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900">Our Programs</h1>
        <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Practical education and vocational training that help orphans and vulnerable children build a better future.</p>
    </div>

    @if($programs->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($programs as $program)
                <a href="{{ route('programs.show', $program->slug) }}" class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden block">
                    @if($program->image)
                        <img src="{{ asset($program->image) }}" alt="{{ $program->title }}" class="w-full h-44 object-cover">
                    @else
                        <div class="h-44 bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center text-5xl">
                            @if($program->category === 'kindergarten') 🧒
                            @elseif($program->category === 'mechanics') 🔧
                            @elseif($program->category === 'tailoring') 🧵
                            @else 📚
                            @endif
                        </div>
                    @endif
                    <div class="p-6">
                        <span class="text-xs uppercase tracking-wide text-orange-600 font-medium">{{ $program->category }}</span>
                        <h2 class="font-bold text-lg mt-1 text-gray-900">{{ $program->title }}</h2>
                        <p class="text-gray-600 text-sm mt-2 line-clamp-3">{{ Str::limit(strip_tags($program->description), 120) }}</p>
                        @if($program->is_open_for_registration)
                            <span class="inline-block mt-3 text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Open for registration</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-10">{{ $programs->links() }}</div>
    @else
        <div class="bg-white rounded-xl shadow p-12 text-center text-gray-600">
            <p>Programmes will appear here once published.</p>
            <p class="mt-2 text-sm">Meanwhile you can <a href="{{ route('support.create') }}" class="text-salama underline">request information</a>.</p>
        </div>
    @endif
</div>
@endsection
