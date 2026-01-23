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
        if (Schema::hasTable('registrations') && !Schema::hasColumn('registrations', 'surat_tugas_kepala_sekolah')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('surat_tugas_kepala_sekolah')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('surat_tugas_kepala_sekolah');
        });
    }
};
