@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('admin_content')
    <div class="header-admin mb-4">
        <h1 class="h2 mb-1">Admin Dashboard</h1>
        <p class="text-secondary">Selamat datang kembali, {{ Auth::user()->name }}! Berikut adalah ringkasan sistem MagangKu hari ini.</p>
    </div>

    {{-- Kartu Statistik --}}
    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('admin.mahasiswa.index') }}" class="stat-card-link">
                <div class="stat-card">
                    <div class="stat-icon-wrapper" style="background-color: rgba(59, 130, 246, 0.1); color: #0d6efd;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-title">Total Mahasiswa</span>
                        <span class="stat-number">{{ $jumlahMahasiswa ?? 0 }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('admin.users.index') }}" class="stat-card-link">
                <div class="stat-card">
                    <div class="stat-icon-wrapper" style="background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-title">Total Pengguna</span>
                        <span class="stat-number">{{ \App\Models\User::count() }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('admin.lowongan.index') }}" class="stat-card-link">
                <div class="stat-card">
                    <div class="stat-icon-wrapper" style="background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-title">Total Lowongan</span>
                        <span class="stat-number">{{ $jumlahLowongan ?? 0 }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('admin.pengajuan.index') }}" class="stat-card-link">
                <div class="stat-card">
                    <div class="stat-icon-wrapper" style="background-color: rgba(99, 102, 241, 0.1); color: #6366f1;">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-title">Total Pengajuan</span>
                        <span class="stat-number">{{ $jumlahPengajuan ?? 0 }}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><h5>Pengguna yang Baru Bergabung</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                         <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th class="text-center">Peran</th>
                                    <th>Bergabung Pada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penggunaTerbaru ?? [] as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-3">{{ substr($user->name, 0, 1) }}</div>
                                            <span class="fw-medium">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-light text-dark">{{ ucfirst($user->role) }}</span>
                                    </td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="fas fa-users-slash fa-2x mb-2 d-block"></i>
                                        Belum ada pengguna baru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.stat-card-link { text-decoration: none; }
.card { border: none; border-radius: 12px; box-shadow: var(--shadow); }
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.stat-card { background-color: #fff; border-radius: 12px; padding: 25px; display: flex; align-items: center; transition: all 0.3s ease; }
.stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
.stat-card .stat-icon-wrapper { font-size: 1.7rem; margin-right: 20px; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.stat-card .stat-info .stat-title { font-size: 0.9rem; color: var(--text-secondary); display: block; margin-bottom: 2px; }
.stat-card .stat-info .stat-number { font-size: 2rem; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
.avatar-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1rem; background-color: var(--light-bg); color: var(--text-primary); }
.table td, .table th { padding: 1rem 1.5rem; vertical-align: middle; }
</style>
@endsection
