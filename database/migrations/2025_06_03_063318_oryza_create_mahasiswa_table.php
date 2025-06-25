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

        $prefix = 'oryza_';

        Schema::create($prefix . 'mahasiswa', function (Blueprint $table) use ($prefix) {
            $table->id();
            // Relasi ke tabel users yang sudah diberi prefix
            // onDelete('cascade') berarti jika user dihapus, data mahasiswa terkait juga akan ikut terhapus.
            $table->foreignId('user_id')->constrained($prefix . 'users')->onDelete('cascade');

            // Kolom-kolom yang diperlukan untuk profil mahasiswa
            $table->string('nama_lengkap');
            $table->string('nim')->unique();
            $table->string('universitas');
            $table->string('jurusan');
            $table->year('angkatan')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('cv_path')->nullable(); // Path ke file CV utama di profil

            // Tambahkan kolom lain jika ada, misal:
            // $table->text('alamat')->nullable();
            // $table->string('foto_profil')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        $prefix = 'oryza_';

        // Menonaktifkan pengecekan foreign key sebelum drop tabel untuk menghindari error
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists($prefix . 'mahasiswa');

        // Mengaktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();
    }
};
