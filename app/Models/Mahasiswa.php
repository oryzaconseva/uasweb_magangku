<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang benar.
     */
    protected $table = 'oryza_mahasiswa';

    /**
     * Menentukan kolom mana saja yang boleh diisi.
     */
    // app/Models/Mahasiswa.php

// ...
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'universitas',
        'jurusan',
        'angkatan',
        'no_telp',
        'cv_path',
        'alamat', // <-- TAMBAHKAN BARIS INI
];
// ...

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model Pengajuan.
     */
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
}
