<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING ALL REGISTRATIONS ===\n\n";

$allRegs = App\Models\Registration::all();
echo "Total registrations: " . $allRegs->count() . "\n\n";

$statuses = ['validated', 'payment_uploaded', 'payment_validated', 'approved', 'accepted'];

foreach ($statuses as $status) {
    $count = App\Models\Registration::where('status', $status)->count();
    echo "Status '$status': " . $count . " registrations\n";
}

echo "\n=== REGISTRATIONS WITHOUT CLASS ===\n\n";

$noClass = App\Models\Registration::whereIn('status', $statuses)
    ->whereNull('class_id')
    ->get();

echo "Registrations without class (validated+): " . $noClass->count() . "\n\n";

foreach ($noClass as $reg) {
    echo str_repeat("-", 80) . "\n";
    echo "ID: " . $reg->id . "\n";
    echo "Nama Sekolah: " . $reg->nama_sekolah . "\n";
    echo "Email: " . $reg->email . "\n";
    echo "Status: " . $reg->status . "\n";
    echo "Activity ID: " . $reg->activity_id . "\n";
    echo "Provinsi: " . ($reg->provinsi ?? 'NULL') . "\n";
    echo "Kab/Kota: " . ($reg->kab_kota ?? 'NULL') . "\n";
    echo "Kecamatan: " . ($reg->kecamatan ?? 'NULL') . "\n";
    echo "Kepala Sekolah: " . $reg->jumlah_kepala_sekolah . ", Guru: " . $reg->jumlah_guru . "\n";
}

echo "\n=== ALL REGISTRATIONS (FIRST 10) ===\n\n";

$first10 = App\Models\Registration::take(10)->get();

foreach ($first10 as $reg) {
    echo "ID: " . $reg->id . " | Sekolah: " . $reg->nama_sekolah . " | Status: " . $reg->status . " | Class: " . ($reg->class_id ?? 'NULL') . "\n";
}
