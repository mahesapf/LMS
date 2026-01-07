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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('name'); // e.g., "Tahap 1", "Tahap 2"
            $table->text('description')->nullable();
            $table->integer('order')->default(0); // Urutan tahap
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['not_started', 'ongoing', 'completed'])->default('not_started');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
