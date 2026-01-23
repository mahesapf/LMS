<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\ParticipantMapping;
use App\Models\Classes;

echo "=== USER andi.pratama@example.com ===" . PHP_EOL;
$user = User::where('email', 'andi.pratama@example.com')->first();

if (!$user) {
    echo "User not found!" . PHP_EOL;
    exit;
}

echo "ID: " . $user->id . PHP_EOL;
echo "Name: " . $user->name . PHP_EOL;
echo "Role: " . $user->role . PHP_EOL;
echo PHP_EOL;

echo "=== KELAS ID 3 ===" . PHP_EOL;
$class = Classes::find(3);
if ($class) {
    echo "ID: " . $class->id . PHP_EOL;
    echo "Name: " . $class->name . PHP_EOL;
    echo "Status: " . $class->status . PHP_EOL;

    if ($class->activity) {
        echo "Activity: " . $class->activity->name . PHP_EOL;
    }
} else {
    echo "Class ID 3 not found!" . PHP_EOL;
}

echo PHP_EOL . "=== SEARCH 'Content Creator Junior' ===" . PHP_EOL;
$contentClass = Classes::where('name', 'LIKE', '%Content Creator%')->get();
foreach ($contentClass as $c) {
    echo "Found: " . $c->name . " (ID: " . $c->id . ", Status: " . $c->status . ")" . PHP_EOL;
}

echo PHP_EOL . "=== PARTICIPANT MAPPINGS ===" . PHP_EOL;
$mappings = ParticipantMapping::where('participant_id', $user->id)->with('class')->get();

if ($mappings->isEmpty()) {
    echo "No mappings found!" . PHP_EOL;
} else {
    foreach ($mappings as $m) {
        echo "Class: " . $m->class->name . PHP_EOL;
        echo "  Class ID: " . $m->class_id . PHP_EOL;
        echo "  Status: " . $m->status . PHP_EOL;
        echo "  Enrolled: " . ($m->enrolled_date ?? 'N/A') . PHP_EOL;
        echo PHP_EOL;
    }
}

echo "=== QUERY DASHBOARD ===" . PHP_EOL;
$activeCount = ParticipantMapping::where('participant_id', $user->id)
    ->where('status', 'in')
    ->count();
echo "Kelas dengan status 'in': " . $activeCount . PHP_EOL;
