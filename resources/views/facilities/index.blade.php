@extends('layouts.app')

@section('title', 'Find Support')
@section('meta_description', 'Find verified child care facilities, programmes and support near you in Bagamoyo and Coast Region, Tanzania.')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Find Support Near You</h1>
        <p class="text-gray-600 mt-2">Search verified facilities, Salama programmes and community contacts. You can search without sharing your exact location.</p>
    </div>

    {{-- Filters --}}
    <form method="GET" class="bg-white rounded-xl shadow p-4 mb-8 grid sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Type</label>
            <select name="type" class="w-full border rounded-lg px-3 py-2">
                <option value="">All types</option>
                <option value="childrens_home" @selected(request('type')=='childrens_home')>Children's Home</option>
                <option value="school" @selected(request('type')=='school')>School</option>
                <option value="social_welfare" @selected(request('type')=='social_welfare')>Social Welfare</option>
                <option value="health" @selected(request('type')=='health')>Health</option>
                <option value="other" @selected(request('type')=='other')>Other</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">District</label>
            <input type="text" name="district" value="{{ request('district') }}" placeholder="e.g. Bagamoyo" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-salama text-white font-semibold py-2 rounded-lg hover:opacity-90">Search</button>
        </div>
    </form>

    {{-- Map placeholder --}}
    <div id="map" class="h-80 bg-gray-200 rounded-xl mb-8 flex items-center justify-center text-gray-500">
        <div class="text-center">
            <p class="font-medium">Interactive map</p>
            <p class="text-sm">Leaflet map will load here when facilities with coordinates are available</p>
        </div>
    </div>

    @if($facilities->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($facilities as $facility)
                <a href="{{ route('facilities.show', $facility->slug) }}" class="bg-white rounded-xl shadow hover:shadow-lg transition p-5 block">
                    <div class="flex justify-between items-start">
                        <h2 class="font-bold text-lg text-gray-900">{{ $facility->name }}</h2>
                        @if($facility->is_salama_owned)
                            <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded">Salama</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 mt-1 capitalize">{{ str_replace('_', ' ', $facility->type) }}</p>
                    @if($facility->address)
                        <p class="text-sm text-gray-600 mt-2">📍 {{ $facility->address }}</p>
                    @endif
                    @if($facility->phone)
                        <p class="text-sm text-gray-600">📞 {{ $facility->phone }}</p>
                    @endif
                    @if($facility->services)
                        <div class="mt-3 flex flex-wrap gap-1">
                            @foreach($facility->services as $service)
                                <span class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded">{{ $service }}</span>
                            @endforeach
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $facilities->withQueryString()->links() }}</div>
    @else
        <div class="bg-white rounded-xl shadow p-10 text-center">
            <p class="text-gray-600 mb-4">No facilities match your search yet.</p>
            <a href="{{ route('support.create') }}" class="inline-block bg-salama text-white font-semibold px-6 py-3 rounded-lg">Request help from Salama instead</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapEl = document.getElementById('map');
        if (!mapEl) return;
        const map = L.map('map').setView([-6.445, 38.901], 11); // Bagamoyo approx
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        @foreach($facilities->whereNotNull('latitude') as $f)
            L.marker([{{ $f->latitude }}, {{ $f->longitude }}])
                .addTo(map)
                .bindPopup(`<strong>{{ $f->name }}</strong><br>{{ $f->address }}`);
        @endforeach
    });
</script>
@endpush
