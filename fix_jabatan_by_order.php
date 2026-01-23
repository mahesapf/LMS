<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FIX JABATAN BERDASARKAN JUMLAH KEPALA SEKOLAH DAN GURU ===\n\n";

$registrations = App\Models\Registration::with('teacherParticipants')->get();

$totalFixed = 0;

foreach ($registrations as $reg) {
    if ($reg->teacherParticipants->count() == 0) {
        continue;
    }

    $kepalaSekolahCount = $reg->jumlah_kepala_sekolah ?? 0;
    $guruCount = $reg->jumlah_guru ?? 0;

    echo "Registration ID {$reg->id}: {$reg->nama_sekolah}\n";
    echo "  Jumlah KS: {$kepalaSekolahCount}, Jumlah Guru: {$guruCount}\n";
    echo "  Teacher Participants: {$reg->teacherParticipants->count()}\n";

    // Update jabatan based on order
    $index = 0;
    foreach ($reg->teacherParticipants as $teacher) {
        // First N participants are kepala sekolah
        if ($index < $kepalaSekolahCount) {
            $newJabatan = 'Kepala Sekolah';
        } else {
            $newJabatan = 'Guru';
        }

        if ($teacher->jabatan !== $newJabatan) {
            echo "    Updating {$teacher->nama_lengkap}: '{$teacher->jabatan}' -> '{$newJabatan}'\n";
            $teacher->update(['jabatan' => $newJabatan]);
            $totalFixed++;
        }

        $index++;
    }
    echo "\n";
}

echo "\n✓ Total updated: {$totalFixed} teacher_participants\n";
echo "\nDone! Silakan refresh halaman.\n";
