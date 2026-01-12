<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

try {
    echo "Total users: " . User::count() . "\n";
    echo "Sekolah users: " . User::where('role', 'sekolah')->count() . "\n\n";
    
    $sekolah = User::where('role', 'sekolah')->get();
    
    if ($sekolah->count() > 0) {
        echo "Data Sekolah:\n";
        echo "===============================================\n";
        foreach ($sekolah as $s) {
            echo "ID: " . $s->id . "\n";
            echo "Nama Sekolah: " . $s->nama_sekolah . "\n";
            echo "NPSN: " . $s->npsn . "\n";
            echo "Email: " . $s->email_belajar_id . "\n";
            echo "Approval Status: " . ($s->approval_status ?? 'NULL') . "\n";
            echo "Status: " . ($s->status ?? 'NULL') . "\n";
            echo "-----------------------------------------------\n";
        }
    } else {
        echo "❌ Tidak ada data sekolah ditemukan!\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
