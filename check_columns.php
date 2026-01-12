<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;

try {
    echo "Columns in 'users' table:\n";
    echo "===============================================\n";
    
    $columns = Schema::getColumnListing('users');
    
    $requiredColumns = [
        'npsn',
        'nama_sekolah',
        'provinsi',
        'kabupaten',
        'nama_kepala_sekolah',
        'email_belajar_id',
        'no_wa',
        'pendaftar',
        'jabatan_pendaftar',
        'sk_pendaftar',
        'approval_status',
        'status',
        'role'
    ];
    
    foreach ($requiredColumns as $col) {
        $exists = in_array($col, $columns);
        echo ($exists ? "✓" : "✗") . " $col\n";
    }
    
    echo "\nAll columns:\n";
    print_r($columns);

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
