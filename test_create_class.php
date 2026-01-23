<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING CLASS CREATION ===\n\n";

// Simulasi request dengan data dari user
$data = [
    'activity_id' => 16, // pelatihan kepala sekolah
    'name' => 'Test Kelas BNPS',
    'description' => 'Kelas test untuk program BNPS',
    'start_date' => '2026-02-01',
    'end_date' => '2026-02-05',
    'max_participants' => 30,
    'status' => 'open',
    'created_by' => 1, // Assuming super admin ID is 1
];

echo "Data yang akan dibuat:\n";
print_r($data);

try {
    $class = App\Models\Classes::create($data);
    echo "\n✓ SUCCESS! Kelas berhasil dibuat dengan ID: {$class->id}\n";
    echo "Nama: {$class->name}\n";
    echo "Kegiatan: {$class->activity->name}\n";
    echo "Program: {$class->activity->program->name}\n";
} catch (\Exception $e) {
    echo "\n✗ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
