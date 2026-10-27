<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\PesapalService;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function create()
    {
        return view('donate.create');
    }

    public function store(Request $request, PesapalService $pesapal)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'donor_phone' => 'nullable|string|max:30',
            'amount' => 'required|numeric|min:1000',
            'currency' => 'required|in:TZS,USD,EUR,KES',
            'message' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
            'campaign' => 'nullable|string|max:100',
            'transaction_reference' => 'nullable|string|max:100',
            'payment_method' => 'required|in:pesapal,manual,nbc_bank,airtel_lipa',
        ]);

        $donation = Donation::create(array_merge($validated, [
            'status' => 'pending',
            'is_anonymous' => $request->boolean('is_anonymous'),
            'payment_method' => $validated['payment_method'],
        ]));

        // Pesapal flow
        if ($validated['payment_method'] === 'pesapal') {
            $result = $pesapal->submitOrder($donation);

            if (isset($result['error'])) {
                return back()
                    ->withInput()
                    ->with('error', $result['error'] . (isset($result['details']) ? ' – Please check Pesapal credentials.' : ''));
            }

            if (!empty($result['redirect_url'])) {
                return redirect()->away($result['redirect_url']);
            }

            return back()->with('error', 'Could not start Pesapal payment. Please try again or choose manual.');
        }

        // Manual / offline intention
        return view('donate.thanks', compact('donation'));
    }

    /**
     * User is redirected here after paying (or cancelling) on Pesapal.
     */
    public function pesapalCallback(Request $request, PesapalService $pesapal)
    {
        $trackingId = $request->query('OrderTrackingId');
        $merchantRef = $request->query('OrderMerchantReference');

        $donation = null;
        if ($merchantRef) {
            $donation = Donation::where('merchant_reference', $merchantRef)->first();
        }
        if (!$donation && $trackingId) {
            $donation = Donation::where('pesapal_tracking_id', $trackingId)->first();
        }

        if ($donation) {
            $donation = $pesapal->syncDonationStatus($donation);
        }

        return view('donate.callback', compact('donation'));
    }

    /**
     * IPN endpoint – Pesapal calls this when status changes.
     */
    public function pesapalIpn(Request $request, PesapalService $pesapal)
    {
        $trackingId = $request->input('OrderTrackingId') ?? $request->query('OrderTrackingId');
        $merchantRef = $request->input('OrderMerchantReference') ?? $request->query('OrderMerchantReference');

        $donation = null;
        if ($merchantRef) {
            $donation = Donation::where('merchant_reference', $merchantRef)->first();
        }
        if (!$donation && $trackingId) {
            $donation = Donation::where('pesapal_tracking_id', $trackingId)->first();
        }

        if ($donation) {
            $pesapal->syncDonationStatus($donation);
        }

        // Pesapal expects JSON acknowledgement
        return response()->json([
            'orderNotificationType' => $request->input('OrderNotificationType', 'IPNCHANGE'),
            'orderTrackingId' => $trackingId,
            'orderMerchantReference' => $merchantRef,
            'status' => 200,
        ]);
    }
}
