<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ALL USERS TABLE COLUMNS ===\n\n";

$columns = DB::select('SHOW COLUMNS FROM users');

foreach ($columns as $col) {
    echo $col->Field . " (" . $col->Type . ")";
    if ($col->Default) {
        echo " DEFAULT: " . $col->Default;
    }
    echo "\n";
}
