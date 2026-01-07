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
        // Remove from programs
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['financing_type', 'apbn_type', 'registration_fee']);
        });

        // Add to activities
        Schema::table('activities', function (Blueprint $table) {
            $table->enum('financing_type', ['APBN', 'Non-APBN'])->nullable()->after('description');
            $table->enum('apbn_type', ['BOS Reguler', 'BOS Kinerja', 'DIPA'])->nullable()->after('financing_type');
            $table->decimal('registration_fee', 10, 2)->default(0)->after('apbn_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back to programs
        Schema::table('programs', function (Blueprint $table) {
            $table->enum('financing_type', ['APBN', 'Non-APBN'])->nullable()->after('description');
            $table->enum('apbn_type', ['BOS Reguler', 'BOS Kinerja', 'DIPA'])->nullable()->after('financing_type');
            $table->decimal('registration_fee', 10, 2)->default(0)->after('apbn_type');
        });

        // Remove from activities
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['financing_type', 'apbn_type', 'registration_fee']);
        });
    }
};
