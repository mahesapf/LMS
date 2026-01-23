<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING ACTIVITIES IN SUPER-ADMIN VIEW ===\n\n";

// Simulasi apa yang controller kirim ke view
$activities = App\Models\Activity::all();

echo "Total activities: " . $activities->count() . "\n\n";

echo "Activities yang akan muncul di dropdown:\n";
echo str_repeat("=", 60) . "\n";

foreach($activities as $activity) {
    $programName = $activity->program ? $activity->program->name : 'No Program';
    echo sprintf(
        "ID: %-3s | Status: %-10s | %s (Program: %s)\n",
        $activity->id,
        $activity->status,
        $activity->name,
        $programName
    );
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "\nCari 'pelatihan kepala sekolah':\n";
$targetActivity = $activities->where('id', 16)->first();
if ($targetActivity) {
    echo "✓ DITEMUKAN!\n";
    echo "  ID: {$targetActivity->id}\n";
    echo "  Name: {$targetActivity->name}\n";
    echo "  Program: {$targetActivity->program->name}\n";
    echo "  Status: {$targetActivity->status}\n";
} else {
    echo "✗ TIDAK DITEMUKAN di hasil query Activity::all()\n";
}
