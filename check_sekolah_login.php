<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING SEKOLAH LOGIN STATUS ===\n\n";

// Check NPSN 11111
$sekolah = App\Models\User::where('role', 'sekolah')->where('npsn', '11111')->first();

if ($sekolah) {
    echo "Found sekolah account:\n";
    echo "ID: " . $sekolah->id . "\n";
    echo "Name: " . $sekolah->name . "\n";
    echo "NPSN: " . $sekolah->npsn . "\n";
    echo "Email: " . $sekolah->email . "\n";
    echo "Status: " . $sekolah->status . "\n";
    echo "Role: " . $sekolah->role . "\n";

    // Check if password works
    echo "\n=== TESTING PASSWORD ===\n";
    if (Hash::check('11111', $sekolah->password)) {
        echo "✓ Password '11111' (NPSN) works!\n";
    } else {
        echo "✗ Password '11111' (NPSN) DOES NOT work\n";
        echo "Password hash: " . substr($sekolah->password, 0, 50) . "...\n";
    }

} else {
    echo "No sekolah account found with NPSN 11111\n";

    echo "\n=== ALL SEKOLAH ACCOUNTS ===\n";
    $all = App\Models\User::where('role', 'sekolah')->get();
    foreach ($all as $s) {
        echo "ID: " . $s->id . " | NPSN: " . ($s->npsn ?? 'NULL') . " | Email: " . $s->email . " | Status: " . $s->status . "\n";
    }
}
