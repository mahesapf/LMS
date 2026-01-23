<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING LATEST REGISTRATION ===\n\n";

$reg = App\Models\Registration::latest()->first();

if ($reg) {
    echo "ID: " . $reg->id . "\n";
    echo "Nama Sekolah: " . $reg->nama_sekolah . "\n";
    echo "Email: " . $reg->email . "\n";
    echo "Status: " . $reg->status . "\n";
    echo "NPSN: " . ($reg->npsn ?? 'NULL') . "\n";
    echo "Activity ID: " . $reg->activity_id . "\n";
    echo "Jumlah Kepala Sekolah: " . $reg->jumlah_kepala_sekolah . "\n";
    echo "Jumlah Guru: " . $reg->jumlah_guru . "\n";

    if ($reg->status == 'pending') {
        echo "\n=== VALIDATING REGISTRATION ===\n\n";

        // Update status to validated
        $reg->status = 'validated';
        $reg->save();

        echo "✓ Registration validated!\n";
        echo "New Status: " . $reg->status . "\n";
    } else {
        echo "\nRegistration already validated (status: " . $reg->status . ")\n";
    }
} else {
    echo "No registration found\n";
}
