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
            $table->enum('role', ['super_admin', 'admin', 'fasilitator', 'peserta'])->default('peserta')->after('email');
            $table->string('phone')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->string('institution')->nullable()->after('address');
            $table->string('position')->nullable()->after('institution');
            $table->string('degree')->nullable()->after('name'); // gelar
            $table->enum('status', ['active', 'suspended', 'inactive'])->default('active')->after('password');
            $table->softDeletes();
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
