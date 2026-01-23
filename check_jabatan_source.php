<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING JABATAN DATA SOURCE ===\n\n";

// Check if peserta.txt has jabatan data
if (file_exists(__DIR__ . '/peserta.txt')) {
    echo "peserta.txt exists. Checking content...\n";
    $lines = file(__DIR__ . '/peserta.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (count($lines) > 0) {
        echo "First 3 lines of peserta.txt:\n";
        foreach (array_slice($lines, 0, 3) as $line) {
            echo $line . "\n";
        }
    }
    echo "\n";
}

// Check teacher_participants table structure
echo "=== teacher_participants table columns ===\n";
$columns = DB::select("SHOW COLUMNS FROM teacher_participants");
foreach ($columns as $col) {
    echo "- {$col->Field} ({$col->Type})\n";
}
echo "\n";

// Check if there's any jabatan-related data in registrations or elsewhere
echo "=== Sample registration data ===\n";
$reg = App\Models\Registration::where('class_id', 4)->first();
if ($reg) {
    echo "Registration columns with data:\n";
    foreach ($reg->getAttributes() as $key => $value) {
        if (!is_null($value) && !in_array($key, ['id', 'created_at', 'updated_at'])) {
            echo "  {$key}: " . (strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value) . "\n";
        }
    }
}
