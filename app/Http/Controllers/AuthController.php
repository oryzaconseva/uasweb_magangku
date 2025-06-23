<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Menampilkan form registrasi.
     * Sekarang hanya ada satu jenis pendaftar: mahasiswa.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses data registrasi.
     * Hanya untuk mahasiswa.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:oryza_users'], // Merujuk ke tabel baru
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Semua pendaftaran baru otomatis menjadi mahasiswa
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa', // Role di-hardcode menjadi 'mahasiswa'
        ]);

        Auth::login($user);

        // Setelah registrasi, mahasiswa langsung diarahkan untuk melengkapi profil
        return redirect()->route('mahasiswa.create.profile')->with('success', 'Registrasi berhasil! Silakan lengkapi data diri Anda.');
    }

    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses data login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Arahkan berdasarkan role yang sudah disederhanakan
            if ($user->role == 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Default untuk mahasiswa
            return redirect()->intended(route('mahasiswa.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
