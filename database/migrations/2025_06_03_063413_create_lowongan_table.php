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

        Schema::create($prefix . 'lowongan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->text('kualifikasi');

            // Informasi perusahaan yang diinput manual oleh Admin
            $table->string('nama_perusahaan');
            $table->string('lokasi');
            $table->string('logo_perusahaan')->nullable(); // Path ke file logo (opsional)

            $table->string('jenis'); // Contoh: Magang, Kerja Praktik
            $table->string('status')->default('Dibuka'); // Contoh: Dibuka, Ditutup
            $table->date('batas_akhir_lamaran')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        $prefix = 'oryza_';

        Schema::dropIfExists($prefix . 'lowongan');
    }
};
