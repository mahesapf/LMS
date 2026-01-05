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
        Schema::create('document_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('document_name');
            $table->string('document_type')->nullable(); // pdf, doc, image, etc
            $table->text('description')->nullable();
            $table->boolean('is_required')->default(true);
            $table->integer('max_file_size')->default(5120); // in KB, default 5MB
            $table->timestamps();
        });

        // Update documents table to link with requirements
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('document_requirement_id')->nullable()->after('class_id')->constrained('document_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['document_requirement_id']);
            $table->dropColumn('document_requirement_id');
        });
        
        Schema::dropIfExists('document_requirements');
    }
};
