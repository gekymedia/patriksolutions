<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telegram_chat_id')->nullable()->after('phone');
            $table->boolean('sms_notifications_enabled')->default(true)->after('telegram_chat_id');
            $table->boolean('whatsapp_notifications_enabled')->default(true)->after('sms_notifications_enabled');
            $table->boolean('telegram_notifications_enabled')->default(true)->after('whatsapp_notifications_enabled');
            $table->boolean('gekychat_notifications_enabled')->default(true)->after('telegram_notifications_enabled');
            $table->boolean('email_notifications_enabled')->default(true)->after('gekychat_notifications_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telegram_chat_id',
                'sms_notifications_enabled',
                'whatsapp_notifications_enabled',
                'telegram_notifications_enabled',
                'gekychat_notifications_enabled',
                'email_notifications_enabled',
            ]);
        });
    }
};
