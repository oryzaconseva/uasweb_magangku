<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // GANTI SELURUH method up() ANDA DENGAN INI
public function up(): void
{
    $prefix = 'oryza_';

    Schema::create($prefix . 'mahasiswa', function (Blueprint $table) use ($prefix) {
        $table->id();
        $table->foreignId('user_id')->constrained($prefix . 'users')->onDelete('cascade');

        // Kolom-kolom profil mahasiswa (semua wajib diisi)
        $table->string('nama_lengkap');
        $table->string('nim')->unique();
        $table->string('universitas');
        $table->string('jurusan');
        $table->year('angkatan');
        $table->string('no_telp');
        $table->text('alamat');
        $table->string('cv_path');

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
