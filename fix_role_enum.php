<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING ROLE COLUMN ===\n\n";

$result = DB::select('SHOW COLUMNS FROM users WHERE Field = ?', ['role']);

if (count($result) > 0) {
    $column = $result[0];
    echo "Field: " . $column->Field . "\n";
    echo "Type: " . $column->Type . "\n";
    echo "Default: " . ($column->Default ?? 'NULL') . "\n";
} else {
    echo "Role column not found!\n";
}

echo "\n=== FIXING ROLE ENUM ===\n\n";

try {
    DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'fasilitator', 'peserta', 'sekolah') DEFAULT 'peserta'");
    echo "✓ Role ENUM updated successfully!\n";

    // Check again
    $result = DB::select('SHOW COLUMNS FROM users WHERE Field = ?', ['role']);
    if (count($result) > 0) {
        echo "\nNew Type: " . $result[0]->Type . "\n";
    }
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
