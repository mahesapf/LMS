<?php
// Script untuk update role user sekolah yang salah menjadi 'sekolah'

require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

// Konfigurasi database manual jika belum bootstrap Laravel penuh
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

$email = 'ihsan.putra2889@smk.belajar.id';

$user = DB::table('users')->where('email', $email)->first();
if ($user) {
    DB::table('users')->where('id', $user->id)->update(['role' => 'sekolah']);
    echo "Role user $email berhasil diupdate menjadi 'sekolah'.\n";
} else {
    echo "User dengan email $email tidak ditemukan.\n";
}
