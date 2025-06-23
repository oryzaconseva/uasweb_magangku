<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class ShareSettingsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika tabel settings ada, lalu ambil semua data dan bagikan ke semua view
        // Ini memastikan data selalu terbaru pada setiap request
        if (Schema::hasTable('settings')) {
            $settings = Setting::pluck('value', 'key')->all();
            // Bagikan variabel $settings ke semua view yang dirender setelah middleware ini
            view()->share('settings', $settings);
        }

        return $next($request);
    }
}
