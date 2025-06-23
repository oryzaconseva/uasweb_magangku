<?php

// File: app/Models/Perusahaan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang diasosiasikan dengan model.
     * @var string
     */
    protected $table = 'perusahaan'; // Sesuaikan jika nama tabelmu 'perusahaans'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Foreign key ke tabel users (untuk kontak person/admin perusahaan)
        'nama_perusahaan',
        'alamat',
        'email_perusahaan', // Email resmi perusahaan, bisa beda dengan email user kontak
        'nomor_telepon',
        'deskripsi',
        'website',
        'logo_path', // Path ke file logo perusahaan
        'industri',
        // Tambahkan field lain yang relevan
    ];

    /**
     * Relasi one-to-one (inverse) ke model User.
     * Setiap data Perusahaan dimiliki oleh satu User (sebagai kontak person/admin).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi one-to-many ke model Lowongan.
     * Sebuah Perusahaan bisa memiliki banyak Lowongan.
     */
    public function lowongans()
    {
        return $this->hasMany(Lowongan::class);
    }
}
