<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING VALIDATION HISTORY ===\n\n";

// Check all registrations
$allRegs = App\Models\Registration::all();
echo "Total registrations in database: " . $allRegs->count() . "\n\n";

foreach ($allRegs as $reg) {
    echo str_repeat("-", 80) . "\n";
    echo "ID: " . $reg->id . "\n";
    echo "Nama Sekolah: " . $reg->nama_sekolah . "\n";
    echo "Email: " . $reg->email . "\n";
    echo "Status: " . $reg->status . "\n";
    echo "NPSN: " . ($reg->npsn ?? 'NULL') . "\n";
    echo "Activity ID: " . $reg->activity_id . "\n";
    echo "Class ID: " . ($reg->class_id ?? 'NULL') . "\n";
    echo "User ID: " . ($reg->user_id ?? 'NULL') . "\n";
    echo "Created: " . $reg->created_at . "\n";
    echo "Updated: " . $reg->updated_at . "\n";
}

echo "\n=== CHECKING USERS TABLE ===\n\n";

$users = App\Models\User::where('role', 'sekolah')->get();
echo "Total sekolah users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo str_repeat("-", 80) . "\n";
    echo "ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "NPSN: " . ($user->npsn ?? 'NULL') . "\n";
    echo "Status: " . $user->status . "\n";
    echo "Created: " . $user->created_at . "\n";
}
