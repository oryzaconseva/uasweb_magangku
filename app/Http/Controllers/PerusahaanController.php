<?php

// File: app/Http/Controllers/PerusahaanController.php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Untuk menghapus logo
use Illuminate\Validation\Rule;


class PerusahaanController extends Controller
{
    /**
     * Menampilkan daftar perusahaan (untuk Admin).
     * Dipanggil oleh route admin.perusahaan.index
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', Perusahaan::class); // Jika menggunakan Policies

        $query = Perusahaan::with('user')->latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_perusahaan', 'like', "%{$searchTerm}%")
                  ->orWhere('email_perusahaan', 'like', "%{$searchTerm}%")
                  ->orWhere('industri', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%") // Nama kontak person
                                ->orWhere('email', 'like', "%{$searchTerm}%"); // Email kontak person
                  });
            });
        }
        $perusahaans = $query->paginate(10)->appends($request->query());

        // Pastikan view ini ada di resources/views/admin/perusahaan/index.blade.php
        return view('admin.perusahaan.index', compact('perusahaans'));
    }

    /**
     * Menampilkan form untuk membuat profil perusahaan (setelah registrasi oleh perusahaan).
     * Dipanggil oleh route perusahaan.create.profile
     */
    public function createProfile()
    {
        $user = Auth::user();
        if ($user->perusahaan) {
            return redirect()->route('perusahaan.dashboard')->with('info', 'Anda sudah melengkapi data perusahaan.');
        }
        // Pastikan view ini ada di resources/views/perusahaan/create.blade.php (atau profile/form.blade.php)
        return view('perusahaan.profile.form', compact('user')); // Atau perusahaan.create
    }

    /**
     * Menyimpan profil perusahaan baru (dari form perusahaan).
     * Dipanggil oleh route perusahaan.store.profile
     */
    public function storeProfile(Request $request)
    {
        $user = Auth::user();
        if ($user->perusahaan) {
            return redirect()->route('perusahaan.dashboard')->with('error', 'Data perusahaan Anda sudah ada.');
        }

        $validatedUserData = $request->validate([
            'name' => 'required|string|max:255', // Nama kontak person
            'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($user->id)], // Email login kontak person
        ]);

        $validatedPerusahaanData = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255', Rule::unique('perusahaan', 'nama_perusahaan')],
            'alamat' => 'required|string',
            'email_perusahaan' => ['required', 'email', 'max:255', Rule::unique('perusahaan', 'email_perusahaan')],
            'nomor_telepon' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'industri' => 'nullable|string|max:255',
            'logo_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024', // Max 1MB
        ]);

        // Update data user (kontak person)
        $user->update($validatedUserData);

        $logoPath = null;
        if ($request->hasFile('logo_path')) {
            $logoPath = $request->file('logo_path')->store('perusahaan_logos/' . $user->id, 'public');
        }

        Perusahaan::create([
            'user_id' => $user->id,
            'nama_perusahaan' => $validatedPerusahaanData['nama_perusahaan'],
            'alamat' => $validatedPerusahaanData['alamat'],
            'email_perusahaan' => $validatedPerusahaanData['email_perusahaan'],
            'nomor_telepon' => $validatedPerusahaanData['nomor_telepon'],
            'deskripsi' => $validatedPerusahaanData['deskripsi'] ?? null,
            'website' => $validatedPerusahaanData['website'] ?? null,
            'industri' => $validatedPerusahaanData['industri'] ?? null,
            'logo_path' => $logoPath,
        ]);

        return redirect()->route('perusahaan.dashboard')->with('success', 'Profil perusahaan berhasil disimpan!');
    }

    /**
     * Menampilkan detail perusahaan.
     * Bisa dipanggil oleh admin (admin.perusahaan.show) atau perusahaan (perusahaan.profile.show - jika ada).
     */
    public function show(Perusahaan $perusahaan)
    {
        // $this->authorize('view', $perusahaan);
        $perusahaan->load('user', 'lowongans.pengajuans'); // Eager load relasi

        if (Auth::check() && Auth::user()->role == 'admin') {
            // Pastikan view ini ada di resources/views/admin/perusahaan/show.blade.php
            return view('admin.perusahaan.show', compact('perusahaan'));
        }
        // Tambahkan logika untuk perusahaan melihat profilnya sendiri jika perlu
        // elseif (Auth::check() && Auth::user()->perusahaan && Auth::user()->perusahaan->id == $perusahaan->id) {
        //     return view('perusahaan.profile.show', compact('perusahaan')); // Atau sejenisnya
        // }
        abort(403);
    }

    /**
     * Menampilkan form untuk mengedit data perusahaan.
     * Bisa dipanggil oleh admin (admin.perusahaan.edit) atau perusahaan (perusahaan.edit.profile).
     */
    public function edit(Perusahaan $perusahaan = null) // Buat parameter $perusahaan opsional
    {
        if (Auth::user()->role == 'admin' && $perusahaan) {
            // $this->authorize('update', $perusahaan);
            $user = $perusahaan->user;
            // Pastikan view ini ada di resources/views/admin/perusahaan/edit.blade.php
            return view('admin.perusahaan.edit', compact('perusahaan', 'user'));
        } elseif (Auth::user()->role == 'perusahaan') {
            $perusahaan = Auth::user()->perusahaan;
            if (!$perusahaan) {
                return redirect()->route('perusahaan.create.profile')->with('info', 'Lengkapi profil perusahaan Anda terlebih dahulu.');
            }
            $user = Auth::user();
            // Pastikan view ini ada di resources/views/perusahaan/profile/form.blade.php (atau edit.blade.php)
            return view('perusahaan.profile.form', compact('perusahaan', 'user'));
        }
        abort(403);
    }

    /**
     * Memperbarui data perusahaan di database.
     * Bisa dipanggil oleh admin (admin.perusahaan.update) atau perusahaan (perusahaan.update.profile).
     */
    public function update(Request $request, Perusahaan $perusahaan = null) // Buat parameter $perusahaan opsional
    {
        $is_admin_action = false;
        if (Auth::user()->role == 'admin' && $perusahaan) {
            // $this->authorize('update', $perusahaan);
            $user_to_update = $perusahaan->user;
            $perusahaan_to_update = $perusahaan;
            $is_admin_action = true;
        } elseif (Auth::user()->role == 'perusahaan') {
            $perusahaan_to_update = Auth::user()->perusahaan;
            if (!$perusahaan_to_update) {
                return redirect()->route('perusahaan.create.profile')->with('error', 'Profil perusahaan tidak ditemukan.');
            }
            $user_to_update = Auth::user();
        } else {
            abort(403);
        }

        $validatedUserData = $request->validate([
            'name' => 'required|string|max:255', // Nama kontak person
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user_to_update->id)], // Email login
        ]);

        $validatedPerusahaanData = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255', Rule::unique('perusahaan', 'nama_perusahaan')->ignore($perusahaan_to_update->id)],
            'alamat' => 'required|string',
            'email_perusahaan' => ['required', 'email', 'max:255', Rule::unique('perusahaan', 'email_perusahaan')->ignore($perusahaan_to_update->id)],
            'nomor_telepon' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'industri' => 'nullable|string|max:255',
            'logo_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        $user_to_update->update($validatedUserData);

        $updateDataPerusahaan = $validatedPerusahaanData;
        unset($updateDataPerusahaan['logo_path']);

        if ($request->hasFile('logo_path')) {
            // Hapus logo lama jika ada dan file baru diunggah
            if ($perusahaan_to_update->logo_path && Storage::disk('public')->exists($perusahaan_to_update->logo_path)) {
                Storage::disk('public')->delete($perusahaan_to_update->logo_path);
            }
            $updateDataPerusahaan['logo_path'] = $request->file('logo_path')->store('perusahaan_logos/' . $user_to_update->id, 'public');
        }

        $perusahaan_to_update->update($updateDataPerusahaan);

        if ($is_admin_action) {
            return redirect()->route('admin.perusahaan.show', $perusahaan_to_update->id)->with('success', 'Data perusahaan berhasil diperbarui!');
        }
        return redirect()->route('perusahaan.dashboard')->with('success', 'Profil perusahaan Anda berhasil diperbarui!');
    }

    /**
     * Menghapus data perusahaan (hanya Admin).
     * Dipanggil oleh route admin.perusahaan.destroy
     */
    public function destroy(Perusahaan $perusahaan)
    {
        // $this->authorize('delete', $perusahaan);

        // Hapus logo dari storage jika ada
        if ($perusahaan->logo_path && Storage::disk('public')->exists($perusahaan->logo_path)) {
            Storage::disk('public')->delete($perusahaan->logo_path);
        }

        // Hapus lowongan terkait (dan pengajuan terkait lowongan tersebut karena onDelete('cascade'))
        $perusahaan->lowongans()->each(function ($lowongan) {
            $lowongan->pengajuans()->delete(); // Hapus pengajuan dulu
            $lowongan->delete(); // Kemudian hapus lowongan
        });

        // Pertimbangkan untuk menghapus user terkait juga.
        // $user = $perusahaan->user;
        $perusahaan->delete();
        // if($user) { $user->delete(); }

        return redirect()->route('admin.perusahaan.index')->with('success', 'Data perusahaan dan semua lowongan serta pengajuan terkait berhasil dihapus.');
    }

    /**
     * Menampilkan dashboard perusahaan.
     * Dipanggil oleh route perusahaan.dashboard
     */
    public function dashboard()
    {
        $perusahaan = Auth::user()->perusahaan;
        if (!$perusahaan) {
            return redirect()->route('perusahaan.create.profile')->with('info', 'Lengkapi data perusahaan Anda terlebih dahulu.');
        }
        // Load lowongan milik perusahaan untuk ditampilkan di dashboard
        $lowongans = $perusahaan->lowongans()->withCount('pengajuans')->latest()->paginate(5); // Ambil 5 terbaru
        // Pastikan view ini ada di resources/views/perusahaan/dashboard.blade.php
        return view('perusahaan.dashboard', compact('perusahaan', 'lowongans'));
    }

    // Di dalam App\Http\Controllers\PengajuanController.php


public function downloadCv(Pengajuan $pengajuan)
{
    // Otorisasi: Pastikan user yang meminta adalah perusahaan pemilik lowongan atau admin
    $this->authorize('view', $pengajuan); // Atau policy yang lebih spesifik jika perlu

    if (!$pengajuan->cv_path || !Storage::disk('public')->exists($pengajuan->cv_path)) {
        abort(404, 'File CV tidak ditemukan.');
    }

    // return Storage::disk('public')->download($pengajuan->cv_path); // Untuk langsung unduh
    return response()->file(storage_path('app/public/' . $pengajuan->cv_path)); // Untuk tampilkan di browser (jika PDF)
}
}
