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
        Schema::create('success_stories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable(); // e.g., "Paid off $50,000 in debt"
            $table->text('story');
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->string('achievement_type')->nullable(); // debt_free, emergency_fund, investing, etc.
            $table->decimal('amount', 15, 2)->nullable(); // Amount saved/paid off
            $table->integer('timeframe_months')->nullable(); // How long it took
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('success_stories');
    }
};
