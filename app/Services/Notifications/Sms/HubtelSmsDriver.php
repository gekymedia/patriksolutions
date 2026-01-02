<?php

namespace App\Services\Notifications\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HubtelSmsDriver implements SmsDriverInterface
{
    public function send(string $to, string $message): array
    {
        $clientId = env('HUBTEL_CLIENT_ID');
        $clientSecret = env('HUBTEL_CLIENT_SECRET');
        $from = env('HUBTEL_FROM', 'Patrik Solutions');

        if (!$clientId || !$clientSecret) {
            Log::error('[SMS] Missing Hubtel credentials');
            return [
                'success' => false,
                'error' => 'Missing Hubtel credentials',
            ];
        }

        try {
            $response = Http::withBasicAuth($clientId, $clientSecret)
                ->post('https://smsc.hubtel.com/v1/messages/send', [
                    'From' => $from,
                    'To' => $to,
                    'Content' => $message,
                    'ClientId' => $clientId,
                    'ClientSecret' => $clientSecret,
                    'RegisteredDelivery' => 'true',
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'SMS sent successfully',
                    'response' => $response->json(),
                ];
            }

            Log::error('[SMS] Send failed', ['response' => $response->json()]);
            return [
                'success' => false,
                'error' => $response->json('message', 'Unknown error'),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('[SMS] Exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}

