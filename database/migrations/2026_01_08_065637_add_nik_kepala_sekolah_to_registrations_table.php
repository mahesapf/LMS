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
        Schema::table('registrations', function (Blueprint $table) {
            // Add NIK field for kepala sekolah
            $table->string('nik_kepala_sekolah', 16)->nullable()->after('nama_kepala_sekolah');
            
            // Make nomor_telp nullable (no longer required for kepala sekolah)
            $table->string('nomor_telp')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('nik_kepala_sekolah');
        });
    }
};
