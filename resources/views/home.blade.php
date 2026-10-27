@extends('layouts.app')

@section('title', 'Home')
@section('meta_description', 'Salama Connect - Find care, request help, join programs or support orphans and vulnerable children in Bagamoyo, Tanzania.')

@section('content')
{{-- Hero --}}
<section class="bg-gradient-to-br from-orange-500 to-amber-600 text-white">
    <div class="max-w-7xl mx-auto px-4 py-20 md:py-28 text-center">
        <p class="text-sm uppercase tracking-widest opacity-90 mb-3">Salama Children\'s Home · SOVc</p>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
            {{ __('messages.care_dignity_opportunity') }}
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10 opacity-95">
            {{ __('messages.hero_tagline') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('facilities.index') }}" class="bg-white text-orange-600 font-semibold px-8 py-3 rounded-lg shadow hover:bg-gray-100 transition">
                {{ __('messages.find_support_near_me') }}
            </a>
            <a href="{{ route('support.create') }}" class="border-2 border-white text-white font-semibold px-8 py-3 rounded-lg hover:bg-white/10 transition">
                Request Help
            </a>
        </div>
    </div>
</section>

{{-- Quick Actions --}}
<section class="max-w-7xl mx-auto px-4 -mt-10 relative z-10">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('facilities.index') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition text-center">
            <div class="text-3xl mb-2">📍</div>
            <h3 class="font-bold text-gray-900">Find Support</h3>
            <p class="text-sm text-gray-600 mt-1">Locate care options near you</p>
        </a>
        <a href="{{ route('support.create') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition text-center">
            <div class="text-3xl mb-2">🤝</div>
            <h3 class="font-bold text-gray-900">{{ __('messages.request_help_btn') }}</h3>
            <p class="text-sm text-gray-600 mt-1">Confidential guidance & referrals</p>
        </a>
        <a href="{{ route('programs.index') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition text-center">
            <div class="text-3xl mb-2">📚</div>
            <h3 class="font-bold text-gray-900">Join a Program</h3>
            <p class="text-sm text-gray-600 mt-1">Kindergarten & vocational training</p>
        </a>
        <a href="{{ route('donate.create') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition text-center">
            <div class="text-3xl mb-2">❤️</div>
            <h3 class="font-bold text-gray-900">Donate / Volunteer</h3>
            <p class="text-sm text-gray-600 mt-1">Make a lasting difference</p>
        </a>
    </div>
</section>

{{-- {{ __('messages.our_programs') }} --}}
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-900">{{ __('messages.our_programs') }}</h2>
        <p class="text-gray-600 mt-2">Practical skills and early education for a brighter future</p>
    </div>
    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="h-40 bg-orange-100 flex items-center justify-center text-5xl">🧒</div>
            <div class="p-6">
                <h3 class="font-bold text-lg">Kindergarten</h3>
                <p class="text-gray-600 text-sm mt-2">Early childhood education for children aged 3–6 from underserved communities in Bagamoyo.</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="h-40 bg-blue-100 flex items-center justify-center text-5xl">🔧</div>
            <div class="p-6">
                <h3 class="font-bold text-lg">Mechanics Training</h3>
                <p class="text-gray-600 text-sm mt-2">Hands-on motorcycle repair and maintenance skills for older youth seeking economic independence.</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="h-40 bg-pink-100 flex items-center justify-center text-5xl">🧵</div>
            <div class="p-6">
                <h3 class="font-bold text-lg">Tailoring</h3>
                <p class="text-gray-600 text-sm mt-2">Sewing and garment-making training that opens doors to self-employment and local industry.</p>
            </div>
        </div>
    </div>
    <div class="text-center mt-8">
        <a href="{{ route('programs.index') }}" class="inline-block bg-salama text-white font-semibold px-6 py-3 rounded-lg hover:opacity-90">View All Programs</a>
    </div>
</section>

{{-- Mission strip --}}
<section class="bg-gray-900 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ __('messages.our_mission') }}</h2>
        <p class="text-lg opacity-90">
            Founded by Mr. Muhammad Mwiga on 7 January 2023, Salama Children’s Home provides care, protection, education and skills development so orphans and vulnerable children can build brighter, independent futures.
        </p>
    </div>
</section>

    {{-- Founder teaser --}}
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow overflow-hidden flex flex-col md:flex-row">
            <img src="{{ asset('images/about/founder.jpg') }}" alt="Mr. Muhammad Mwiga" class="md:w-2/5 h-56 md:h-auto object-cover object-top">
            <div class="p-6 md:p-8 flex flex-col justify-center">
                <p class="text-sm uppercase tracking-wide text-orange-600 font-medium">Our Founder</p>
                <h2 class="text-2xl font-bold text-gray-900 mt-1">Mr. Muhammad Mwiga</h2>
                <p class="text-gray-600 mt-3">Founded Salama Children’s Home on 7 January 2023 after personally supporting five street children who went on to become skilled professionals. His vision: care, protection, education and skills for every vulnerable child.</p>
                <a href="{{ route('about') }}" class="inline-block mt-4 text-salama font-semibold hover:underline">Read the full story →</a>
            </div>
        </div>
    </section>

@endsection
