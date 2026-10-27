@extends('layouts.app')

@section('title', 'Request Received')

@section('content')
<div class="max-w-xl mx-auto px-4 py-20 text-center">
    <div class="text-5xl mb-4">✅</div>
    <h1 class="text-3xl font-bold mb-3">Thank you</h1>
    <p class="text-gray-600 mb-2">Your request has been received.</p>
    <p class="text-lg font-mono bg-gray-100 inline-block px-4 py-2 rounded">Reference: {{ $supportRequest->reference }}</p>
    <p class="text-sm text-gray-500 mt-6">Please keep this reference number. Our team will review your request and respond as soon as possible.</p>
    <a href="{{ route('home') }}" class="inline-block mt-8 text-salama font-semibold">← Back to home</a>
</div>
@endsection
