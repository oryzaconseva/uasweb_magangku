<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LowonganController extends Controller
{
    /**
     * Menampilkan daftar lowongan.
     */
    public function index()
    {
        if (request()->routeIs('admin.*')) {
            $lowongans = Lowongan::withCount('pengajuans')->latest()->paginate(10);
            return view('admin.lowongan.index', compact('lowongans'));
        }

        $lowongans = Lowongan::where('status', 'Dibuka')->latest()->paginate(9);
        return view('mahasiswa.lowongan.index', compact('lowongans'));
    }

    /**
     * Menampilkan form untuk membuat lowongan baru (hanya admin).
     */
    public function create()
    {
        return view('admin.lowongan.create');
    }

    /**
     * Menyimpan lowongan baru ke database (hanya admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'jenis' => 'required|in:Magang,Kerja Praktik',
            'status' => 'required|in:Dibuka,Ditutup',
            'batas_akhir_lamaran' => 'nullable|date',
            'logo_perusahaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('logo_perusahaan');

        if ($request->hasFile('logo_perusahaan')) {
            $data['logo_perusahaan'] = $request->file('logo_perusahaan')->store('logos', 'public');
        }

        Lowongan::create($data);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu lowongan.
     */
    public function show(Lowongan $lowongan)
    {
        if (request()->routeIs('admin.*')) {
            return view('admin.lowongan.show', compact('lowongan'));
        }

        return view('mahasiswa.lowongan.show', compact('lowongan'));
    }

    /**
     * Menampilkan form untuk mengedit lowongan (hanya admin).
     */
    public function edit(Lowongan $lowongan)
    {
        return view('admin.lowongan.edit', compact('lowongan'));
    }

    /**
     * Memperbarui data lowongan di database (hanya admin).
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'jenis' => 'required|in:Magang,Kerja Praktik',
            'status' => 'required|in:Dibuka,Ditutup',
            'batas_akhir_lamaran' => 'nullable|date',
            'logo_perusahaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('logo_perusahaan');

        if ($request->hasFile('logo_perusahaan')) {
            if ($lowongan->logo_perusahaan) {
                Storage::disk('public')->delete($lowongan->logo_perusahaan);
            }
            $data['logo_perusahaan'] = $request->file('logo_perusahaan')->store('logos', 'public');
        }

        $lowongan->update($data);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * Menghapus lowongan dari database (hanya admin).
     */
    public function destroy(Lowongan $lowongan)
    {
        if ($lowongan->logo_perusahaan) {
            Storage::disk('public')->delete($lowongan->logo_perusahaan);
        }
        $lowongan->delete();
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}
