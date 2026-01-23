<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = DB::table('users')->where('npsn', '11111')->first();

echo "User dengan NPSN 11111:\n";
if ($user) {
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "Status: {$user->status}\n";
    echo "NPSN: {$user->npsn}\n";
} else {
    echo "User tidak ditemukan!\n";
}

echo "\n\nCepi user:\n";
$cepi = DB::table('users')->where('email', 'cepi@gmail.com')->first();
if ($cepi) {
    echo "ID: {$cepi->id}\n";
    echo "Name: {$cepi->name}\n";
    echo "Email: {$cepi->email}\n";
    echo "Role: {$cepi->role}\n";
}
