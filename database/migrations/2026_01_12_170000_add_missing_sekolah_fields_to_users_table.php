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
            if (!Schema::hasColumn('users', 'nama_kepala_sekolah')) {
                $table->string('nama_kepala_sekolah')->nullable()->after('nama_sekolah');
            }
            if (!Schema::hasColumn('users', 'email_belajar_sekolah')) {
                $table->string('email_belajar_sekolah')->nullable()->unique()->after('email_belajar_id');
            }
            if (!Schema::hasColumn('users', 'kabupaten_kota')) {
                $table->string('kabupaten_kota')->nullable()->after('kabupaten');
            }
            if (!Schema::hasColumn('users', 'nama_pendaftar')) {
                $table->string('nama_pendaftar')->nullable()->after('pendaftar');
            }
            if (!Schema::hasColumn('users', 'sk_pendaftar_path')) {
                $table->string('sk_pendaftar_path')->nullable()->after('sk_pendaftar');
            }
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
