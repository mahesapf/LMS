<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Test send email
    $testEmail = 'mahesa.putra2989@smk.belajar.id'; // Email test
    
    Mail::raw('Test email dari LMS. Jika Anda menerima email ini, konfigurasi email sudah benar!', function($message) use ($testEmail) {
        $message->to($testEmail)
                ->subject('Test Email - LMS Penjaminan Mutu');
    });
    
    echo "✅ Email berhasil dikirim ke: $testEmail\n";
    echo "Silakan cek inbox/spam folder.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nPossible causes:\n";
    echo "1. App Password salah\n";
    echo "2. Gmail 2-Step Verification belum aktif\n";
    echo "3. Port 587 diblok firewall\n";
    echo "4. Username email salah\n";
}
