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
        if (!Schema::hasTable('registrations')) {
            Schema::create('registrations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('program_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('phone');
                $table->string('email');
                $table->enum('position', ['Kepala Sekolah', 'Guru']);
                $table->string('school_name');
                $table->enum('status', ['pending', 'payment_pending', 'payment_uploaded', 'validated', 'rejected'])->default('pending');
                $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
