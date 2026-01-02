<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Notifications\Notifier;
use Illuminate\Support\Facades\Log;

class SendNotificationMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public $backoff = [60, 300, 900];

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $channel,
        protected string $to,
        protected string $message,
        protected ?string $subject = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(Notifier $notifier): void
    {
        try {
            $result = match($this->channel) {
                'sms' => $notifier->sms($this->to, $this->message),
                'whatsapp' => $notifier->whatsapp($this->to, $this->message),
                'telegram' => $notifier->telegram($this->to, $this->message),
                'gekychat' => $notifier->gekychat($this->to, $this->message),
                'email' => $notifier->email($this->to, $this->message, $this->subject),
                default => throw new \InvalidArgumentException("Unsupported channel: {$this->channel}"),
            };

            if (!($result['success'] ?? false)) {
                Log::warning("[NOTIFICATION] Failed to send {$this->channel} notification", [
                    'channel' => $this->channel,
                    'to' => $this->to,
                    'error' => $result['error'] ?? 'Unknown error',
                ]);
            }
        } catch (\Exception $e) {
            Log::error("[NOTIFICATION] Exception sending {$this->channel} notification", [
                'channel' => $this->channel,
                'to' => $this->to,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}

