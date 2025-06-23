<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        // Panggil seeder lain jika ada
        // \App\Models\User::factory(10)->create();

        $this->call([
            AdminUserSeeder::class,
            // Kamu bisa menambahkan seeder lain di sini jika ada
        ]);
    }
}
