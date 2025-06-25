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
        // Kode ini akan menghapus kolom 'universitas'
        Schema::table('oryza_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('universitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kode ini untuk mengembalikan kolom jika diperlukan (best practice)
        Schema::table('oryza_mahasiswa', function (Blueprint $table) {
            $table->string('universitas')->after('nim');
        });
    }
};
