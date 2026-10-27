@extends('layouts.app')
@section('title', 'Thank You')
@section('content')
<div class="max-w-md mx-auto px-4 py-20 text-center">
    <div class="text-5xl mb-4">🙏</div>
    <h1 class="text-2xl font-bold mb-3">Thank you{{ $donation->is_anonymous ? '' : ', ' . $donation->donor_name }}!</h1>
    <p class="text-gray-600">
        We have recorded your donation of
        <strong>{{ number_format($donation->amount) }} {{ $donation->currency }}</strong>
        via
        <strong>
            @switch($donation->payment_method)
                @case('airtel_lipa') Airtel Lipa Namba @break
                @case('nbc_bank') NBC Bank @break
                @case('pesapal') Pesapal @break
                @default Other
            @endswitch
        </strong>.
    </p>
    @if($donation->transaction_reference)
        <p class="text-sm text-gray-500 mt-2">Reference: {{ $donation->transaction_reference }}</p>
    @endif
    <p class="text-sm text-gray-500 mt-4">Our team will confirm receipt and send an acknowledgement shortly.</p>
    <a href="{{ route('home') }}" class="inline-block mt-8 text-salama font-semibold">← Home</a>
</div>
@endsection
