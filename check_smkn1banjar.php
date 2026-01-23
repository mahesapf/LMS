<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING SMKN 1 BANJAR DATA ===\n\n";

// Check in registrations
$registrations = App\Models\Registration::where('nama_sekolah', 'like', '%banjar%')->get();

echo "REGISTRATIONS with 'banjar' in nama_sekolah: " . $registrations->count() . "\n\n";

foreach ($registrations as $reg) {
    echo str_repeat("-", 80) . "\n";
    echo "ID: " . $reg->id . "\n";
    echo "Nama Sekolah: " . $reg->nama_sekolah . "\n";
    echo "Email: " . $reg->email . "\n";
    echo "Status: " . $reg->status . "\n";
    echo "Activity ID: " . $reg->activity_id . "\n";
    echo "Class ID: " . ($reg->class_id ?? 'NULL (not assigned)') . "\n";
    echo "Provinsi: " . ($reg->provinsi ?? 'NULL') . "\n";
    echo "Kab/Kota: " . ($reg->kab_kota ?? 'NULL') . "\n";
    echo "Kecamatan: " . ($reg->kecamatan ?? 'NULL') . "\n";
    echo "Jumlah Kepala Sekolah: " . $reg->jumlah_kepala_sekolah . "\n";
    echo "Jumlah Guru: " . $reg->jumlah_guru . "\n";
    echo "User ID: " . ($reg->user_id ?? 'NULL') . "\n";
    echo "Kepala Sekolah User ID: " . ($reg->kepala_sekolah_user_id ?? 'NULL') . "\n";

    // Check teacher participants
    $teachers = App\Models\TeacherParticipant::where('registration_id', $reg->id)->get();
    echo "Teacher Participants: " . $teachers->count() . "\n";
    foreach ($teachers as $t) {
        echo "  - " . $t->nama_lengkap . " (User ID: " . ($t->user_id ?? 'NULL') . ")\n";
    }
}

echo "\n=== CHECKING USERS FROM SMKN 1 BANJAR ===\n\n";

$users = App\Models\User::where('institution', 'like', '%banjar%')
    ->orWhere('instansi', 'like', '%banjar%')
    ->get();

echo "USERS with 'banjar' in institution/instansi: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo str_repeat("-", 80) . "\n";
    echo "ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Institution: " . ($user->institution ?? $user->instansi ?? 'NULL') . "\n";
    echo "Province: " . ($user->province ?? 'NULL') . "\n";
    echo "City: " . ($user->city ?? 'NULL') . "\n";
    echo "District: " . ($user->district ?? 'NULL') . "\n";
}

echo "\n=== CHECKING PARTICIPANT MAPPINGS ===\n\n";

// Check if class_id = 1 exists
$class = App\Models\Classes::find(1);
if ($class) {
    echo "Class ID 1:\n";
    echo "Name: " . $class->name . "\n";
    echo "Activity ID: " . $class->activity_id . "\n";
    echo "Capacity: " . $class->capacity . "\n\n";

    $mappings = App\Models\ParticipantMapping::where('class_id', 1)->get();
    echo "Participant Mappings for Class 1: " . $mappings->count() . "\n\n";

    foreach ($mappings as $mapping) {
        $user = App\Models\User::find($mapping->participant_id);
        if ($user) {
            echo "  - User ID: " . $user->id . " | Name: " . $user->name . " | Role: " . $user->role . "\n";
        }
    }

    echo "\n=== REGISTRATIONS ASSIGNED TO CLASS 1 ===\n\n";

    $assignedRegs = App\Models\Registration::where('activity_id', $class->activity_id)
        ->where('class_id', $class->id)
        ->get();

    echo "Assigned Registrations: " . $assignedRegs->count() . "\n\n";

    foreach ($assignedRegs as $reg) {
        echo "Reg ID: " . $reg->id . " | Sekolah: " . $reg->nama_sekolah . " | Status: " . $reg->status . "\n";
        echo "  Kepala Sekolah: " . $reg->jumlah_kepala_sekolah . ", Guru: " . $reg->jumlah_guru . "\n";

        $teachers = App\Models\TeacherParticipant::where('registration_id', $reg->id)->get();
        foreach ($teachers as $t) {
            echo "    - Teacher: " . $t->nama_lengkap . "\n";
        }
    }
} else {
    echo "Class ID 1 not found!\n";
}
