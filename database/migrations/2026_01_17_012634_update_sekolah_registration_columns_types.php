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
            // Update nama_sekolah (name column) to 150 characters
            $table->string('name', 150)->change();

            // Update NPSN to char(8)
            $table->char('npsn', 8)->nullable()->change();

            // Update nama_kepala_sekolah if column exists
            if (Schema::hasColumn('users', 'nama_kepala_sekolah')) {
                $table->string('nama_kepala_sekolah', 100)->nullable()->change();
            }

            // Update no_wa (no_hp) to 15 characters
            if (Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp', 15)->nullable()->change();
            }

            // Update alamat_sekolah to text
            if (Schema::hasColumn('users', 'alamat_sekolah')) {
                $table->text('alamat_sekolah')->nullable()->change();
            }

            // Update nama_pendaftar to 100 characters
            if (Schema::hasColumn('users', 'nama_pendaftar')) {
                $table->string('nama_pendaftar', 100)->nullable()->change();
            }

            // Update jabatan to 50 characters
            if (Schema::hasColumn('users', 'jabatan')) {
                $table->string('jabatan', 50)->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert to original types
            $table->string('name', 255)->change();
            $table->string('npsn', 20)->nullable()->change();

            if (Schema::hasColumn('users', 'nama_kepala_sekolah')) {
                $table->string('nama_kepala_sekolah', 255)->nullable()->change();
            }

            if (Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp', 20)->nullable()->change();
            }

            if (Schema::hasColumn('users', 'alamat_sekolah')) {
                $table->text('alamat_sekolah')->nullable()->change();
            }

            if (Schema::hasColumn('users', 'nama_pendaftar')) {
                $table->string('nama_pendaftar', 255)->nullable()->change();
            }

            if (Schema::hasColumn('users', 'jabatan')) {
                $table->string('jabatan', 255)->nullable()->change();
            }
        });
    }
};
