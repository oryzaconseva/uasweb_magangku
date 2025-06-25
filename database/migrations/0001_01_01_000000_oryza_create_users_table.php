<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $prefix = 'oryza_'; // Prefix nama depanmu

        // Membuat tabel users langsung dengan kolom role
        Schema::create($prefix . 'users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // Menambahkan kolom role langsung di sini
            $table->enum('role', ['admin', 'mahasiswa'])->default('mahasiswa');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel standar Laravel lainnya
        Schema::create($prefix . 'password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create($prefix . 'sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $prefix = 'oryza_';

        // Menonaktifkan pengecekan foreign key untuk drop yang aman
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists($prefix . 'users');
        Schema::dropIfExists($prefix . 'password_reset_tokens');
        Schema::dropIfExists($prefix . 'sessions');

        // Mengaktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();
    }
};
