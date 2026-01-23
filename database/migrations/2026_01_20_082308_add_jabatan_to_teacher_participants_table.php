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
            if (!Schema::hasColumn('teacher_participants', 'jabatan')) {
                $table->string('jabatan', 50)->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_participants', function (Blueprint $table) {
            if (Schema::hasColumn('teacher_participants', 'jabatan')) {
                $table->dropColumn('jabatan');
            }
        });
    }
};
