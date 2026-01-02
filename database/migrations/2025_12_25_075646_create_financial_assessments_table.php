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
        Schema::create('financial_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('email')->nullable();
            $table->json('answers'); // Store all assessment answers
            $table->string('current_stage')->nullable(); // e.g., 'debt_payoff', 'building_emergency_fund', 'investing'
            $table->string('recommended_milestone')->nullable(); // Which milestone they should focus on
            $table->text('personalized_plan')->nullable(); // Generated plan based on answers
            $table->integer('score')->nullable(); // Overall financial health score
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_assessments');
    }
};
