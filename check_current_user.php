<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    Illuminate\Http\Request::capture()
);

// Start session
session_start();

if (isset($_SESSION['login_web_' . md5(config('app.key'))])) {
    $user = \App\Models\User::find($_SESSION['login_web_' . md5(config('app.key'))]);
    echo "User ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Status: " . $user->status . "\n";
} else {
    echo "No user logged in\n";
}
