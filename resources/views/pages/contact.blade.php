@extends('layouts.app')
@section('title', 'Contact')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-6">Contact Us</h1>
    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <p><strong>Salama Children’s Home (SOVc)</strong></p>
        <p>📍 Bagamoyo, Tanzania (Kiharaka area)</p>
        <p>📞 <a href="tel:+255688489495" class="text-salama">+255 688 489 495</a></p>
        <p>✉️ info@salamachildrens.or.tz</p>
        <hr class="my-6">
        <p class="text-gray-600 text-sm">
        <hr class="my-6">
        <p class="font-semibold text-gray-900 mb-2">Donate</p>
        <p class="text-sm text-gray-600"><strong>NBC Bank:</strong> Salama Children Home · Acc 110166000051 · SWIFT NLCBTZTX</p>
        <p class="text-sm text-gray-600"><strong>Airtel Lipa Namba:</strong> 137398132 (Salama Children Home)</p>
        <p class="text-sm mt-2"><a href="{{ route('donate.create') }}" class="text-salama underline">Full donation page →</a></p>

        For urgent support requests, please use the <a href="{{ route('support.create') }}" class="text-salama underline">Request Help</a> form so we can track and respond properly.</p>
    </div>
</div>
@endsection
