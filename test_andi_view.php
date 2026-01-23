<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\ParticipantMapping;
use App\Models\Grade;

echo "=== TESTING QUERY FOR andi.pratama@example.com ===" . PHP_EOL . PHP_EOL;

$user = User::where('email', 'andi.pratama@example.com')->first();
$participantId = $user->id;

echo "User ID: $participantId" . PHP_EOL . PHP_EOL;

echo "=== Query untuk myClasses() ===" . PHP_EOL;
$mappings = ParticipantMapping::with(['class.activity', 'assignedBy'])
    ->where('participant_id', $participantId)
    ->where('status', 'in')
    ->latest()
    ->get(); // Using get() instead of paginate for testing

echo "Total mappings found: " . $mappings->count() . PHP_EOL . PHP_EOL;

foreach ($mappings as $mapping) {
    echo "Mapping ID: " . $mapping->id . PHP_EOL;
    echo "  Class: " . $mapping->class->name . PHP_EOL;
    echo "  Activity: " . ($mapping->class->activity ? $mapping->class->activity->name : 'N/A') . PHP_EOL;
    echo "  Status: " . $mapping->status . PHP_EOL;
    echo "  Class Status: " . $mapping->class->status . PHP_EOL;
    echo "  Assigned By: " . ($mapping->assignedBy ? $mapping->assignedBy->name : 'N/A') . PHP_EOL;
    echo PHP_EOL;
}

echo "=== Grades ===" . PHP_EOL;
$grades = Grade::where('participant_id', $participantId)
    ->get()
    ->groupBy('class_id');

echo "Total class_ids with grades: " . $grades->count() . PHP_EOL;
foreach ($grades as $classId => $classGrades) {
    echo "Class ID $classId: " . $classGrades->count() . " grades" . PHP_EOL;
}
