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
            // Biodata Peserta fields
            $table->string('npsn')->nullable()->after('degree'); // NPSN
            $table->string('nip')->nullable()->after('npsn'); // Nomor Induk Pegawai
            $table->string('nik')->nullable()->after('nip'); // Nomor Induk Kependudukan
            $table->string('birth_place')->nullable()->after('nik'); // Tempat Lahir
            $table->date('birth_date')->nullable()->after('birth_place'); // Tanggal Lahir
            $table->enum('gender', ['L', 'P'])->nullable()->after('birth_date'); // Jenis Kelamin (L=Laki-laki, P=Perempuan)
            $table->enum('pns_status', ['PNS', 'Non PNS'])->nullable()->after('gender'); // PNS/Non PNS
            $table->string('rank')->nullable()->after('pns_status'); // Pangkat (if PNS)
            $table->string('group')->nullable()->after('rank'); // Golongan (if PNS)
            $table->string('last_education')->nullable()->after('group'); // Pendidikan Terakhir
            $table->string('major')->nullable()->after('last_education'); // Jurusan
            $table->enum('position_type', ['Guru', 'Kepala Sekolah', 'Lainnya'])->nullable()->after('position'); // Tipe Jabatan
            $table->string('email_belajar')->nullable()->after('email'); // Email belajar.id
            $table->string('photo')->nullable()->after('email_belajar'); // Foto
            $table->string('digital_signature')->nullable()->after('photo'); // Tanda Tangan Digital
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'npsn', 'nip', 'nik', 'birth_place', 'birth_date', 'gender',
                'pns_status', 'rank', 'group', 'last_education', 'major',
                'position_type', 'email_belajar', 'photo', 'digital_signature'
            ]);
        });
    }
};
