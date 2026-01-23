<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING REGISTRATIONS TABLE COLUMNS ===\n\n";

$columns = DB::select('SHOW COLUMNS FROM registrations');

echo "Email-related columns:\n";
foreach ($columns as $col) {
    if (stripos($col->Field, 'email') !== false) {
        echo "- " . $col->Field . " (" . $col->Type . ")\n";
    }
}

echo "\n=== CHECKING REGISTRATION DATA ===\n\n";

$reg = App\Models\Registration::first();
if ($reg) {
    echo "Registration ID: " . $reg->id . "\n";
    echo "Nama Sekolah: " . $reg->nama_sekolah . "\n\n";

    echo "EMAILS:\n";
    $attributes = $reg->getAttributes();
    foreach ($attributes as $key => $value) {
        if (stripos($key, 'email') !== false) {
            echo "- " . $key . ": " . ($value ?? 'NULL') . "\n";
        }
    }

    echo "\n\nKepala Sekolah Data:\n";
    foreach ($attributes as $key => $value) {
        if (stripos($key, 'kepala') !== false) {
            echo "- " . $key . ": " . ($value ?? 'NULL') . "\n";
        }
    }
}
