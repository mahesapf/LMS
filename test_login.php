<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING LOGIN CREDENTIALS ===\n\n";

// Test credentials
$npsn = '11111';
$password = '11111';

echo "Testing login with:\n";
echo "NPSN: $npsn\n";
echo "Password: $password\n\n";

// Try to find user by NPSN
$user = App\Models\User::where('npsn', $npsn)->first();

if (!$user) {
    echo "✗ User not found with NPSN: $npsn\n";
    exit;
}

echo "✓ User found:\n";
echo "  ID: " . $user->id . "\n";
echo "  Name: " . $user->name . "\n";
echo "  Email: " . $user->email . "\n";
echo "  Role: " . $user->role . "\n";
echo "  Status: " . $user->status . "\n\n";

// Check password
if (Hash::check($password, $user->password)) {
    echo "✓ Password is correct!\n\n";
} else {
    echo "✗ Password is INCORRECT\n\n";
    exit;
}

// Check if account can login
if ($user->role === 'sekolah' && $user->status === 'inactive') {
    echo "✗ Account is PENDING approval (status: inactive)\n";
    exit;
}

if ($user->role === 'sekolah' && $user->status === 'suspended') {
    echo "✗ Account is REJECTED (status: suspended)\n";
    exit;
}

echo "✓ Account is APPROVED and can login!\n\n";

// Test Auth::attempt
echo "=== TESTING Auth::attempt() ===\n\n";

try {
    $credentials = [
        'npsn' => $npsn,
        'password' => $password,
    ];

    if (Auth::attempt($credentials)) {
        echo "✓ Auth::attempt() SUCCESS!\n";
        echo "  Authenticated user: " . Auth::user()->name . "\n";
        echo "  Role: " . Auth::user()->role . "\n";

        // Get redirect path
        $redirectPath = match(Auth::user()->role) {
            'super_admin' => route('super-admin.dashboard'),
            'admin' => route('admin.dashboard'),
            'fasilitator' => route('fasilitator.dashboard'),
            'peserta' => route('peserta.dashboard'),
            'sekolah' => route('sekolah.dashboard'),
            default => route('home'),
        };

        echo "  Redirect to: $redirectPath\n";

        Auth::logout();
    } else {
        echo "✗ Auth::attempt() FAILED!\n";
        echo "  Credentials do not match.\n";
    }
} catch (\Exception $e) {
    echo "✗ ERROR during Auth::attempt(): " . $e->getMessage() . "\n";
}
