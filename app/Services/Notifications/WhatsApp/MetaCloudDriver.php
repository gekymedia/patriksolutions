<?php

namespace App\Services\Notifications\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaCloudDriver implements WhatsAppDriverInterface
{
    public function sendText(string $toE164, string $message): array
    {
        $token = env('WA_CLOUD_TOKEN');
        $phoneId = env('WA_CLOUD_PHONE_ID');

        if (!$token || !$phoneId) {
            Log::error('[WHATSAPP] Missing Meta Cloud credentials');
            return [
                'success' => false,
                'error' => 'Missing WhatsApp Cloud API credentials',
            ];
        }

        try {
            $response = Http::withToken($token)
                ->post("https://graph.facebook.com/v20.0/{$phoneId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $toE164,
                    'type' => 'text',
                    'text' => [
                        'body' => $message,
                    ],
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'WhatsApp message sent successfully',
                    'response' => $response->json(),
                ];
            }

            Log::error('[WHATSAPP] Send failed', ['response' => $response->json()]);
            return [
                'success' => false,
                'error' => $response->json('error.message', 'Unknown error'),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('[WHATSAPP] Exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}

