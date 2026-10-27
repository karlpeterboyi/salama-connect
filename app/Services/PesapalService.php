<?php

namespace App\Services;

use App\Models\Donation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PesapalService
{
    protected string $baseUrl;
    protected string $consumerKey;
    protected string $consumerSecret;
    protected bool $isLive;

    public function __construct()
    {
        $this->isLive = (bool) config('services.pesapal.live', false);
        $this->baseUrl = $this->isLive
            ? 'https://pay.pesapal.com/v3'
            : 'https://cybqa.pesapal.com/pesapalv3';
        $this->consumerKey = config('services.pesapal.consumer_key', '');
        $this->consumerSecret = config('services.pesapal.consumer_secret', '');
    }

    /**
     * Get or refresh OAuth bearer token (cached ~4 minutes).
     */
    public function getAccessToken(): ?string
    {
        return Cache::remember('pesapal_access_token', 240, function () {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/api/Auth/RequestToken', [
                'consumer_key' => $this->consumerKey,
                'consumer_secret' => $this->consumerSecret,
            ]);

            if (!$response->successful()) {
                Log::error('Pesapal auth failed', ['body' => $response->body()]);
                return null;
            }

            $data = $response->json();
            return $data['token'] ?? null;
        });
    }

    /**
     * Register IPN URL (do once, store notification_id in config/.env).
     */
    public function registerIpn(string $url, string $method = 'GET'): ?array
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        $response = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->post($this->baseUrl . '/api/URLSetup/RegisterIPN', [
                'url' => $url,
                'ipn_notification_type' => $method,
            ]);

        if (!$response->successful()) {
            Log::error('Pesapal IPN registration failed', ['body' => $response->body()]);
            return null;
        }

        return $response->json();
    }

    /**
     * Submit order and return redirect URL for the payer.
     */
    public function submitOrder(Donation $donation): ?array
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return ['error' => 'Could not authenticate with Pesapal'];
        }

        $notificationId = config('services.pesapal.notification_id');
        if (!$notificationId) {
            return ['error' => 'Pesapal notification_id (IPN) is not configured'];
        }

        $callbackUrl = route('donate.pesapal.callback');

        $payload = [
            'id' => $donation->merchant_reference,
            'currency' => $donation->currency ?: 'TZS',
            'amount' => (float) $donation->amount,
            'description' => 'Donation to Salama Children\'s Home' . ($donation->campaign ? ' – ' . $donation->campaign : ''),
            'callback_url' => $callbackUrl,
            'notification_id' => $notificationId,
            'billing_address' => [
                'email_address' => $donation->donor_email ?: 'info@salamachildrens.or.tz',
                'phone_number' => $donation->donor_phone ?: '',
                'country_code' => 'TZ',
                'first_name' => explode(' ', $donation->donor_name)[0] ?? $donation->donor_name,
                'middle_name' => '',
                'last_name' => count(explode(' ', $donation->donor_name)) > 1
                    ? implode(' ', array_slice(explode(' ', $donation->donor_name), 1))
                    : '',
                'line_1' => '',
                'line_2' => '',
                'city' => 'Bagamoyo',
                'state' => '',
                'postal_code' => '',
                'zip_code' => '',
            ],
        ];

        $response = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->post($this->baseUrl . '/api/Transactions/SubmitOrderRequest', $payload);

        if (!$response->successful()) {
            Log::error('Pesapal SubmitOrder failed', ['body' => $response->body(), 'payload' => $payload]);
            return ['error' => 'Payment initiation failed', 'details' => $response->json()];
        }

        $data = $response->json();

        $donation->update([
            'pesapal_tracking_id' => $data['order_tracking_id'] ?? null,
            'pesapal_response' => $data,
            'payment_method' => 'pesapal',
            'status' => 'pending',
            'pesapal_status' => 'PENDING',
        ]);

        return $data; // contains redirect_url and order_tracking_id
    }

    /**
     * Query transaction status from Pesapal.
     */
    public function getTransactionStatus(string $orderTrackingId): ?array
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        $response = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->get($this->baseUrl . '/api/Transactions/GetTransactionStatus', [
                'orderTrackingId' => $orderTrackingId,
            ]);

        if (!$response->successful()) {
            Log::error('Pesapal GetTransactionStatus failed', ['body' => $response->body()]);
            return null;
        }

        return $response->json();
    }

    /**
     * Update local donation from Pesapal status response.
     */
    public function syncDonationStatus(Donation $donation): Donation
    {
        if (!$donation->pesapal_tracking_id) {
            return $donation;
        }

        $status = $this->getTransactionStatus($donation->pesapal_tracking_id);
        if (!$status) {
            return $donation;
        }

        $paymentStatus = $status['payment_status_description']
            ?? $status['status_code']
            ?? null;

        // Map common Pesapal statuses
        $map = [
            'Completed' => 'completed',
            'COMPLETED' => 'completed',
            'Failed' => 'failed',
            'FAILED' => 'failed',
            'Invalid' => 'failed',
            'INVALID' => 'failed',
            'Pending' => 'pending',
            'PENDING' => 'pending',
        ];

        $localStatus = $map[$paymentStatus] ?? $donation->status;

        $donation->update([
            'pesapal_status' => is_string($paymentStatus) ? strtoupper($paymentStatus) : $donation->pesapal_status,
            'status' => $localStatus,
            'transaction_reference' => $status['confirmation_code'] ?? $donation->transaction_reference,
            'pesapal_response' => array_merge($donation->pesapal_response ?? [], ['status_check' => $status]),
            'paid_at' => $localStatus === 'completed' ? now() : $donation->paid_at,
        ]);

        return $donation->fresh();
    }
}
