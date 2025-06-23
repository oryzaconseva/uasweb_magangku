<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This method adds the 'role' column to the 'users' table.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom 'role' BELUM ada sebelum mencoba menambahkannya
            if (!Schema::hasColumn('users', 'role')) {
                // Pastikan kolom 'password' sudah ada sebelum menambahkan 'role' setelahnya
                if (Schema::hasColumn('users', 'password')) {
                    $table->enum('role', ['admin', 'mahasiswa', 'perusahaan'])
                          ->default('mahasiswa')
                          ->after('password');
                } else {
                    // Fallback jika kolom password tidak ada, tambahkan saja kolom role
                    $table->enum('role', ['admin', 'mahasiswa', 'perusahaan'])
                          ->default('mahasiswa');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     * This method should drop the 'role' column from the 'users' table.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom 'role' ada sebelum mencoba menghapusnya
            // Ini untuk mencegah error jika migrasi di-rollback beberapa kali
            // atau jika kolom 'role' tidak berhasil dibuat di method up().
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
