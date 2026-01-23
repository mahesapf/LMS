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
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['super_admin', 'admin', 'fasilitator', 'peserta'])->default('peserta')->after('email');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'institution')) {
                $table->string('institution')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'position')) {
                $table->string('position')->nullable()->after('institution');
            }
            if (!Schema::hasColumn('users', 'degree')) {
                $table->string('degree')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['active', 'suspended', 'inactive'])->default('active')->after('password');
            }
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'address', 'institution', 'position', 'degree', 'status']);
            $table->dropSoftDeletes();
        });
    }
};
