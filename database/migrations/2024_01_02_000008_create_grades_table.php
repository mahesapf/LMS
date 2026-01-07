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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('fasilitator_id')->constrained('users')->onDelete('cascade');
            $table->decimal('final_score', 5, 2); // Nilai akhir (0-100)
            $table->string('grade_letter', 2)->nullable(); // A, B+, B, C+, C, D, E
            $table->enum('status', ['lulus', 'tidak_lulus'])->default('lulus');
            $table->text('notes')->nullable(); // Catatan dari fasilitator
            $table->date('graded_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Unique constraint: satu peserta hanya punya satu nilai akhir per kelas
            $table->unique(['participant_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
