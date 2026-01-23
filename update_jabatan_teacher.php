<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATE JABATAN UNTUK TEACHER PARTICIPANTS ===\n\n";

// Prompt user untuk jabatan default atau spesifik
echo "Opsi 1: Set semua teacher_participants yang belum ada jabatan menjadi 'Kepala Sekolah'\n";
echo "Opsi 2: Set semua teacher_participants yang belum ada jabatan menjadi 'Guru'\n";
echo "Opsi 3: Skip (nanti isi manual)\n\n";

echo "Pilih opsi (1/2/3): ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);
$option = trim($line);

if ($option == '1') {
    $jabatan = 'Kepala Sekolah';
} elseif ($option == '2') {
    $jabatan = 'Guru';
} else {
    echo "Skipped. Silakan isi jabatan secara manual.\n";
    exit;
}

echo "\nApakah Anda yakin ingin mengupdate semua teacher_participants yang belum ada jabatan menjadi '$jabatan'? (y/n): ";
$confirm = trim(fgets($handle));

if (strtolower($confirm) !== 'y') {
    echo "Cancelled.\n";
    exit;
}

// Update all teacher_participants without jabatan
$updated = DB::table('teacher_participants')
    ->whereNull('jabatan')
    ->orWhere('jabatan', '')
    ->update(['jabatan' => $jabatan]);

echo "\n✓ Updated $updated teacher_participants dengan jabatan '$jabatan'\n\n";

echo "Verifikasi untuk class_id 4:\n";
$teachers = DB::table('teacher_participants')
    ->join('registrations', 'teacher_participants.registration_id', '=', 'registrations.id')
    ->where('registrations.class_id', 4)
    ->select('teacher_participants.nama_lengkap', 'teacher_participants.jabatan')
    ->limit(10)
    ->get();

foreach ($teachers as $teacher) {
    echo "  - {$teacher->nama_lengkap}: {$teacher->jabatan}\n";
}

echo "\nDone!\n";
