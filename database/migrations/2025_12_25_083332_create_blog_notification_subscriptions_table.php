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
        Schema::create('blog_notification_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('endpoint')->nullable(); // For Pusher, this is optional
            $table->string('public_key')->nullable(); // Not needed for Pusher but kept for compatibility
            $table->string('auth_token')->nullable(); // Not needed for Pusher but kept for compatibility
            $table->string('browser')->nullable(); // Browser name
            $table->string('device')->nullable(); // Device type
            $table->string('ip_address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('subscribed_at')->useCurrent();
            $table->timestamp('last_notified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_notification_subscriptions');
    }
};
