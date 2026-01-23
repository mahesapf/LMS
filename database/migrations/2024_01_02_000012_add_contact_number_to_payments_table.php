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
        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'contact_number')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('contact_number')->nullable()->after('proof_file');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('contact_number');
        });
    }
};
