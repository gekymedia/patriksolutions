<?php

namespace App\Services\Notifications\GekyChat;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GekyChatApiDriver implements GekyChatDriverInterface
{
    protected string $apiUrl;
    protected string $apiKey;
    protected string $tenantId;

    public function __construct()
    {
        $this->apiUrl = config('notifications.gekychat.api_url', '');
        $this->apiKey = config('notifications.gekychat.api_key', '');
        $this->tenantId = config('notifications.gekychat.tenant_id', '');
    }

    public function send(string $to, string $message): array
    {
        if (empty($this->apiUrl) || empty($this->apiKey)) {
            Log::error('[GEKYCHAT] API credentials not configured');
            return [
                'success' => false,
                'error' => 'GekyChat API credentials not configured',
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->apiUrl}/api/messages/send", [
                'tenant_id' => $this->tenantId,
                'to' => $to,
                'message' => $message,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'GekyChat message sent successfully',
                    'response' => $response->json(),
                ];
            }

            Log::error('[GEKYCHAT] Send failed', ['response' => $response->json()]);
            return [
                'success' => false,
                'error' => $response->json('message', 'Unknown error'),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('[GEKYCHAT] Exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}

