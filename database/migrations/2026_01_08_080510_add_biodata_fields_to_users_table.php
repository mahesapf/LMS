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
            // Email belajar.id
            $table->string('email_belajar_id')->nullable()->after('email');
            
            // Gelar dan Jabatan
            $table->string('gelar')->nullable()->after('name');
            $table->string('jabatan')->nullable()->after('gelar');
            
            // Nomor HP
            $table->string('no_hp')->nullable()->after('phone');
            
            // NIP/NIPY
            $table->string('nip_nipy')->nullable()->after('nik');
            
            // NPSN dan Instansi
            $table->string('npsn')->nullable()->after('nip_nipy');
            $table->string('instansi')->nullable()->after('npsn');
            $table->text('alamat_sekolah')->nullable()->after('instansi');
            
            // Jenis Kelamin
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('alamat_sekolah');
            
            // Alamat Lengkap
            $table->string('kabupaten_kota')->nullable()->after('jenis_kelamin');
            $table->string('provinsi_peserta')->nullable()->after('kabupaten_kota');
            $table->text('alamat_lengkap')->nullable()->after('provinsi_peserta');
            $table->string('kcd')->nullable()->after('alamat_lengkap');
            
            // Kepegawaian
            $table->string('pangkat')->nullable()->after('kcd');
            $table->string('golongan')->nullable()->after('pangkat');
            
            // Pendidikan
            $table->string('pendidikan_terakhir')->nullable()->after('golongan');
            $table->string('jurusan')->nullable()->after('pendidikan_terakhir');
            
            // Upload Files
            $table->string('foto_3x4')->nullable()->after('jurusan');
            $table->string('surat_tugas')->nullable()->after('foto_3x4');
            $table->string('tanda_tangan')->nullable()->after('surat_tugas');
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
