<?php

namespace App\Policies;

use App\Models\Lowongan;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PengajuanPolicy
{
    /**
     * Berikan akses penuh kepada admin.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    /**
     * Tentukan apakah user bisa melihat daftar pengajuan.
     */
    public function viewAny(User $user): bool
    {
        // Mahasiswa bisa melihat daftar pengajuannya sendiri.
        return $user->role === 'mahasiswa';
    }

    /**
     * Tentukan apakah user bisa melihat detail satu pengajuan.
     */
    public function view(User $user, Pengajuan $pengajuan): bool
    {
        // Mahasiswa hanya bisa lihat pengajuannya sendiri.
        return $user->role === 'mahasiswa' && $user->mahasiswa?->id === $pengajuan->mahasiswa_id;
    }

    /**
     * Tentukan apakah user bisa membuat pengajuan baru.
     */
    public function create(User $user, Lowongan $lowongan): bool
    {
        // Hanya mahasiswa yang profilnya lengkap & belum melamar ke lowongan ini.
        return $user->role === 'mahasiswa' && $user->mahasiswa !== null && !$user->mahasiswa->pengajuans()->where('lowongan_id', $lowongan->id)->exists();
    }

    /**
     * Tentukan apakah user bisa mengupdate pengajuan.
     */
    public function update(User $user, Pengajuan $pengajuan): bool
    {
        // Hanya admin yang bisa update status pengajuan (sudah di-handle 'before').
        return false;
    }

    /**
     * Tentukan apakah user bisa menghapus pengajuan.
     */
    public function delete(User $user, Pengajuan $pengajuan): bool
    {
        // Mahasiswa bisa hapus pengajuannya sendiri jika statusnya masih 'Diajukan'
        if ($user->role === 'mahasiswa' && $user->mahasiswa?->id === $pengajuan->mahasiswa_id) {
            return $pengajuan->status === 'Diajukan';
        }
        // Admin bisa hapus semua (sudah di-handle 'before').
        return false;
    }
}
