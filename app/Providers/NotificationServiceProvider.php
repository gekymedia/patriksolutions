<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Notifications\Sms\{
    SmsDriverInterface,
    HubtelSmsDriver,
    LogSmsDriver
};
use App\Services\Notifications\WhatsApp\{
    WhatsAppDriverInterface,
    MetaCloudDriver,
    LogWhatsAppDriver
};
use App\Services\Notifications\Telegram\{
    TelegramDriverInterface,
    TelegramBotDriver,
    LogTelegramDriver
};
use App\Services\Notifications\GekyChat\{
    GekyChatDriverInterface,
    GekyChatApiDriver,
    LogGekyChatDriver
};
use App\Services\Notifications\Email\{
    EmailDriverInterface,
    LaravelMailDriver,
    LogEmailDriver
};

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // SMS Driver
        $this->app->bind(SmsDriverInterface::class, function () {
            $driver = config('notifications.sms');
            
            if ($driver) {
                return match ($driver) {
                    'hubtel' => new HubtelSmsDriver(),
                    default => new LogSmsDriver(),
                };
            }
            
            // Auto-detect: Check for Hubtel credentials
            if (env('HUBTEL_CLIENT_ID') && env('HUBTEL_CLIENT_SECRET')) {
                return new HubtelSmsDriver();
            }
            
            // Fallback to log driver
            return new LogSmsDriver();
        });

        // WhatsApp Driver
        $this->app->bind(WhatsAppDriverInterface::class, function () {
            return match (config('notifications.whatsapp')) {
                'meta' => new MetaCloudDriver(),
                default => new LogWhatsAppDriver(),
            };
        });

        // Telegram Driver
        $this->app->bind(TelegramDriverInterface::class, function () {
            return match (config('notifications.telegram.driver', 'log')) {
                'telegram' => new TelegramBotDriver(),
                default => new LogTelegramDriver(),
            };
        });

        // GekyChat Driver
        $this->app->bind(GekyChatDriverInterface::class, function () {
            return match (config('notifications.gekychat.driver', 'log')) {
                'api' => new GekyChatApiDriver(),
                default => new LogGekyChatDriver(),
            };
        });

        // Email Driver
        $this->app->bind(EmailDriverInterface::class, function () {
            return match (config('notifications.email.driver', 'log')) {
                'mail' => new LaravelMailDriver(),
                default => new LogEmailDriver(),
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

