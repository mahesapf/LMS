<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Add npsn column to users table
    if (!Schema::hasColumn('users', 'npsn')) {
        Schema::table('users', function (Blueprint $table) {
            $table->string('npsn')->unique()->nullable()->after('email');
        });
        echo "✓ Added 'npsn' column to users table\n";
    } else {
        echo "✓ Column 'npsn' already exists\n";
    }

    // Add other school-related columns if they don't exist
    $columns = [
        'nama_sekolah' => function (Blueprint $table) {
            $table->string('nama_sekolah')->nullable()->after('npsn');
        },
        'kepala_sekolah' => function (Blueprint $table) {
            $table->string('kepala_sekolah')->nullable()->after('kabupaten');
        },
        'no_wa' => function (Blueprint $table) {
            $table->string('no_wa')->nullable()->after('kepala_sekolah');
        },
        'jabatan_pendaftar' => function (Blueprint $table) {
            $table->string('jabatan_pendaftar')->nullable()->after('pendaftar');
        },
    ];

    foreach ($columns as $column => $callback) {
        if (!Schema::hasColumn('users', $column)) {
            Schema::table('users', function (Blueprint $table) use ($callback) {
                $callback($table);
            });
            echo "✓ Added '$column' column to users table\n";
        } else {
            echo "✓ Column '$column' already exists\n";
        }
    }

    echo "\n✅ Database update completed successfully!\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
