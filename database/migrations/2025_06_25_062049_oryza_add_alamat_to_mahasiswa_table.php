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
        // Kode ini akan dijalankan saat kita 'migrate'
        Schema::table('oryza_mahasiswa', function (Blueprint $table) {
            // Menambahkan kolom 'alamat' bertipe TEXT setelah kolom 'no_telp'
            $table->text('alamat')->after('no_telp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kode ini untuk jaga-jaga jika kita perlu 'rollback'
        Schema::table('oryza_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('alamat');
        });
    }
};
