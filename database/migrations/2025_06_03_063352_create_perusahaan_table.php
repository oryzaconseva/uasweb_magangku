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
        Schema::create('perusahaan', function (Blueprint $table) { // Nama tabel 'perusahaan'
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Kontak person/admin
            $table->string('nama_perusahaan')->unique(); // Mengganti 'nama' menjadi 'nama_perusahaan'
            $table->text('alamat');
            $table->string('email_perusahaan')->unique()->nullable(); // Email resmi perusahaan
            $table->string('nomor_telepon'); // Mengganti 'kontak' menjadi 'nomor_telepon'
            $table->string('industri')->nullable(); // Mengganti 'bidang_usaha' menjadi 'industri'
            $table->text('deskripsi')->nullable();
            $table->string('website')->nullable();
            $table->string('logo_path')->nullable();
            // Tambahkan kolom lain jika ada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
