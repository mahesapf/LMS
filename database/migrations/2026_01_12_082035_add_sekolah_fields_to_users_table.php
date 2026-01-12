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
            $table->string('nama_sekolah')->nullable()->after('instansi');
            $table->string('nama_kepala_sekolah')->nullable()->after('nama_sekolah');
            $table->string('email_belajar_sekolah')->nullable()->after('email_belajar');
            $table->string('no_wa')->nullable()->after('phone');
            $table->string('nama_pendaftar')->nullable()->after('name');
            $table->enum('jabatan_pendaftar', ['Wakasek Kurikulum', 'Wakasek Humas Hubin', 'Lainnya'])->nullable()->after('nama_pendaftar');
            $table->string('sk_pendaftar_path')->nullable()->after('jabatan_pendaftar');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            $table->timestamp('approved_at')->nullable()->after('approval_status');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'nama_sekolah',
                'nama_kepala_sekolah',
                'email_belajar_sekolah',
                'no_wa',
                'nama_pendaftar',
                'jabatan_pendaftar',
                'sk_pendaftar_path',
                'approval_status',
                'approved_at',
                'approved_by'
            ]);
        });
    }
};
