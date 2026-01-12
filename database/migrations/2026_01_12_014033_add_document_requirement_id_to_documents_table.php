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
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('document_requirement_id')->nullable()->after('class_id')->constrained('document_requirements')->onDelete('cascade');
            $table->unsignedBigInteger('file_size')->nullable()->after('file_name');
            $table->foreignId('uploaded_by')->nullable()->after('uploaded_date')->constrained('users')->onDelete('set null');
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
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['file_size', 'uploaded_by']);
        });
    }
};
