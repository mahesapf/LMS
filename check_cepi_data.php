<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING CEPI DATA ===\n\n";

// Check cepi in users
$cepiUser = App\Models\User::where('name', 'like', '%cepi%')->first();

if ($cepiUser) {
    echo "CEPI in USERS table:\n";
    echo "ID: " . $cepiUser->id . "\n";
    echo "Name: " . $cepiUser->name . "\n";
    echo "Email: " . $cepiUser->email . "\n";
    echo "Role: " . $cepiUser->role . "\n";
    echo "\n";
}

// Check registrations with cepi as kepala sekolah
$registrations = App\Models\Registration::where('nama_kepala_sekolah', 'like', '%cepi%')->get();

echo "REGISTRATIONS with cepi as kepala sekolah:\n";
foreach ($registrations as $reg) {
    echo str_repeat("-", 80) . "\n";
    echo "Registration ID: " . $reg->id . "\n";
    echo "Nama Sekolah: " . $reg->nama_sekolah . "\n";
    echo "Nama Kepala Sekolah: " . $reg->nama_kepala_sekolah . "\n";
    echo "NIK Kepala Sekolah: " . ($reg->nik_kepala_sekolah ?? 'NULL') . "\n";
    echo "Kepala Sekolah User ID: " . ($reg->kepala_sekolah_user_id ?? 'NULL') . "\n";
    echo "Class ID: " . ($reg->class_id ?? 'NULL') . "\n";

    if ($reg->kepala_sekolah_user_id) {
        $user = App\Models\User::find($reg->kepala_sekolah_user_id);
        if ($user) {
            echo ">>> User Email (from kepala_sekolah_user_id): " . $user->email . "\n";
        }
    }
}

echo "\n=== CHECKING CLASS 1 DATA ===\n\n";

$class = App\Models\Classes::find(1);
if ($class) {
    $assignedRegistrations = App\Models\Registration::where('activity_id', $class->activity_id)
        ->where('class_id', $class->id)
        ->whereIn('status', ['validated', 'payment_uploaded', 'payment_validated', 'approved', 'accepted', 'belum ditentukan', 'belum_ditentukan'])
        ->get();

    echo "Assigned Registrations to Class 1: " . $assignedRegistrations->count() . "\n\n";

    foreach ($assignedRegistrations as $reg) {
        echo str_repeat("=", 80) . "\n";
        echo "Registration ID: " . $reg->id . "\n";
        echo "Nama Sekolah: " . $reg->nama_sekolah . "\n";

        if ($reg->jumlah_kepala_sekolah > 0 && $reg->nama_kepala_sekolah) {
            echo "\nKepala Sekolah:\n";
            echo "  Nama: " . $reg->nama_kepala_sekolah . "\n";
            echo "  kepala_sekolah_user_id: " . ($reg->kepala_sekolah_user_id ?? 'NULL') . "\n";

            if ($reg->kepala_sekolah_user_id) {
                $kepalaUser = App\Models\User::find($reg->kepala_sekolah_user_id);
                if ($kepalaUser) {
                    echo "  Email from User: " . $kepalaUser->email . "\n";
                } else {
                    echo "  User NOT FOUND\n";
                }
            } else {
                echo "  Email: NO USER LINKED (will show '-')\n";
            }
        }

        $teachers = App\Models\TeacherParticipant::where('registration_id', $reg->id)->get();
        echo "\nGuru/Teachers:\n";
        foreach ($teachers as $t) {
            echo "  - " . $t->nama_lengkap . " | Email: " . ($t->email ?? 'NULL') . "\n";
        }
    }
}
