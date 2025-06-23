<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan model User di-import
use Illuminate\Support\Facades\Hash; // Untuk hashing password

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah user admin sudah ada untuk menghindari duplikasi
        if (!User::where('email', 'admin@magangku.com')->exists()) {
            User::create([
                'name' => 'Admin MagangKu',
                'email' => 'admin@magangku.com',
                'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
                'role' => 'admin',
                'email_verified_at' => now(), // Langsung verifikasi email admin
            ]);
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }

        // Contoh Mahasiswa untuk testing
        if (!User::where('email', 'mahasiswa@test.com')->exists()) {
            User::create([
                'name' => 'Test Mahasiswa',
                'email' => 'mahasiswa@test.com',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
            ]);
             $this->command->info('Test Mahasiswa user created successfully!');
        }

        // Bagian untuk membuat user perusahaan DIHAPUS karena tidak lagi digunakan.
    }
}
