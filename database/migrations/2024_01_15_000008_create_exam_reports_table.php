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
        Schema::create('exam_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained('users')->onDelete('cascade');
            $table->text('attendance_notes')->nullable();
            $table->text('incident_report')->nullable();
            $table->json('statistics')->nullable(); // Present count, absent count, etc.
            $table->datetime('submitted_at')->nullable();
            $table->timestamps();
            
            $table->index(['exam_room_id', 'supervisor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_reports');
    }
};