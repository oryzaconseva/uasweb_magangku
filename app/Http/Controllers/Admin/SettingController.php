<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan; // <-- Penting
use Illuminate\Support\Facades\Cache;   // <-- Penting

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan.
     */
    public function index()
    {
        // Mengambil data pengaturan terbaru dari database
        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Memperbarui pengaturan dan membersihkan semua cache yang relevan.
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // PERBAIKAN: Membersihkan semua cache yang mungkin tersisa
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Cache::flush(); // Membersihkan cache aplikasi secara paksa

        return redirect()->route('admin.settings.index')
                         ->with('success', 'Pengaturan berhasil disimpan.')
                         ->withHeaders([
                            'Cache-Control' => 'no-cache, no-store, must-revalidate',
                            'Pragma' => 'no-cache',
                            'Expires' => '0',
                         ]);
    }
}
