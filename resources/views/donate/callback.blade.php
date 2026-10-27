@extends('layouts.app')
@section('title', 'Payment Status')
@section('content')
<div class="max-w-md mx-auto px-4 py-20 text-center">
    @if($donation && $donation->isPaid())
        <div class="text-5xl mb-4">✅</div>
        <h1 class="text-2xl font-bold mb-3">Payment successful</h1>
        <p class="text-gray-600">Thank you{{ $donation->is_anonymous ? '' : ', ' . $donation->donor_name }}! Your donation of <strong>{{ number_format($donation->amount) }} {{ $donation->currency }}</strong> has been received.</p>
        <p class="text-sm text-gray-500 mt-2">Reference: {{ $donation->merchant_reference }}</p>
    @elseif($donation)
        <div class="text-5xl mb-4">⏳</div>
        <h1 class="text-2xl font-bold mb-3">Payment {{ $donation->pesapal_status ?? $donation->status }}</h1>
        <p class="text-gray-600">We are still confirming your payment. You will receive confirmation once it is complete.</p>
        <p class="text-sm text-gray-500 mt-2">Reference: {{ $donation->merchant_reference }}</p>
    @else
        <div class="text-5xl mb-4">❓</div>
        <h1 class="text-2xl font-bold mb-3">Payment status unknown</h1>
        <p class="text-gray-600">We could not find this transaction. Please contact us with any reference you received.</p>
    @endif
    <a href="{{ route('home') }}" class="inline-block mt-8 text-salama font-semibold">← Home</a>
</div>
@endsection
