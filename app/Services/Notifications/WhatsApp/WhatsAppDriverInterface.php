<?php

namespace App\Services\Notifications\WhatsApp;

interface WhatsAppDriverInterface
{
    /**
     * Send a WhatsApp text message.
     *
     * @param string $toE164 Phone number in E.164 format (e.g., +233241234567)
     * @param string $message Message content
     * @return array ['success' => bool, 'message' => string, ...]
     */
    public function sendText(string $toE164, string $message): array;
}

