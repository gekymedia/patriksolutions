<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add plan column to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('plan')->default('free')->after('email');
        });

        // Laravel Cashier migrations (run: php artisan cashier:install)
        // This creates: subscriptions, subscription_items tables
        // Run after: php artisan migrate
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('plan');
        });
    }
};
