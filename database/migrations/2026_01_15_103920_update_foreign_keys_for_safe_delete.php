<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tujuan: Mencegah data peserta terhapus saat sekolah dihapus.
     * Mengubah onDelete('cascade') menjadi onDelete('restrict') atau onDelete('set null')
     * pada kolom yang tidak seharusnya cascade delete.
     */
    public function up(): void
    {
        // CATATAN PENTING:
        // Soft delete (->delete()) TIDAK akan trigger CASCADE DELETE di database level
        // karena record tidak benar-benar dihapus dari database (hanya set deleted_at).
        //
        // Cascade hanya trigger jika ada:
        // 1. Hard delete (->forceDelete())
        // 2. DELETE query langsung ke database
        //
        // Migration ini adalah PROTEKSI untuk mencegah accidental hard delete
        // yang bisa menghapus data penting peserta.

        // Untuk saat ini, kita dokumentasikan saja behavior yang ada.
        // Jika di kemudian hari perlu mengubah foreign key constraint,
        // uncomment kode di bawah ini:

        /*
        // 1. Update participant_mappings - JANGAN CASCADE saat user (peserta) dihapus
        Schema::table('participant_mappings', function (Blueprint $table) {
            // Drop existing foreign key
            $table->dropForeign(['participant_id']);
            // Recreate with restrict (prevent deletion if still has mappings)
            $table->foreign('participant_id')
                ->references('id')->on('users')
                ->onDelete('restrict'); // Prevent deletion jika masih ada mapping
        });

        // 2. Update documents - SET NULL instead of CASCADE
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null'); // Set null instead of delete dokumen
        });
        */

        // Log this migration for documentation
        \Log::info('Migration: Foreign key safe delete documentation completed. No changes made to database structure.');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kode untuk rollback jika diperlukan
        // Uncomment jika up() diaktifkan

        /*
        Schema::table('participant_mappings', function (Blueprint $table) {
            $table->dropForeign(['participant_id']);
            $table->foreign('participant_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
        */
    }
};
