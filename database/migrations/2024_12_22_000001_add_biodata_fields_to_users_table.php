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
            if (!Schema::hasColumn('users', 'npsn')) {
                $table->string('npsn')->nullable()->after('degree'); // NPSN
            }
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->nullable()->after('npsn'); // Nomor Induk Pegawai
            }
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik')->nullable()->after('nip'); // Nomor Induk Kependudukan
            }
            if (!Schema::hasColumn('users', 'birth_place')) {
                $table->string('birth_place')->nullable()->after('nik'); // Tempat Lahir
            }
            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('birth_place'); // Tanggal Lahir
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['L', 'P'])->nullable()->after('birth_date'); // Jenis Kelamin (L=Laki-laki, P=Perempuan)
            }
            if (!Schema::hasColumn('users', 'pns_status')) {
                $table->enum('pns_status', ['PNS', 'Non PNS'])->nullable()->after('gender'); // PNS/Non PNS
            }
            if (!Schema::hasColumn('users', 'rank')) {
                $table->string('rank')->nullable()->after('pns_status'); // Pangkat (if PNS)
            }
            if (!Schema::hasColumn('users', 'group')) {
                $table->string('group')->nullable()->after('rank'); // Golongan (if PNS)
            }
            if (!Schema::hasColumn('users', 'last_education')) {
                $table->string('last_education')->nullable()->after('group'); // Pendidikan Terakhir
            }
            if (!Schema::hasColumn('users', 'major')) {
                $table->string('major')->nullable()->after('last_education'); // Jurusan
            }
            if (!Schema::hasColumn('users', 'position_type')) {
                $table->enum('position_type', ['Guru', 'Kepala Sekolah', 'Lainnya'])->nullable()->after('position'); // Tipe Jabatan
            }
            if (!Schema::hasColumn('users', 'email_belajar')) {
                $table->string('email_belajar')->nullable()->after('email'); // Email belajar.id
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('email_belajar'); // Foto
            }
            if (!Schema::hasColumn('users', 'digital_signature')) {
                $table->string('digital_signature')->nullable()->after('photo'); // Tanda Tangan Digital
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
                'npsn', 'nip', 'nik', 'birth_place', 'birth_date', 'gender',
                'pns_status', 'rank', 'group', 'last_education', 'major',
                'position_type', 'email_belajar', 'photo', 'digital_signature'
            ]);
        });
    }
};
