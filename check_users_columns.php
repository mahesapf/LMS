<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING USERS TABLE COLUMNS ===\n\n";

$columns = DB::select('SHOW COLUMNS FROM users');

echo "Email-related columns:\n";
foreach ($columns as $col) {
    if (stripos($col->Field, 'email') !== false || stripos($col->Field, 'belajar') !== false) {
        echo "- " . $col->Field . " (" . $col->Type . ")\n";
    }
}

echo "\n\nSekolah-related columns:\n";
foreach ($columns as $col) {
    if (stripos($col->Field, 'sekolah') !== false || stripos($col->Field, 'npsn') !== false) {
        echo "- " . $col->Field . " (" . $col->Type . ")\n";
    }
}
