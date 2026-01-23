<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== LINKING CEPI TO REGISTRATION ===\n\n";

// Find cepi user
$cepiUser = App\Models\User::where('email', 'cepi@gmail.com')->first();

if (!$cepiUser) {
    echo "Cepi user not found!\n";
    exit;
}

echo "Cepi User:\n";
echo "ID: " . $cepiUser->id . "\n";
echo "Email: " . $cepiUser->email . "\n";
echo "NIK: " . ($cepiUser->nik ?? 'NULL') . "\n\n";

// Find registrations with cepi as kepala sekolah without user_id
$registrations = App\Models\Registration::where('nama_kepala_sekolah', 'like', '%cepi%')
    ->whereNull('kepala_sekolah_user_id')
    ->get();

echo "Registrations to link:\n";
foreach ($registrations as $reg) {
    echo "Registration ID: " . $reg->id . " | Sekolah: " . $reg->nama_sekolah . "\n";

    // Link to user
    $reg->update(['kepala_sekolah_user_id' => $cepiUser->id]);
    echo "✓ Linked to user ID " . $cepiUser->id . "\n";
}

echo "\n=== VERIFICATION ===\n\n";

$linkedRegs = App\Models\Registration::where('kepala_sekolah_user_id', $cepiUser->id)->get();

foreach ($linkedRegs as $reg) {
    echo "Registration ID: " . $reg->id . "\n";
    echo "Sekolah: " . $reg->nama_sekolah . "\n";
    echo "Kepala Sekolah: " . $reg->nama_kepala_sekolah . "\n";
    echo "kepala_sekolah_user_id: " . $reg->kepala_sekolah_user_id . "\n";
    echo "Email from User: " . App\Models\User::find($reg->kepala_sekolah_user_id)->email . "\n";
    echo str_repeat("-", 80) . "\n";
}
