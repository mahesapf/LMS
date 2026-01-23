<?php
// Script untuk cek role user berdasarkan NPSN
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

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
$user = DB::table('users')->where('npsn', $npsn)->first();
if ($user) {
    echo "User ditemukan:\n";
    echo "ID: $user->id\n";
    echo "Nama: $user->name\n";
    echo "Email: $user->email\n";
    echo "NPSN: $user->npsn\n";
    echo "Role: $user->role\n";
} else {
    echo "User dengan NPSN $npsn tidak ditemukan.\n";
}
