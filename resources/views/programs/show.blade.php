@extends('layouts.app')

@section('title', $program->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <a href="{{ route('programs.index') }}" class="text-sm text-salama hover:underline">← All programs</a>
    
    <article class="bg-white rounded-xl shadow mt-4 overflow-hidden">
        @if($program->image)
            <img src="{{ asset($program->image) }}" alt="{{ $program->title }}" class="w-full h-56 sm:h-72 object-cover">
        @endif
        <div class="p-6 md:p-8">
            <span class="text-xs uppercase tracking-wide text-orange-600 font-medium">{{ $program->category }}</span>
            <h1 class="text-3xl font-bold text-gray-900 mt-1">{{ $program->title }}</h1>
            
            <div class="prose max-w-none mt-6 text-gray-700">
                {!! nl2br(e($program->description)) !!}
            </div>

            @if($program->eligibility)
                <div class="mt-6">
                    <h3 class="font-semibold">Eligibility</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ $program->eligibility }}</p>
                </div>
            @endif

            <div class="mt-6 grid sm:grid-cols-2 gap-4 text-sm">
                @if($program->location)
                    <div><span class="font-medium">Location:</span> {{ $program->location }}</div>
                @endif
                @if($program->start_date)
                    <div><span class="font-medium">Starts:</span> {{ $program->start_date->format('d M Y') }}</div>
                @endif
                @if($program->capacity)
                    <div><span class="font-medium">Capacity:</span> {{ $program->enrolled_count }} / {{ $program->capacity }}</div>
                @endif
            </div>

            @if($program->is_open_for_registration)
                <div class="mt-8 pt-6 border-t">
                    <a href="{{ route('support.create') }}?type=admission_info&program={{ urlencode($program->title) }}" 
                       class="inline-block bg-salama text-white font-semibold px-6 py-3 rounded-lg hover:opacity-90">
                        Apply / Request more information
                    </a>
                </div>
            @endif
        </div>
    </article>
</div>
@endsection
