<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any invalid role values to 'peserta'
        DB::statement("UPDATE users SET role = 'peserta' WHERE role NOT IN ('super_admin', 'admin', 'fasilitator', 'peserta')");

        // Update role enum to include 'sekolah'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'fasilitator', 'peserta', 'sekolah') DEFAULT 'peserta'");

        Schema::table('users', function (Blueprint $table) {
            // Fields for sekolah role - add at the end of the table
            if (!Schema::hasColumn('users', 'provinsi')) {
                $table->string('provinsi')->nullable();
            }
            if (!Schema::hasColumn('users', 'kabupaten')) {
                $table->string('kabupaten')->nullable();
            }
            if (!Schema::hasColumn('users', 'pendaftar')) {
                $table->string('pendaftar')->nullable();
            }
            if (!Schema::hasColumn('users', 'sk_pendaftar')) {
                $table->string('sk_pendaftar')->nullable();
            }
            if (!Schema::hasColumn('users', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
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
                'provinsi',
                'kabupaten',
                'pendaftar',
                'sk_pendaftar',
                'approval_status'
            ]);
        });

        // Revert role enum back
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'fasilitator', 'peserta') DEFAULT 'peserta'");
    }
};
