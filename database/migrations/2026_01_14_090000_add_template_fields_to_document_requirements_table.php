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
        Schema::table('document_requirements', function (Blueprint $table) {
            if (!Schema::hasColumn('document_requirements', 'template_file_path')) {
                $table->string('template_file_path')->nullable()->after('max_file_size');
            }

            if (!Schema::hasColumn('document_requirements', 'template_file_name')) {
                $table->string('template_file_name')->nullable()->after('template_file_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_requirements', function (Blueprint $table) {
            if (Schema::hasColumn('document_requirements', 'template_file_name')) {
                $table->dropColumn('template_file_name');
            }

            if (Schema::hasColumn('document_requirements', 'template_file_path')) {
                $table->dropColumn('template_file_path');
            }
        });
    }
};
