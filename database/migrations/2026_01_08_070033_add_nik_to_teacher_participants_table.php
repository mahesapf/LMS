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
        Schema::table('teacher_participants', function (Blueprint $table) {
            // Add NIK column for teachers
            $table->string('nik', 16)->nullable()->after('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_participants', function (Blueprint $table) {
            $table->dropColumn('nik');
        });
    }
};
