<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'phone' => '081234567890',
            'status' => 'active',
        ]);

        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567891',
            'status' => 'active',
        ]);

        // Fasilitator
        User::create([
            'name' => 'Dr. John Doe',
            'degree' => 'S.Pd., M.Pd.',
            'email' => 'fasilitator@example.com',
            'password' => Hash::make('password'),
            'role' => 'fasilitator',
            'phone' => '081234567892',
            'institution' => 'Universitas ABC',
            'position' => 'Dosen',
            'status' => 'active',
        ]);

        // Peserta
        User::create([
            'name' => 'Jane Smith',
            'degree' => 'S.Pd.',
            'email' => 'peserta@example.com',
            'password' => Hash::make('password'),
            'role' => 'peserta',
            'phone' => '081234567893',
            'institution' => 'SD Negeri 1',
            'position' => 'Guru',
            'status' => 'active',
        ]);

        // Additional Peserta
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Peserta $i",
                'email' => "peserta$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'peserta',
                'phone' => '08123456789' . $i,
                'status' => 'active',
            ]);
        }
    }
}
