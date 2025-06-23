<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Mahasiswa; // Pastikan ini diimpor

class PengajuanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $pengajuans = Pengajuan::with(['mahasiswa.user', 'lowongan'])->latest()->paginate(10);
            return view('admin.pengajuan.index', compact('pengajuans'));
        }

        if (!$user->mahasiswa) {
            return redirect()->route('mahasiswa.create.profile')->with('error', 'Lengkapi profil untuk melihat riwayat lamaran.');
        }
        $pengajuans = Pengajuan::where('mahasiswa_id', $user->mahasiswa->id)
            ->with('lowongan')
            ->latest()
            ->paginate(10);
        return view('mahasiswa.pengajuan.index', compact('pengajuans'));
    }

    public function create(Lowongan $lowongan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.create.profile')
                ->with('error', 'Anda harus melengkapi profil terlebih dahulu sebelum melamar.');
        }

        // VALIDASI PENTING: Pastikan CV sudah diunggah di profil mahasiswa
        if (!$mahasiswa->cv_path) {
            return redirect()->route('mahasiswa.edit.profile') // Arahkan ke halaman edit profil untuk upload CV
                             ->with('error', 'Anda harus mengunggah CV di profil Anda sebelum dapat melamar lowongan ini.');
        }

        return view('mahasiswa.pengajuan.create', compact('lowongan', 'mahasiswa'));
    }

    public function store(Request $request, Lowongan $lowongan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // VALIDASI PENTING: Pastikan mahasiswa ada dan CV sudah diunggah
        if (!$mahasiswa || !$mahasiswa->cv_path) {
            return redirect()->route('mahasiswa.edit.profile')
                             ->with('error', 'Anda harus memiliki CV yang terunggah di profil Anda untuk melamar.');
        }

        // Cek apakah mahasiswa sudah melamar ke lowongan ini
        $existingPengajuan = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->where('lowongan_id', $lowongan->id)
            ->exists();

        if ($existingPengajuan) {
            return redirect()->route('mahasiswa.lowongan.show', $lowongan)
                ->with('error', 'Anda sudah pernah melamar di posisi ini.');
        }

        // --- INI PERBAIKAN UTAMA DI SINI ---
        Pengajuan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'lowongan_id' => $lowongan->id,
            'status' => 'Diajukan',
            'surat_lamaran' => $mahasiswa->cv_path, // Pastikan ini mengisi kolom surat_lamaran
            'tanggal_pengajuan' => now(), // Mengisi tanggal pengajuan
            // 'catatan_perusahaan' tidak perlu diisi di sini karena nullable
        ]);
        // --- END PERBAIKAN UTAMA ---

        return redirect()->route('mahasiswa.pengajuan.index')
            ->with('success', 'Lamaran Anda berhasil dikirim!');
    }

    public function show(Pengajuan $pengajuan)
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return view('admin.pengajuan.show', compact('pengajuan'));
        }

        if ($pengajuan->mahasiswa_id != $user->mahasiswa->id) {
            abort(403);
        }
        return view('mahasiswa.pengajuan.show', compact('pengajuan'));
    }

    // --- PERBAIKAN PADA downloadCv ---
    public function downloadCv(Pengajuan $pengajuan)
    {
        $user = Auth::user();
        $mahasiswaProfil = $pengajuan->mahasiswa;

        // Otorisasi: Izinkan jika user adalah admin ATAU jika user adalah mahasiswa pemilik lamaran
        if ($user->role !== 'admin' && $user->id !== $mahasiswaProfil->user_id) {
            abort(403, 'AKSES DITOLAK. Anda tidak memiliki izin untuk melihat file ini.');
        }

        // Gunakan kolom 'surat_lamaran' dari objek $pengajuan itu sendiri
        $filePath = $pengajuan->surat_lamaran;

        if (!$filePath) {
            return redirect()->back()->with('error', 'File lamaran (CV) tidak ditemukan untuk pengajuan ini.');
        }

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File lamaran (CV) tidak ada di server.');
        }

        // Menyesuaikan nama file unduhan
        return Storage::disk('public')->download($filePath, 'Lamaran_CV_' . $mahasiswaProfil->user->name . '_' . $pengajuan->lowongan->judul . '.pdf');
    }
    // --- END PERBAIKAN ---

    public function update(Request $request, Pengajuan $pengajuan)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Diajukan,Dilihat,Diterima,Ditolak',
        ]);

        $pengajuan->update(['status' => $request->status]);

        return redirect()->route('admin.pengajuan.show', $pengajuan)->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        if ($pengajuan->mahasiswa_id != Auth::user()->mahasiswa->id) {
            abort(403);
        }

        if ($pengajuan->status !== 'Diajukan') {
            return redirect()->back()->with('error', 'Lamaran yang sudah diproses tidak dapat dibatalkan.');
        }

        $pengajuan->delete();
        return redirect()->route('mahasiswa.pengajuan.index')->with('success', 'Pengajuan lamaran berhasil dibatalkan.');
    }
}
