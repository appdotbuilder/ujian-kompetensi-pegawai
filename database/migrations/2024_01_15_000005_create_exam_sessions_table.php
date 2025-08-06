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
        Schema::create('exam_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_participant_id')->constrained()->onDelete('cascade');
            $table->string('session_token')->unique();
            $table->datetime('started_at')->nullable();
            $table->datetime('ended_at')->nullable();
            $table->json('progress')->nullable(); // Store answered questions and current question
            $table->decimal('score', 5, 2)->nullable();
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'interrupted'])->default('not_started');
            $table->text('interruption_reason')->nullable();
            $table->timestamps();
            
            $table->index(['exam_participant_id', 'status']);
            $table->index(['session_token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_sessions');
    }
};