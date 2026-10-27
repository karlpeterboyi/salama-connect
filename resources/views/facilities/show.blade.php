@extends('layouts.app')

@section('title', $facility->name)
@section('meta_description', $facility->description ?? $facility->name . ' - Support facility in ' . ($facility->district ?? 'Bagamoyo'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <a href="{{ route('facilities.index') }}" class="text-sm text-salama hover:underline">← Back to directory</a>
    
    <div class="bg-white rounded-xl shadow mt-4 overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $facility->name }}</h1>
                    <p class="text-gray-500 capitalize mt-1">{{ str_replace('_', ' ', $facility->type) }}
                        @if($facility->is_salama_owned)
                            · <span class="text-orange-600 font-medium">Salama Children’s Home</span>
                        @endif
                    </p>
                </div>
                <span class="text-xs px-3 py-1 rounded-full 
                    {{ $facility->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst(str_replace('_', ' ', $facility->status)) }}
                </span>
            </div>

            @if($facility->description)
                <p class="mt-6 text-gray-700 leading-relaxed">{{ $facility->description }}</p>
            @endif

            <div class="mt-8 grid sm:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Location</h3>
                    @if($facility->address)
                        <p class="text-gray-600">{{ $facility->address }}</p>
                    @endif
                    <p class="text-gray-600">{{ $facility->district }}{{ $facility->district && $facility->region ? ', ' : '' }}{{ $facility->region }}</p>
                    @if($facility->latitude && $facility->longitude)
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $facility->latitude }},{{ $facility->longitude }}" 
                           target="_blank" rel="noopener"
                           class="inline-block mt-2 text-salama text-sm font-medium hover:underline">
                            Get directions →
                        </a>
                    @endif
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Contact</h3>
                    @if($facility->phone)
                        <p><a href="tel:{{ $facility->phone }}" class="text-salama hover:underline">{{ $facility->phone }}</a></p>
                    @endif
                    @if($facility->email)
                        <p class="text-gray-600">{{ $facility->email }}</p>
                    @endif
                    @if($facility->website)
                        <p><a href="{{ $facility->website }}" target="_blank" class="text-salama text-sm hover:underline">Website</a></p>
                    @endif
                </div>
            </div>

            @if($facility->services && count($facility->services))
                <div class="mt-8">
                    <h3 class="font-semibold text-gray-900 mb-2">Services</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($facility->services as $service)
                            <span class="bg-orange-50 text-orange-800 text-sm px-3 py-1 rounded-full">{{ $service }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($facility->accessibility_info)
                <div class="mt-6">
                    <h3 class="font-semibold text-gray-900 mb-1">Accessibility</h3>
                    <p class="text-gray-600 text-sm">{{ $facility->accessibility_info }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('support.create') }}" class="inline-block bg-salama text-white font-semibold px-6 py-3 rounded-lg hover:opacity-90">
            Request help related to this facility
        </a>
    </div>
</div>
@endsection
