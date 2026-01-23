<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING ROLE SEKOLAH IN DATABASE ===\n\n";

// Check total users with role sekolah
$sekolahUsers = App\Models\User::where('role', 'sekolah')->get();

echo "Total users with role 'sekolah': " . $sekolahUsers->count() . "\n\n";

if ($sekolahUsers->count() > 0) {
    echo "LIST OF SEKOLAH USERS:\n";
    echo str_repeat("-", 80) . "\n";
    foreach ($sekolahUsers as $user) {
        echo "ID: " . $user->id . "\n";
        echo "Name: " . $user->name . "\n";
        echo "Email: " . $user->email . "\n";
        echo "Role: " . $user->role . "\n";
        echo "Status: " . $user->status . "\n";
        echo "NPSN: " . ($user->npsn ?? 'N/A') . "\n";
        echo str_repeat("-", 80) . "\n";
    }
} else {
    echo "No users found with role 'sekolah'\n";
}

echo "\n=== CHECKING USERS TABLE STRUCTURE ===\n\n";

// Check column role type
$result = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'");
if (count($result) > 0) {
    $column = $result[0];
    echo "Column Name: " . $column->Field . "\n";
    echo "Column Type: " . $column->Type . "\n";
    echo "Default: " . ($column->Default ?? 'NULL') . "\n";
} else {
    echo "Column 'role' not found in users table!\n";
}

echo "\n=== ALL ROLES IN DATABASE ===\n\n";
$roles = App\Models\User::select('role', DB::raw('count(*) as total'))
    ->groupBy('role')
    ->get();

foreach ($roles as $role) {
    echo $role->role . ": " . $role->total . " users\n";
}
