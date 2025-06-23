<?php

namespace App\Policies;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MahasiswaPolicy
{
    /**
     * Berikan akses penuh kepada admin untuk semua aksi.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null; // Lanjutkan ke method policy lain jika bukan admin
    }

    /**
     * Tentukan apakah user bisa melihat daftar semua mahasiswa.
     * Hanya admin yang bisa.
     */
    public function viewAny(User $user): bool
    {
        // Admin sudah di-handle oleh method before()
        return false;
    }

    /**
     * Tentukan apakah user bisa melihat detail profil mahasiswa.
     */
    public function view(User $user, Mahasiswa $mahasiswa): bool
    {
        // Admin bisa lihat semua (sudah di-handle 'before').
        // Mahasiswa hanya bisa lihat profilnya sendiri.
        return $user->id === $mahasiswa->user_id;
    }

    /**
     * Tentukan apakah user bisa membuat data mahasiswa baru.
     * (Dalam alur kita, ini lebih relevan untuk admin jika ingin membuat manual)
     */
    public function create(User $user): bool
    {
        // Admin sudah di-handle oleh 'before'.
        // Mahasiswa membuat profilnya melalui alur `createProfile`, bukan aksi 'create' umum.
        return false;
    }

    /**
     * Tentukan apakah user bisa mengupdate profil mahasiswa.
     */
    public function update(User $user, Mahasiswa $mahasiswa): bool
    {
        // Admin bisa update semua (sudah di-handle 'before').
        // Mahasiswa hanya bisa update profilnya sendiri.
        return $user->id === $mahasiswa->user_id;
    }

    /**
     * Tentukan apakah user bisa menghapus data mahasiswa.
     */
    public function delete(User $user, Mahasiswa $mahasiswa): bool
    {
        // Hanya admin yang bisa hapus (sudah di-handle 'before').
        return false;
    }
}
