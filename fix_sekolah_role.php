<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Update user with NPSN 11111 to role sekolah
$updated = DB::table('users')
    ->where('npsn', '11111')
    ->update(['role' => 'sekolah']);

echo "Updated {$updated} user(s) to role 'sekolah'\n";

// Verify
$user = DB::table('users')->where('npsn', '11111')->first();
echo "\nVerifikasi:\n";
echo "Name: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Role: {$user->role}\n";
echo "NPSN: {$user->npsn}\n";
