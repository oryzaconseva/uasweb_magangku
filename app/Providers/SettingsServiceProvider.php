<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Cek apakah tabel settings sudah ada sebelum memuatnya
        if (Schema::hasTable('settings')) {
            $settings = Setting::pluck('value', 'key')->all();
            config()->set('settings', $settings);
        }
    }
}
