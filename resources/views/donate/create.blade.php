@extends('layouts.app')
@section('title', 'Donate')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-2">Support Our Work</h1>
    <p class="text-gray-600 mb-8">Your contribution helps provide education, vocational training and care for orphans and vulnerable children in Bagamoyo.</p>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
    @endif

    {{-- Payment details cards --}}
    <div class="grid sm:grid-cols-2 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-600">
            <h2 class="font-bold text-gray-900 mb-2">NBC Bank Transfer</h2>
            <dl class="text-sm space-y-1 text-gray-700">
                <div><span class="text-gray-500">Account name:</span> <strong>Salama Children Home</strong></div>
                <div><span class="text-gray-500">Account no:</span> <strong class="font-mono">110166000051</strong></div>
                <div><span class="text-gray-500">Bank:</span> <strong>NBC Bank</strong></div>
                <div><span class="text-gray-500">SWIFT:</span> <strong class="font-mono">NLCBTZTX</strong></div>
            </dl>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-red-500">
            <h2 class="font-bold text-gray-900 mb-2">Airtel Money (Lipa Namba)</h2>
            <dl class="text-sm space-y-1 text-gray-700">
                <div><span class="text-gray-500">Lipa Namba:</span> <strong class="font-mono text-lg">137398132</strong></div>
                <div><span class="text-gray-500">Name:</span> <strong>Salama Children Home</strong></div>
            </dl>
            <p class="text-xs text-gray-500 mt-2">Open Airtel Money → Lipa Namba → enter 137398132</p>
        </div>
    </div>

    <form method="POST" action="{{ route('donate.store') }}" class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf
        <p class="text-sm text-gray-600">After sending money, please fill this form so we can acknowledge your gift and send a receipt.</p>

        <div>
            <label class="block text-sm font-medium mb-1">Full name *</label>
            <input type="text" name="donor_name" value="{{ old('donor_name') }}" required class="w-full border rounded-lg px-3 py-2">
            @error('donor_name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="donor_email" value="{{ old('donor_email') }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Phone</label>
                <input type="text" name="donor_phone" value="{{ old('donor_phone') }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Amount *</label>
                <input type="number" name="amount" value="{{ old('amount', 10000) }}" min="1000" step="500" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Currency</label>
                <select name="currency" class="w-full border rounded-lg px-3 py-2">
                    <option value="TZS" @selected(old('currency', 'TZS')==='TZS')>TZS</option>
                    <option value="USD" @selected(old('currency')==='USD')>USD</option>
                    <option value="EUR" @selected(old('currency')==='EUR')>EUR</option>
                    <option value="KES" @selected(old('currency')==='KES')>KES</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Payment method *</label>
            <select name="payment_method" required class="w-full border rounded-lg px-3 py-2">
                <option value="airtel_lipa" @selected(old('payment_method')==='airtel_lipa')>Airtel Money — Lipa Namba 137398132</option>
                <option value="nbc_bank" @selected(old('payment_method')==='nbc_bank')>NBC Bank Transfer (110166000051)</option>
                <option value="pesapal" @selected(old('payment_method')==='pesapal')>Pesapal (card / other mobile money)</option>
                <option value="manual" @selected(old('payment_method')==='manual')>Other / I will contact you</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Transaction / reference number (if already paid)</label>
            <input type="text" name="transaction_reference" value="{{ old('transaction_reference') }}" placeholder="e.g. Airtel receipt or bank reference" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Message (optional)</label>
            <textarea name="message" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('message') }}</textarea>
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_anonymous" value="1" id="anon" @checked(old('is_anonymous'))>
            <label for="anon" class="text-sm">Make this donation anonymous</label>
        </div>
        <button type="submit" class="w-full bg-salama text-white font-semibold py-3 rounded-lg hover:opacity-90">Submit Donation Details</button>
    </form>

    <p class="text-xs text-gray-500 mt-6 text-center">
        For bank transfers from outside Tanzania use SWIFT <strong>NLCBTZTX</strong>.
        Questions? <a href="{{ route('contact') }}" class="text-salama underline">Contact us</a>.
    </p>
</div>
@endsection
