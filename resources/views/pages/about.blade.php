@extends('layouts.app')
@section('title', 'About Us')
@section('meta_description', 'Salama Children\'s Home was founded by Mr. Muhammad Mwiga on 7 January 2023 to provide care, protection, education and skills to orphans and vulnerable children in Pwani and Dar es Salaam.')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-6">About Salama Children’s Home</h1>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        {{-- Founder photo --}}
        <div class="relative">
            <img src="{{ asset('images/about/founder.jpg') }}"
                 alt="Mr. Muhammad Mwiga with children at Salama Children's Home"
                 class="w-full h-64 sm:h-80 object-cover object-top">
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                <p class="text-white font-semibold text-lg">Mr. Muhammad Mwiga</p>
                <p class="text-white/90 text-sm">Founder, Salama Children’s Home</p>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-8">
            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">Our Founder</h2>
                <p class="text-gray-700 leading-relaxed">
                    Salama Children’s Home was founded by <strong>Mr. Muhammad Mwiga</strong> in collaboration with other committed individuals, in response to the challenges facing orphans and other vulnerable children in the Pwani and Dar es Salaam regions — particularly those lacking access to education, shelter and proper healthcare.
                </p>
                <p class="text-gray-700 leading-relaxed mt-4">
                    Driven by compassion, Mr. Muhammad began using funds from his daily activities to support five children living on the streets who had been exposed to sexual harassment and other forms of abuse. He provided them with care, protection and hope for a better future.
                </p>
                <p class="text-gray-700 leading-relaxed mt-4">
                    Those five children successfully acquired professional skills and became an electrician, a technician, a carpenter, a nurse and a cosmetician. Their success inspired Mr. Muhammad Mwiga to extend similar opportunities to more orphans and vulnerable children.
                </p>
                <p class="text-gray-700 leading-relaxed mt-4">
                    This vision led to the official establishment of <strong>Salama Children’s Home on 7 January 2023</strong>, with a mission to provide care, protection, education and skills development — enabling children to build brighter and more independent futures.
                </p>
            </section>

            <hr class="border-gray-200">

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">Our Vision</h2>
                <p class="text-gray-700 leading-relaxed">
                    A society where orphans and other vulnerable children enjoy healthy, enlightened lives, better education services and a responsive environment that promotes their social, economic, cultural and moral development.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">Our Mission</h2>
                <p class="text-gray-700 leading-relaxed">
                    To provide care, protection, education and skills development for orphans and other vulnerable children, advocating for poverty alleviation and improved social services so that every child can build a brighter, independent future.
                </p>
            </section>

            <hr class="border-gray-200">

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-3">What We Do</h2>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li><strong>Kindergarten</strong> — Early childhood education for children aged 3–6</li>
                    <li><strong>Mechanics Training</strong> — Motorcycle repair and maintenance skills</li>
                    <li><strong>Tailoring</strong> — Sewing and garment-making for self-reliance</li>
                    <li>Care, protection and holistic support for orphans and vulnerable children in Bagamoyo and surrounding areas</li>
                </ul>
                <p class="text-gray-700 mt-4">
                    We currently serve children across 14 villages and streets in the Bagamoyo area (Pwani Region).
                </p>
            </section>

            <p class="pt-2">
                <a href="{{ route('contact') }}" class="text-salama font-semibold hover:underline">Contact us →</a>
                &nbsp;·&nbsp;
                <a href="{{ route('donate.create') }}" class="text-salama font-semibold hover:underline">Support our work →</a>
            </p>
        </div>
    </div>
</div>
@endsection
