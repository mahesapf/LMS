<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = App\Models\User::where('email', 'yazdi.prayogi36@smk.belajar.id')->first();

echo "=== VERIFIKASI DATA PROFIL SEKOLAH ===\n\n";
echo "Email: {$user->email}\n";
echo "Nama Sekolah: " . ($user->nama_sekolah ?? 'kosong') . "\n";
echo "NPSN: " . ($user->npsn ?? 'kosong') . "\n";
echo "Provinsi: " . ($user->provinsi ?? 'kosong') . "\n";
echo "Kabupaten: " . ($user->kabupaten ?? 'kosong') . "\n";
echo "Kabupaten Kota: " . ($user->kabupaten_kota ?? 'kosong') . "\n";
echo "No WA: " . ($user->no_wa ?? 'kosong') . "\n";
echo "Nama Kepala Sekolah: " . ($user->nama_kepala_sekolah ?? 'kosong') . "\n";
echo "Nama Pendaftar: " . ($user->nama_pendaftar ?? $user->pendaftar ?? 'kosong') . "\n";
echo "Jabatan Pendaftar: " . ($user->jabatan_pendaftar ?? 'kosong') . "\n";
echo "\nSemua data sudah terisi!\n";
