<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$email = 'yazdi.prayogi36@smk.belajar.id';

echo "Checking for email: $email\n\n";

// Check in users table
$user = App\Models\User::withTrashed()->where('email', $email)->first();

if ($user) {
    echo "FOUND IN USERS TABLE:\n";
    echo "ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Status: " . $user->status . "\n";
    echo "Deleted: " . ($user->deleted_at ? "YES (at " . $user->deleted_at . ")" : "NO") . "\n";
} else {
    echo "NOT FOUND in users table\n";
}

echo "\n";

// Check in registrations table
$registration = App\Models\Registration::where('email', $email)->first();
if ($registration) {
    echo "FOUND IN REGISTRATIONS TABLE:\n";
    echo "ID: " . $registration->id . "\n";
    echo "Email: " . $registration->email . "\n";
    echo "Nama Sekolah: " . $registration->nama_sekolah . "\n";
    echo "Status: " . $registration->status . "\n";
} else {
    echo "NOT FOUND in registrations table\n";
}
