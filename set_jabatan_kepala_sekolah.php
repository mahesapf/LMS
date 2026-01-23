<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATE JABATAN TEACHER PARTICIPANTS KE 'KEPALA SEKOLAH' ===\n\n";

// Update all teacher_participants without jabatan to 'Kepala Sekolah'
$updated = DB::table('teacher_participants')
    ->whereNull('jabatan')
    ->orWhere('jabatan', '')
    ->update(['jabatan' => 'Kepala Sekolah']);

echo "✓ Updated $updated teacher_participants dengan jabatan 'Kepala Sekolah'\n\n";

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

echo "\nDone! Refresh halaman untuk melihat perubahan.\n";
