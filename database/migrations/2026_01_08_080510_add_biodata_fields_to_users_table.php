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
        Schema::table('users', function (Blueprint $table) {
            // Skip email_belajar_id if it or email_belajar already exists
            if (!Schema::hasColumn('users', 'email_belajar_id') && !Schema::hasColumn('users', 'email_belajar')) {
                $table->string('email_belajar_id')->nullable();
            }

            // Gelar dan Jabatan
            if (!Schema::hasColumn('users', 'gelar')) {
                $table->string('gelar')->nullable();
            }
            if (!Schema::hasColumn('users', 'jabatan')) {
                $table->string('jabatan')->nullable();
            }

            // Nomor HP
            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp')->nullable();
            }

            // Instansi
            if (!Schema::hasColumn('users', 'instansi')) {
                $table->string('instansi')->nullable();
            }
            if (!Schema::hasColumn('users', 'alamat_sekolah')) {
                $table->text('alamat_sekolah')->nullable();
            }

            // Alamat Lengkap
            if (!Schema::hasColumn('users', 'kabupaten_kota')) {
                $table->string('kabupaten_kota')->nullable();
            }
            if (!Schema::hasColumn('users', 'provinsi_peserta')) {
                $table->string('provinsi_peserta')->nullable();
            }
            if (!Schema::hasColumn('users', 'alamat_lengkap')) {
                $table->text('alamat_lengkap')->nullable();
            }
            if (!Schema::hasColumn('users', 'kcd')) {
                $table->string('kcd')->nullable();
            }

            // Pendidikan
            if (!Schema::hasColumn('users', 'pendidikan_terakhir')) {
                $table->string('pendidikan_terakhir')->nullable();
            }
            if (!Schema::hasColumn('users', 'jurusan')) {
                $table->string('jurusan')->nullable();
            }

            // Upload Files
            if (!Schema::hasColumn('users', 'foto_3x4')) {
                $table->string('foto_3x4')->nullable();
            }
            if (!Schema::hasColumn('users', 'surat_tugas')) {
                $table->string('surat_tugas')->nullable();
            }
            if (!Schema::hasColumn('users', 'tanda_tangan')) {
                $table->string('tanda_tangan')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email_belajar_id',
                'gelar',
                'jabatan',
                'no_hp',
                'nip_nipy',
                'npsn',
                'instansi',
                'alamat_sekolah',
                'jenis_kelamin',
                'kabupaten_kota',
                'provinsi_peserta',
                'alamat_lengkap',
                'kcd',
                'pangkat',
                'golongan',
                'pendidikan_terakhir',
                'jurusan',
                'foto_3x4',
                'surat_tugas',
                'tanda_tangan',
            ]);
        });
    }
};
