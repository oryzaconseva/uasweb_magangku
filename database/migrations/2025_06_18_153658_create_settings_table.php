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
        // MENAMBAHKAN PREFIX
        $prefix = 'oryza_';

        // MENGGUNAKAN PREFIX
        Schema::create($prefix . 'settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // MENAMBAHKAN PREFIX
        $prefix = 'oryza_';

        // MENGGUNAKAN PREFIX
        Schema::dropIfExists($prefix . 'settings');
    }
};
