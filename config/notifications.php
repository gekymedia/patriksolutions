<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SMS Configuration
    |--------------------------------------------------------------------------
    |
    | Driver options: 'hubtel', 'log'
    | 
    | 'hubtel' - Uses Hubtel SMS API (requires HUBTEL_CLIENT_ID & HUBTEL_CLIENT_SECRET)
    | 'log' - Log messages instead of sending (for development)
    */
    'sms' => env('SMS_DRIVER', null),
    
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Configuration
    |--------------------------------------------------------------------------
    |
    | Driver options: 'meta', 'log'
    | 'meta' uses Meta Cloud API (WhatsApp Business)
    */
    'whatsapp' => env('WHATSAPP_DRIVER', 'log'),
    
    /*
    |--------------------------------------------------------------------------
    | Default Country Code
    |--------------------------------------------------------------------------
    |
    | Default country code for phone number formatting (Ghana: 233)
    */
    'default_country_code' => env('DEFAULT_COUNTRY_CODE', '233'),
    
    /*
    |--------------------------------------------------------------------------
    | Telegram Configuration
    |--------------------------------------------------------------------------
    |
    | Driver options: 'telegram', 'log'
    */
    'telegram' => [
        'driver' => env('TELEGRAM_DRIVER', 'log'),
        'bot_token' => env('TELEGRAM_BOT_TOKEN', ''),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | GekyChat Configuration
    |--------------------------------------------------------------------------
    |
    | Driver options: 'api', 'log'
    */
    'gekychat' => [
        'driver' => env('GEKYCHAT_DRIVER', 'log'),
        'api_url' => env('GEKYCHAT_API_URL', ''),
        'api_key' => env('GEKYCHAT_API_KEY', ''),
        'tenant_id' => env('GEKYCHAT_TENANT_ID', ''),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Email Configuration
    |--------------------------------------------------------------------------
    |
    | Driver options: 'mail', 'log'
    */
    'email' => [
        'driver' => env('EMAIL_DRIVER', 'log'),
    ],
];

