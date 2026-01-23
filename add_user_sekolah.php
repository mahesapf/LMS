<?php
// Script untuk menambah user sekolah dengan NPSN 11111 jika belum ada
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Str;

$db = new DB();
$db->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'lms', // Ganti sesuai nama database
    'username'  => 'root', // Ganti sesuai user
    'password'  => '', // Ganti sesuai password
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$db->setAsGlobal();
$db->bootEloquent();

$npsn = '11111';
$email = 'smkn1ciamis@smk.belajar.id';
$name = 'SMKN 1 CIAMIS';
$password = password_hash('password123', PASSWORD_BCRYPT); // Ganti password sesuai kebutuhan

$user = DB::table('users')->where('npsn', $npsn)->first();
if ($user) {
    echo "User dengan NPSN $npsn sudah ada.\n";
} else {
    $id = DB::table('users')->insertGetId([
        'name' => $name,
        'email' => $email,
        'npsn' => $npsn,
        'role' => 'sekolah',
        'password' => $password,
        'status' => 'active',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "User sekolah berhasil ditambahkan dengan ID: $id\n";
    echo "Email: $email\n";
    echo "Password: password123\n";
}
