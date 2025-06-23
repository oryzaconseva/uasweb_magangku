<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang diasosiasikan dengan model.
     *
     * @var string
     */
    protected $table = 'oryza_lowongan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'kualifikasi',
        'nama_perusahaan', // Tidak ada lagi perusahaan_id
        'lokasi',
        'logo_perusahaan', // Path ke logo
        'jenis',
        'status',
        'batas_akhir_lamaran',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'batas_akhir_lamaran' => 'date',
    ];

    /**
     * Relasi one-to-many ke model Pengajuan.
     * Sebuah Lowongan bisa memiliki banyak Pengajuan lamaran.
     */
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
}
