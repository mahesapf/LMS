<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING TEACHER PARTICIPANTS TABLE ===\n\n";

$columns = DB::select('SHOW COLUMNS FROM teacher_participants');

echo "Email columns in teacher_participants:\n";
foreach ($columns as $col) {
    if (stripos($col->Field, 'email') !== false || stripos($col->Field, 'nama') !== false || stripos($col->Field, 'user') !== false) {
        echo "- " . $col->Field . " (" . $col->Type . ")\n";
    }
}

echo "\n=== CHECKING TEACHER PARTICIPANTS DATA ===\n\n";

$teachers = App\Models\TeacherParticipant::all();
echo "Total teacher participants: " . $teachers->count() . "\n\n";

foreach ($teachers as $teacher) {
    echo "ID: " . $teacher->id . "\n";
    echo "Registration ID: " . $teacher->registration_id . "\n";
    echo "Nama: " . $teacher->nama_lengkap . "\n";

    $attributes = $teacher->getAttributes();
    foreach ($attributes as $key => $value) {
        if (stripos($key, 'email') !== false) {
            echo "Email: " . ($value ?? 'NULL') . "\n";
        }
        if (stripos($key, 'user_id') !== false) {
            echo "User ID: " . ($value ?? 'NULL') . "\n";
        }
    }

    if ($teacher->user_id) {
        $user = App\Models\User::find($teacher->user_id);
        if ($user) {
            echo "User Email (from users table): " . $user->email . "\n";
        }
    }

    echo str_repeat("-", 80) . "\n";
}
