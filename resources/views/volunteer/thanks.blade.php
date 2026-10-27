@extends('layouts.app')
@section('title', 'Application Received')
@section('content')
<div class="max-w-md mx-auto px-4 py-20 text-center">
    <div class="text-5xl mb-4">🙌</div>
    <h1 class="text-2xl font-bold mb-3">Thank you for applying!</h1>
    <p class="text-gray-600">We have received your volunteer application and will review it soon.</p>
    <a href="{{ route('home') }}" class="inline-block mt-8 text-salama font-semibold">← Home</a>
</div>
@endsection
