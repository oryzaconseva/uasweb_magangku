@extends('layouts.admin')

@section('title', 'Detail Pengguna: ' . $user->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@push('styles')
<style>
    .profile-card {
        border-radius: var(--radius-xl);
        border: 1px solid var(--slate-200);
        /* Diubah: Latar belakang putih solid diganti dengan gradien lembut */
        background: linear-gradient(160deg, rgba(37, 99, 235, 0.05) 0%, rgba(255, 255, 255, 0) 60%);
        overflow: hidden; /* Memastikan gradien tidak keluar dari sudut melengkung */
    }
    .profile-header {
        padding: 2rem;
        border-bottom: 1px solid var(--slate-200);
        display: flex;
        align-items: center;
        /* Diubah: Diberi latar semi-transparan untuk efek kedalaman */
        background-color: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 2.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        margin-right: 1.5rem;
        flex-shrink: 0;
    }
    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--slate-800);
    }
    .profile-email {
        font-size: 1rem;
        color: var(--slate-600);
    }
    .info-section {
        padding: 2rem;
    }
    .info-list {
        list-style: none;
        padding: 0;
    }
    .info-list li {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
    }
    .info-list li:not(:last-child) {
        border-bottom: 1px dashed var(--slate-200);
    }
    .info-list .info-label {
        font-weight: 600;
        color: var(--slate-600);
    }
    .info-list .info-value {
        color: var(--slate-800);
        font-weight: 500;
        text-align: right;
    }
    .role-tag {
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.4em 0.8em;
    }
     .btn-gradient-primary {
        background: linear-gradient(90deg, var(--blue-600), var(--blue-700));
        border: none;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }
    .btn-gradient-primary:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(37, 99, 235, 0.4);
    }
</style>
@endpush

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold text-dark-emphasis">Detail Pengguna</h1>
            <p class="text-muted">Informasi lengkap mengenai akun pengguna.</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 me-2">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-gradient-primary rounded-pill px-4 py-2">
                <i class="fas fa-edit me-2"></i> Edit Pengguna
            </a>
        </div>
    </div>

    <div class="card profile-card shadow-sm">
        <div class="profile-header">
            <div class="profile-avatar" style="background: linear-gradient(45deg, {{ $user->role == 'admin' ? '#ef4444' : '#2563eb' }}, {{ $user->role == 'admin' ? '#f87171' : '#60a5fa' }});">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h5 class="profile-name mb-0">{{ $user->name }}</h5>
                <span class="profile-email">{{ $user->email }}</span>
            </div>
        </div>

        <div class="row g-0">
            <div class="col-lg-6">
                <div class="info-section">
                    <h6 class="text-uppercase text-muted fw-bold small mb-4">Detail Akun</h6>
                    <ul class="info-list">
                        <li>
                            <span class="info-label">ID Pengguna</span>
                            <span class="info-value">{{ $user->id }}</span>
                        </li>
                        <li>
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-value">{{ $user->name }}</span>
                        </li>
                         <li>
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $user->email }}</span>
                        </li>
                        <li>
                            <span class="info-label">Peran</span>
                            <span class="info-value">
                                <span class="badge rounded-pill role-tag @if($user->role == 'admin') bg-danger-soft @else bg-primary-soft @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </span>
                        </li>
                        <li>
                            <span class="info-label">Tanggal Bergabung</span>
                            <span class="info-value">{{ $user->created_at->isoFormat('dddd, D MMMM YYYY') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6" style="border-left: 1px solid var(--slate-200);">
                <div class="info-section">
                    <h6 class="text-uppercase text-muted fw-bold small mb-4">Profil Mahasiswa Terkait</h6>
                    @if ($user->mahasiswa)
                        <ul class="info-list">
                            <li>
                                <span class="info-label">NIM</span>
                                <span class="info-value">{{ $user->mahasiswa->nim }}</span>
                            </li>
                            <li>
                                <span class="info-label">Universitas</span>
                                <span class="info-value">{{ $user->mahasiswa->universitas }}</span>
                            </li>
                             <li>
                                <span class="info-label">Jurusan</span>
                                <span class="info-value">{{ $user->mahasiswa->jurusan }}</span>
                            </li>
                             <li>
                                <span class="info-label">Angkatan</span>
                                <span class="info-value">{{ $user->mahasiswa->angkatan }}</span>
                            </li>
                             <li>
                                <span class="info-label">Lihat Profil Lengkap</span>
                                <span class="info-value">
                                    <a href="{{ route('admin.mahasiswa.show', $user->mahasiswa->id) }}" class="fw-bold">
                                        Lihat Detail <i class="fas fa-arrow-right small"></i>
                                    </a>
                                </span>
                            </li>
                        </ul>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-user-times fa-3x mb-3"></i>
                            <p>Pengguna ini tidak memiliki profil mahasiswa.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
