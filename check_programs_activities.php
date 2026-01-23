<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== PROGRAMS ===\n";
$programs = App\Models\Program::all(['id', 'name', 'status']);
foreach($programs as $p) {
    echo "ID: {$p->id} | {$p->name} | Status: {$p->status}\n";
}

echo "\n=== ACTIVITIES ===\n";
$activities = App\Models\Activity::with('program')->get(['id', 'program_id', 'name', 'status']);
foreach($activities as $a) {
    $programName = $a->program ? $a->program->name : '-';
    echo "ID: {$a->id} | {$a->name} | Program: {$programName} | Status: {$a->status}\n";
}

echo "\n=== CLASSES ===\n";
$classes = App\Models\Classes::with('activity')->get(['id', 'activity_id', 'name', 'status']);
foreach($classes as $c) {
    $activityName = $c->activity ? $c->activity->name : '-';
    echo "ID: {$c->id} | {$c->name} | Activity: {$activityName} | Status: {$c->status}\n";
}
