<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FIX DATA PROFIL SEKOLAH ===\n\n";

// Ambil semua user dengan role sekolah
$sekolahUsers = App\Models\User::where('role', 'sekolah')->get();

echo "Total akun sekolah: " . $sekolahUsers->count() . "\n\n";

$fixed = 0;

foreach ($sekolahUsers as $user) {
    echo "Processing: {$user->email}\n";
    
    $updates = [];
    
    // Copy dari field 'name' ke 'nama_sekolah' jika kosong
    if (empty($user->nama_sekolah) && !empty($user->name)) {
        $updates['nama_sekolah'] = $user->name;
        echo "  - Set nama_sekolah: {$user->name}\n";
    }
    
    // Copy dari field 'province' ke 'provinsi' jika kosong
    if (empty($user->provinsi) && !empty($user->province)) {
        $updates['provinsi'] = $user->province;
        echo "  - Set provinsi: {$user->province}\n";
    }
    
    // Copy dari field 'city' ke 'kabupaten' dan 'kabupaten_kota' jika kosong
    if (empty($user->kabupaten) && !empty($user->city)) {
        $updates['kabupaten'] = $user->city;
        echo "  - Set kabupaten: {$user->city}\n";
    }
    
    if (empty($user->kabupaten_kota) && !empty($user->city)) {
        $updates['kabupaten_kota'] = $user->city;
        echo "  - Set kabupaten_kota: {$user->city}\n";
    }
    
    // Copy dari field 'no_hp' ke 'no_wa' jika kosong
    if (empty($user->no_wa) && !empty($user->no_hp)) {
        $updates['no_wa'] = $user->no_hp;
        echo "  - Set no_wa: {$user->no_hp}\n";
    }
    
    // Copy dari field 'email_belajar' ke 'email_belajar_id' jika kosong
    if (empty($user->email_belajar_id) && !empty($user->email_belajar)) {
        $updates['email_belajar_id'] = $user->email_belajar;
        echo "  - Set email_belajar_id: {$user->email_belajar}\n";
    }
    
    // Copy dari field 'pendaftar' ke 'nama_pendaftar' jika kosong
    if (empty($user->nama_pendaftar) && !empty($user->pendaftar)) {
        $updates['nama_pendaftar'] = $user->pendaftar;
        echo "  - Set nama_pendaftar: {$user->pendaftar}\n";
    }
    
    if (count($updates) > 0) {
        $user->update($updates);
        $fixed++;
        echo "  ✓ Updated {$user->email}\n";
    } else {
        echo "  - No updates needed\n";
    }
    
    echo "\n";
}

echo "\n=== SUMMARY ===\n";
echo "Total sekolah processed: {$sekolahUsers->count()}\n";
echo "Total sekolah fixed: {$fixed}\n";
echo "\nDone!\n";
