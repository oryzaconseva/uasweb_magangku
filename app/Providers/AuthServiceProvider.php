<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate; // Uncomment jika kamu menggunakan Gate
use App\Models\Mahasiswa;
use App\Policies\MahasiswaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

// Import Model dan Policy yang akan didaftarkan
// Contoh:
use App\Models\Pengajuan;
use App\Policies\PengajuanPolicy;
use App\Models\Lowongan;
use App\Policies\LowonganPolicy;
// Jika kamu punya policy untuk Mahasiswa dan Perusahaan, import juga di sini
// use App\Models\Mahasiswa;
// use App\Policies\MahasiswaPolicy;
// use App\Models\Perusahaan;
// use App\Policies\PerusahaanPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy', // Format default
        // Daftarkan policy-mu di sini, contoh:
        Pengajuan::class => PengajuanPolicy::class,
        Lowongan::class => LowonganPolicy::class,
        Mahasiswa::class => MahasiswaPolicy::class,
        // Jika kamu punya policy untuk Mahasiswa dan Perusahaan, daftarkan juga di sini
        // Mahasiswa::class => MahasiswaPolicy::class,
        // Perusahaan::class => PerusahaanPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Di sini kamu juga bisa mendefinisikan Gate jika diperlukan
        // Gate::define('update-post', function (User $user, Post $post) {
        //     return $user->id === $post->user_id;
        // });
    }
}
