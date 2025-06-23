<?php

namespace App\Policies;

use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LowonganPolicy
{
    /**
     * Berikan akses penuh kepada admin untuk semua aksi terkait lowongan.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    /**
     * Tentukan apakah user (termasuk tamu) bisa melihat daftar lowongan.
     */
    public function viewAny(User $user = null): bool
    {
        // Semua orang, termasuk tamu, bisa melihat daftar lowongan.
        return true;
    }

    /**
     * Tentukan apakah user (termasuk tamu) bisa melihat detail lowongan.
     */
    public function view(User $user = null, Lowongan $lowongan): bool
    {
        // Semua orang, termasuk tamu, bisa melihat detail lowongan.
        return true;
    }

    /**
     * Tentukan apakah user bisa membuat lowongan baru.
     */
    public function create(User $user): bool
    {
        // Hanya admin yang bisa membuat lowongan baru (sudah di-handle 'before').
        return false;
    }

    /**
     * Tentukan apakah user bisa mengupdate lowongan.
     */
    public function update(User $user, Lowongan $lowongan): bool
    {
        // Hanya admin yang bisa mengupdate lowongan (sudah di-handle 'before').
        return false;
    }

    /**
     * Tentukan apakah user bisa menghapus lowongan.
     */
    public function delete(User $user, Lowongan $lowongan): bool
    {
        // Hanya admin yang bisa menghapus lowongan (sudah di-handle 'before').
        return false;
    }
}
