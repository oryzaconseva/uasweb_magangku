<?php

// File: app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Menangani permintaan yang masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  Array peran yang diizinkan (misalnya 'admin', 'mahasiswa').
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Middleware ini harus dijalankan setelah middleware 'auth',
        // jadi kita bisa langsung mengambil user yang sedang login.
        $user = $request->user();

        // Jika peran user tidak ada di dalam daftar peran ($roles) yang diizinkan,
        // hentikan proses dan tampilkan halaman error 403 (Akses Ditolak).
        // Ini lebih aman daripada melakukan redirect.
        if (! in_array($user->role, $roles)) {
            abort(403, 'AKSES DITOLAK. ANDA TIDAK MEMILIKI HAK UNTUK MENGAKSES HALAMAN INI.');
        }

        // Jika peran sesuai, lanjutkan permintaan.
        return $next($request);
    }
}

