<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = 'oryza_';

        Schema::create($prefix . 'pengajuan', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained($prefix . 'mahasiswa')->onDelete('cascade');
            $table->foreignId('lowongan_id')->constrained($prefix . 'lowongan')->onDelete('cascade');

            // HANYA SATU KOLOM INI UNTUK PATH CV/SURAT LAMARAN
            // Jika Anda yakin path tidak akan sangat panjang, string cukup.
            // Jika Anda ingin fleksibilitas untuk menyimpan surat lamaran terpisah,
            // Anda bisa membuatnya nullable dan meminta upload surat lamaran terpisah.
            // Tapi berdasarkan diskusi, ini untuk CV dari profil.
            $table->string('surat_lamaran'); // Pastikan ini ada dan tidak nullable jika wajib.

            $table->string('status')->default('Diajukan');
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->text('catatan_perusahaan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        $prefix = 'oryza_';
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists($prefix . 'pengajuan');
        Schema::enableForeignKeyConstraints();
    }
};
