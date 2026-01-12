<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Add email_belajar_id column if not exists
    if (!Schema::hasColumn('users', 'email_belajar_id')) {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email_belajar_id')->unique()->nullable()->after('email');
        });
        echo "✓ Added 'email_belajar_id' column to users table\n";
    } else {
        echo "✓ Column 'email_belajar_id' already exists\n";
    }

    echo "\n✅ Database update completed successfully!\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
