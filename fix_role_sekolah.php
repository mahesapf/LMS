<?php
// Script untuk mengembalikan role user sekolah yang berubah jadi peserta
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

$db = new DB();
$db->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'lms',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$db->setAsGlobal();
$db->bootEloquent();

$emails = [
    'yazdi.prayogi36@smk.belajar.id',
    'ihsan.putra2889@smk.belajar.id',
];

foreach ($emails as $email) {
    $user = DB::table('users')->where('email', $email)->first();
    if ($user) {
        DB::table('users')->where('id', $user->id)->update(['role' => 'sekolah']);
        echo "Role user $email berhasil diupdate menjadi 'sekolah'.\n";
    } else {
        echo "User dengan email $email tidak ditemukan.\n";
    }
}
