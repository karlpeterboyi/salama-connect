<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', "Salama Children's Home - Supporting orphans and vulnerable children in Bagamoyo, Tanzania through education, vocational training and care.")">
    <title>@yield('title', 'Salama Connect') — Salama Children's Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { --salama-orange: #e67e22; --salama-dark: #2c3e50; }
        .bg-salama { background-color: #e67e22; }
        .text-salama { color: #e67e22; }
        .border-salama { border-color: #e67e22; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Salama Children's Home" class="h-10 w-auto object-contain">
                    <span class="text-lg font-bold text-gray-900 hidden sm:inline">Salama Children's Home</span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" class="hover:text-salama">{{ __('messages.home') }}</a>
                    <a href="{{ route('facilities.index') }}" class="hover:text-salama">{{ __('messages.find_support') }}</a>
                    <a href="{{ route('programs.index') }}" class="hover:text-salama">{{ __('messages.programs') }}</a>
                    <a href="{{ route('support.create') }}" class="hover:text-salama">{{ __('messages.request_help') }}</a>
                    <a href="{{ route('about') }}" class="hover:text-salama">{{ __('messages.about') }}</a>
                    <a href="{{ route('donate.create') }}" class="bg-salama text-white px-4 py-2 rounded-lg hover:opacity-90">{{ __('messages.donate') }}</a>
                    <div class="flex gap-2 ml-2 border-l pl-4">
                        <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale()==='en' ? 'font-bold text-salama' : 'text-gray-500' }}">EN</a>
                        <a href="{{ route('lang.switch', 'sw') }}" class="{{ app()->getLocale()==='sw' ? 'font-bold text-salama' : 'text-gray-500' }}">SW</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white font-bold text-lg mb-3">Salama Children's Home</h3>
                <p class="text-sm">Supporting orphans and vulnerable children in Bagamoyo, Tanzania through kindergarten, vocational training and care.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('facilities.index') }}" class="hover:text-white">Find Support</a></li>
                    <li><a href="{{ route('programs.index') }}" class="hover:text-white">Programs</a></li>
                    <li><a href="{{ route('volunteer.create') }}" class="hover:text-white">Volunteer</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Contact</h4>
                <p class="text-sm">Bagamoyo, Tanzania</p>
                <p class="text-sm">+255 688 489 495</p>
                <p class="text-sm">info@salamachildrens.or.tz</p>
            </div>
        </div>
        <div class="border-t border-gray-800 text-center py-4 text-xs">
            &copy; {{ date('Y') }} Salama Children's Home (SOVc). All rights reserved.
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
