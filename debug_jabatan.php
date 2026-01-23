<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUGGING JABATAN ISSUE - CLASS ID 4 ===\n\n";

$classId = 4;
$registrations = App\Models\Registration::with(['teacherParticipants'])
    ->where('class_id', $classId)
    ->get();

echo "Total registrations in class: " . $registrations->count() . "\n\n";

foreach ($registrations as $reg) {
    echo "Registration ID: {$reg->id} | Sekolah: {$reg->nama_sekolah}\n";
    echo "Teacher Participants: " . $reg->teacherParticipants->count() . "\n";

    foreach ($reg->teacherParticipants as $teacher) {
        echo "  - Teacher: {$teacher->nama_lengkap}\n";
        echo "    teacher_participants.jabatan: " . ($teacher->jabatan ?? 'NULL') . "\n";
        echo "    user_id: " . ($teacher->user_id ?? 'NULL') . "\n";

        if ($teacher->user_id) {
            $user = App\Models\User::find($teacher->user_id);
            if ($user) {
                echo "    User found:\n";
                echo "      position_type: " . ($user->position_type ?? 'NULL') . "\n";
                echo "      jabatan: " . ($user->jabatan ?? 'NULL') . "\n";
                echo "      role: " . $user->role . "\n";
            } else {
                echo "    User NOT found in database!\n";
            }
        } else {
            echo "    No user_id linked\n";
        }
        echo "\n";
    }
    echo "---\n\n";
}
