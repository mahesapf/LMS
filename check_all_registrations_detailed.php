<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING ALL REGISTRATIONS ===\n\n";

$registrations = App\Models\Registration::all();

foreach ($registrations as $reg) {
    echo str_repeat("=", 80) . "\n";
    echo "Registration ID: " . $reg->id . "\n";
    echo "Nama Sekolah: " . $reg->nama_sekolah . "\n";
    echo "Email Sekolah: " . $reg->email . "\n\n";

    echo "KEPALA SEKOLAH:\n";
    echo "- Nama: " . ($reg->nama_kepala_sekolah ?? 'NULL') . "\n";
    echo "- NIK: " . ($reg->nik_kepala_sekolah ?? 'NULL') . "\n";
    echo "- Jumlah: " . $reg->jumlah_kepala_sekolah . "\n";
    echo "- User ID: " . ($reg->kepala_sekolah_user_id ?? 'NULL') . "\n";

    if ($reg->kepala_sekolah_user_id) {
        $user = App\Models\User::find($reg->kepala_sekolah_user_id);
        if ($user) {
            echo "- Email (from User): " . $user->email . "\n";
        }
    }

    echo "\nGURU (Teacher Participants):\n";
    $teachers = App\Models\TeacherParticipant::where('registration_id', $reg->id)->get();
    if ($teachers->count() > 0) {
        foreach ($teachers as $teacher) {
            echo "  - " . $teacher->nama_lengkap . " | Email: " . ($teacher->email ?? 'NULL') . "\n";
        }
    } else {
        echo "  (no teachers)\n";
    }
}
