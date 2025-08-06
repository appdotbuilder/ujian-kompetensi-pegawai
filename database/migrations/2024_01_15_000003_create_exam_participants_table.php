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
        Schema::create('exam_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_room_id')->constrained()->onDelete('cascade');
            $table->string('participant_number')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('employee_id')->nullable();
            $table->enum('status', ['registered', 'present', 'absent', 'completed'])->default('registered');
            $table->boolean('is_present')->default(false);
            $table->datetime('check_in_time')->nullable();
            $table->timestamps();
            
            $table->index(['exam_id', 'participant_number']);
            $table->index(['exam_room_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_participants');
    }
};