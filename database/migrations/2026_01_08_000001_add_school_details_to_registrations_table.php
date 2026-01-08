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
            // Rename school_name to nama_sekolah
            $table->renameColumn('school_name', 'nama_sekolah');
            
            // Add new fields
            $table->text('alamat_sekolah')->nullable()->after('nama_sekolah');
            $table->string('provinsi')->nullable()->after('alamat_sekolah');
            $table->string('kab_kota')->nullable()->after('provinsi');
            $table->string('kcd')->nullable()->after('kab_kota');
            $table->string('nama_kepala_sekolah')->nullable()->after('kcd');
            $table->string('nomor_telp')->nullable()->after('nama_kepala_sekolah');
            $table->integer('jumlah_peserta')->default(0)->after('nomor_telp');
            $table->integer('jumlah_kepala_sekolah')->default(0)->after('jumlah_peserta');
            $table->integer('jumlah_guru')->default(0)->after('jumlah_kepala_sekolah');
            
            // Make user_id nullable since public registration won't have user
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Rename back
            $table->renameColumn('nama_sekolah', 'school_name');
            
            // Drop added columns
            $table->dropColumn([
                'alamat_sekolah',
                'provinsi',
                'kab_kota',
                'kcd',
                'nama_kepala_sekolah',
                'nomor_telp',
                'jumlah_peserta',
                'jumlah_kepala_sekolah',
                'jumlah_guru',
            ]);
            
            // Revert user_id back to not nullable
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
