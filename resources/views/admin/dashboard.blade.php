@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold">Salama Connect — Administration</h1>
        <nav class="flex flex-wrap gap-2 text-sm">
            <a href="{{ route('admin.programs.index') }}" class="px-3 py-1.5 bg-white border rounded-lg hover:bg-gray-50">Programs</a>
            <a href="{{ route('admin.children.index') }}" class="px-3 py-1.5 bg-white border rounded-lg hover:bg-gray-50">Children</a>
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 bg-salama text-white rounded-lg">Dashboard</a>
        </nav>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Active Children</p>
            <p class="text-3xl font-bold text-gray-900">{{ $activeChildren }}</p>
            <p class="text-xs text-gray-400">{{ $childrenCount }} total</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Open Support Requests</p>
            <p class="text-3xl font-bold text-orange-600">{{ $openRequests }}</p>
            <p class="text-xs text-gray-400">{{ $newRequests }} new</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Programs</p>
            <p class="text-3xl font-bold">{{ $programsCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5">
            <p class="text-sm text-gray-500">Completed Donations</p>
            <p class="text-3xl font-bold">{{ $donationsCount }}</p>
            <p class="text-xs text-gray-400">TZS {{ number_format($donationsTotal) }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b font-semibold">Recent Support Requests</div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-4 py-2">Reference</th>
                            <th class="px-4 py-2">Requester</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRequests as $req)
                            <tr class="border-t">
                                <td class="px-4 py-2 font-mono text-xs">{{ $req->reference }}</td>
                                <td class="px-4 py-2">{{ $req->requester_name }}</td>
                                <td class="px-4 py-2"><span class="px-2 py-0.5 rounded text-xs bg-gray-100">{{ $req->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-6 text-center text-gray-500">No requests yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b font-semibold">Recent Donations</div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-4 py-2">Donor</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentDonations as $don)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $don->is_anonymous ? 'Anonymous' : $don->donor_name }}</td>
                                <td class="px-4 py-2">{{ number_format($don->amount) }} {{ $don->currency }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-0.5 rounded text-xs {{ $don->status==='completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100' }}">
                                        {{ $don->pesapal_status ?? $don->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-6 text-center text-gray-500">No donations yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
