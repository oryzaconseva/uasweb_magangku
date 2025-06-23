<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// PERBAIKAN: Impor semua Model yang dibutuhkan
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Lowongan;
use App\Models\Pengajuan;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama/homepage publik.
     */
    public function indexPublic()
    {
        $lowonganTerbaru = Lowongan::where('status', 'Dibuka')->latest()->take(6)->get();
        return view('welcome', compact('lowonganTerbaru'));
    }

    /**
     * Menampilkan dashboard admin dengan data yang benar.
     */
    public function adminDashboard()
    {
        // PERBAIKAN: Menghitung data dari setiap model
        $jumlahMahasiswa = Mahasiswa::count();
        $jumlahLowongan = Lowongan::count();
        $jumlahPengajuan = Pengajuan::count();
        $penggunaTerbaru = User::latest()->take(5)->get();

        // Mengirim semua data yang sudah dihitung ke view
        return view('admin.dashboard', compact(
            'jumlahMahasiswa',
            'jumlahLowongan',
            'jumlahPengajuan',
            'penggunaTerbaru'
        ));
    }

    /**
     * Mengarahkan user ke dashboard yang sesuai setelah login.
     */
    public function autoRedirectDashboard()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Untuk mahasiswa
        if ($user->mahasiswa) {
            return redirect()->intended(route('mahasiswa.dashboard'));
        } else {
            return redirect()->route('mahasiswa.create.profile')->with('info', 'Selamat datang! Mohon lengkapi profil mahasiswa Anda terlebih dahulu.');
        }
    }
}
