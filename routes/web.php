<?php

use Illuminate\Support\Facades\Route;
// Import semua controller yang akan digunakan
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// RUTE PUBLIK
Route::get('/', [DashboardController::class, 'indexPublic'])->name('home.public');
Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index.public');
Route::get('/lowongan/{lowongan}', [LowonganController::class, 'show'])->name('lowongan.show.public');


// RUTE AUTENTIKASI (Hanya untuk tamu)
Route::middleware('guest')->group(function () {
    // PERBAIKAN: Mengubah nama rute agar sesuai dengan view
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// RUTE TERPROTEKSI (Memerlukan Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.submit');
    Route::get('/dashboard', [DashboardController::class, 'autoRedirectDashboard'])->name('dashboard');

    // === RUTE KHUSUS UNTUK ADMIN ===
    Route::middleware([CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('mahasiswa', MahasiswaController::class)->except(['create', 'store']);
        Route::resource('lowongan', LowonganController::class);
        Route::put('/pengajuan/{pengajuan}', [PengajuanController::class, 'update'])->name('pengajuan.updateStatus');
        Route::resource('pengajuan', PengajuanController::class)->except(['create', 'store', 'edit', 'update']);
        Route::get('/pengajuan/{pengajuan}/download-cv', [PengajuanController::class, 'downloadCv'])->name('pengajuan.downloadCv');
        Route::resource('users', AdminUserController::class);
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });

    // === RUTE KHUSUS UNTUK MAHASISWA ===
    Route::middleware([CheckRole::class . ':mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile/create', [MahasiswaController::class, 'createProfile'])->name('create.profile');
        Route::post('/profile/store', [MahasiswaController::class, 'storeProfile'])->name('store.profile');

        Route::get('/profile/edit', [MahasiswaController::class, 'editProfile'])->name('edit.profile');
        Route::put('/profile/update', [MahasiswaController::class, 'updateProfile'])->name('update.profile');

        Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
        Route::get('/lowongan/{lowongan}', [LowonganController::class, 'show'])->name('lowongan.show');
        Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('/lowongan/{lowongan}/apply', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/lowongan/{lowongan}/apply', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
        Route::delete('/pengajuan/{pengajuan}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');
        Route::get('/pengajuan/{pengajuan}/cv', [PengajuanController::class, 'downloadCv'])->name('pengajuan.cv.download');
    });
});
