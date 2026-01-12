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
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->string('jenis_kelamin')->nullable()->after('gelar');
            }
            if (!Schema::hasColumn('users', 'pangkat')) {
                $table->string('pangkat')->nullable()->after('jabatan');
            }
            if (!Schema::hasColumn('users', 'golongan')) {
                $table->string('golongan')->nullable()->after('pangkat');
            }
            if (!Schema::hasColumn('users', 'nip_nipy')) {
                $table->string('nip_nipy')->nullable()->after('nip');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }
            if (Schema::hasColumn('users', 'pangkat')) {
                $table->dropColumn('pangkat');
            }
            if (Schema::hasColumn('users', 'golongan')) {
                $table->dropColumn('golongan');
            }
            if (Schema::hasColumn('users', 'nip_nipy')) {
                $table->dropColumn('nip_nipy');
            }
        });
    }
};
