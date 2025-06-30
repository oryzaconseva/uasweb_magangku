<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- PENTING: Tambahkan ini
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    // ... method index(), show(), edit() untuk admin tetap sama ...
    public function index() { $mahasiswas = Mahasiswa::with('user')->latest()->paginate(10); return view('admin.mahasiswa.index', compact('mahasiswas')); }
    public function show(Mahasiswa $mahasiswa) { return view('admin.mahasiswa.show', compact('mahasiswa')); }
    public function edit(Mahasiswa $mahasiswa) { return view('admin.mahasiswa.edit', compact('mahasiswa')); }

    /**
     * Memperbarui profil mahasiswa oleh admin menggunakan Database Transaction.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => ['required', 'string', 'max:20', Rule::unique('oryza_mahasiswa')->ignore($mahasiswa->id)],
            'universitas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|digits:4|integer|min:1990',
            'no_telp' => 'required|string|max:15',
        ]);

        try {
            DB::transaction(function () use ($request, $mahasiswa) {
                // 1. Update nama di tabel user
                $mahasiswa->user()->update(['name' => $request->input('nama_lengkap')]);

                // 2. Update data di tabel mahasiswa secara manual
                $mahasiswa->nama_lengkap = $request->input('nama_lengkap');
                $mahasiswa->nim = $request->input('nim');
                $mahasiswa->universitas = $request->input('universitas');
                $mahasiswa->jurusan = $request->input('jurusan');
                $mahasiswa->angkatan = $request->input('angkatan');
                $mahasiswa->no_telp = $request->input('no_telp');
                $mahasiswa->save();
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Profil mahasiswa berhasil diperbarui.');
    }


    // ... method dashboard(), createProfile(), storeProfile() untuk mahasiswa tetap sama ...
    public function dashboard() { if (!Auth::user()->mahasiswa) { return redirect()->route('mahasiswa.create.profile')->with('info', 'Mohon lengkapi profil Anda.'); } $mahasiswaId = Auth::user()->mahasiswa->id; $jumlahLowonganTersedia = Lowongan::where('status', 'Dibuka')->count(); $jumlahPengajuan = Pengajuan::where('mahasiswa_id', $mahasiswaId)->count(); $pengajuanTerbaru = Pengajuan::where('mahasiswa_id', $mahasiswaId)->with('lowongan')->latest()->take(5)->get(); return view('mahasiswa.dashboard', compact('jumlahLowonganTersedia', 'jumlahPengajuan', 'pengajuanTerbaru')); }
    public function createProfile() { if (Auth::user()->mahasiswa) { return redirect()->route('mahasiswa.edit.profile'); } return view('mahasiswa.profile.create'); }
   // Ganti seluruh method storeProfile() yang lama dengan ini:

    // Ganti seluruh method storeProfile Anda dengan kode ini

    public function storeProfile(Request $request)
    {
    // 1. Pastikan 'universitas' ada di dalam validasi
        $request->validate([
        'universitas'   => 'required|string|max:255',
        'nim'           => 'required|string|max:20|unique:oryza_mahasiswa,nim',
        'prodi'         => 'required|string|max:255',
        'tahun_masuk'   => 'required|digits:4|integer|min:1990',
        'no_hp'         => 'required|string|max:15',
        'alamat'        => 'required|string',
        'cv'            => 'required|file|mimes:pdf|max:2048',
        ]);

        $user = Auth::user();
        $cvPath = $request->file('cv')->store('cvs', 'public');

    // 2. Pastikan 'universitas' ada di dalam data yang disimpan
        Mahasiswa::create([
        'user_id'       => $user->id,
        'nama_lengkap'  => $user->name,
        'universitas'   => $request->universitas, // <-- Ini akan mengambil data dari input form
        'nim'           => $request->nim,
        'jurusan'       => $request->prodi,
        'angkatan'      => $request->tahun_masuk,
        'no_telp'       => $request->no_hp,
        'alamat'        => $request->alamat,
        'cv_path'       => $cvPath,
    ]);
    Auth::user()->load('mahasiswa');

    return redirect()->route('mahasiswa.dashboard')->with('success', 'Profil berhasil dibuat! Selamat datang.');
    }
    public function editProfile() { $mahasiswa = Auth::user()->mahasiswa; return view('mahasiswa.profile.edit', compact('mahasiswa')); }

    /**
     * Memperbarui profil oleh mahasiswa yang sedang login menggunakan Database Transaction.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => ['required', 'string', 'max:20', Rule::unique('oryza_mahasiswa')->ignore($mahasiswa->id)],
            'universitas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|digits:4|integer|min:1990',
            'no_telp' => 'required|string|max:15',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request, $user, $mahasiswa) {
                // 1. Update nama di tabel user
                $user->update(['name' => $request->input('nama_lengkap')]);

                // 2. Update data di tabel mahasiswa secara manual
                $mahasiswa->nama_lengkap = $request->input('nama_lengkap');
                $mahasiswa->nim = $request->input('nim');
                $mahasiswa->universitas = $request->input('universitas');
                $mahasiswa->jurusan = $request->input('jurusan');
                $mahasiswa->angkatan = $request->input('angkatan');
                $mahasiswa->no_telp = $request->input('no_telp');

                if ($request->hasFile('cv')) {
                    if ($mahasiswa->cv_path) Storage::disk('public')->delete($mahasiswa->cv_path);
                    $mahasiswa->cv_path = $request->file('cv')->store('cvs', 'public');
                }

                $mahasiswa->save();
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
