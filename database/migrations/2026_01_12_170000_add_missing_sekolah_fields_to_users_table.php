<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Field yang missing
            $table->string('nama_kepala_sekolah')->nullable()->after('nama_sekolah');
            $table->string('email_belajar_sekolah')->nullable()->unique()->after('email_belajar_id');
            $table->string('kabupaten_kota')->nullable()->after('kabupaten');
            $table->string('nama_pendaftar')->nullable()->after('pendaftar');
            $table->string('sk_pendaftar_path')->nullable()->after('sk_pendaftar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nama_kepala_sekolah',
                'email_belajar_sekolah',
                'kabupaten_kota',
                'nama_pendaftar',
                'sk_pendaftar_path'
            ]);
        });
    }
};
