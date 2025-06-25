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

    public function storeProfile(Request $request)
{
        // 1. Sesuaikan aturan validasi agar cocok dengan nama input di FORM
    $request->validate([
        // 'nama_lengkap' tidak perlu divalidasi dari form, karena kita ambil dari user yang login
        'nim'           => 'required|string|max:20|unique:oryza_mahasiswa,nim',
        'prodi'         => 'required|string|max:255', // diubah dari universitas & jurusan
        'tahun_masuk'   => 'required|digits:4|integer|min:1990', // diubah dari angkatan
        'no_hp'         => 'required|string|max:15', // diubah dari no_telp
        'alamat'        => 'required|string', // ditambahkan validasi untuk alamat
        'cv'            => 'required|file|mimes:pdf|max:2048',
        // Kita bisa tambahkan field 'universitas' jika memang diperlukan
        // 'universitas' => 'required|string|max:255',
    ]);

    $user = Auth::user();

    // 2. Simpan file CV terlebih dahulu
    $cvPath = $request->file('cv')->store('cvs', 'public');

    // 3. Buat data Mahasiswa, sesuaikan field dengan Model & Form
    Mahasiswa::create([
        'user_id'       => $user->id,
        'nama_lengkap'  => $user->name, // Ambil nama langsung dari user yang login, lebih aman
        'nim'           => $request->nim,
        'jurusan'       => $request->prodi, // 'prodi' dari form disimpan ke kolom 'jurusan'
        'angkatan'      => $request->tahun_masuk, // 'tahun_masuk' dari form disimpan ke 'angkatan'
        'no_telp'       => $request->no_hp, // 'no_hp' dari form disimpan ke 'no_telp'
        'alamat'        => $request->alamat, // 'alamat' dari form disimpan
        'cv_path'       => $cvPath,
        // Jika kamu punya kolom 'universitas', isi di sini
        // 'universitas'   => $request->universitas,
    ]);

    // 4. Update nama user jika diperlukan (opsional, karena seharusnya sudah sama saat registrasi)
    // Jika nama di profil bisa berbeda dari nama user, baris ini boleh diaktifkan.
    // $user->update(['name' => $request->nama_lengkap]);

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
