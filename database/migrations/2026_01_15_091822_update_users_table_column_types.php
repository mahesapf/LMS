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
        Schema::table('users', function (Blueprint $table) {
            // Data Identitas Pribadi
            $table->string('name', 50)->change();
            $table->string('email', 50)->change(); // Remove unique() karena sudah ada
            $table->string('email_belajar', 50)->nullable()->change();
            $table->char('npsn', 8)->nullable()->change();
            $table->char('nip', 18)->nullable()->change();
            $table->char('nik', 16)->nullable()->change();
            $table->string('birth_place', 50)->nullable()->change();
            $table->date('birth_date')->nullable()->change();
        });

        // Update gender column to ENUM
        DB::statement("ALTER TABLE users MODIFY gender ENUM('L','P') NULL");

        Schema::table('users', function (Blueprint $table) {
            // Data Kepegawaian
            $table->string('rank', 50)->nullable()->change();
            $table->string('group', 10)->nullable()->change();
            $table->string('position', 100)->nullable()->change();
            $table->string('institution', 50)->nullable()->change();
        });

        // Update ENUM columns
        DB::statement("ALTER TABLE users MODIFY pns_status ENUM('PNS','Non PNS') NULL");
        DB::statement("ALTER TABLE users MODIFY position_type ENUM('Guru','Kepala Sekolah','Lainnya') NULL");
        DB::statement("ALTER TABLE users MODIFY last_education ENUM('SMA/SMK','D3','S1','S2','S3') NULL");

        Schema::table('users', function (Blueprint $table) {
            // Data Pendidikan
            $table->string('major', 50)->nullable()->change();

            // Data Kontak
            $table->char('phone', 16)->nullable()->change();
            $table->string('address', 100)->nullable()->change();
            $table->string('province', 50)->nullable()->change();
            $table->string('city', 50)->nullable()->change();
            $table->string('district', 50)->nullable()->change();
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
            $table->string('email', 255)->change();
            $table->string('email_belajar', 255)->nullable()->change();
            $table->string('npsn', 255)->nullable()->change();
            $table->string('nip', 255)->nullable()->change();
            $table->string('nik', 255)->nullable()->change();
            $table->string('birth_place', 255)->nullable()->change();
            $table->string('birth_date', 255)->nullable()->change();
            $table->string('gender', 255)->nullable()->change();
            $table->string('pns_status', 255)->nullable()->change();
            $table->string('rank', 255)->nullable()->change();
            $table->string('group', 255)->nullable()->change();
            $table->string('position_type', 255)->nullable()->change();
            $table->string('position', 255)->nullable()->change();
            $table->string('institution', 255)->nullable()->change();
            $table->string('last_education', 255)->nullable()->change();
            $table->string('major', 255)->nullable()->change();
            $table->string('phone', 255)->nullable()->change();
            $table->string('address', 255)->nullable()->change();
            $table->string('province', 255)->nullable()->change();
            $table->string('city', 255)->nullable()->change();
            $table->string('district', 255)->nullable()->change();
        });
    }
};
