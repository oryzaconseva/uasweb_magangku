<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'oryza_pengajuan';

    protected $fillable = [
        'mahasiswa_id',
        'lowongan_id',
        'surat_lamaran', // Hanya ini yang kita pakai untuk path file
        'status',
        'tanggal_pengajuan',
        'catatan_perusahaan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
}
