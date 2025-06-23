@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0 fw-bold">Dashboard</h1>
    </div>

    {{-- Kartu Statistik --}}
    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('mahasiswa.edit.profile') }}" class="stat-card-link">
                <div class="stat-card">
                    <div class="stat-icon" style="color: #0d6efd;"><i class="fas fa-user-circle"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ Auth::user()->name }}</span>
                        <span class="stat-title">Profil Anda</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('mahasiswa.pengajuan.index') }}" class="stat-card-link">
                <div class="stat-card">
                    <div class="stat-icon" style="color: #198754;"><i class="fas fa-file-signature"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $jumlahPengajuan ?? 0 }}</span>
                        <span class="stat-title">Total Pengajuan</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-12">
            <a href="{{ route('mahasiswa.lowongan.index') }}" class="stat-card-link">
                <div class="stat-card">
                    <div class="stat-icon" style="color: #ffc107;"><i class="fas fa-briefcase"></i></div>
                    <div class="stat-info">
                        <span class="stat-number">{{ $jumlahLowonganTersedia ?? 0 }}</span>
                        <span class="stat-title">Lowongan Tersedia</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Daftar Pengajuan Lamaran Terbaru --}}
    <div class="card mt-5">
        <div class="card-header">
            <h5 class="mb-0">Riwayat Lamaran Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Posisi</th>
                            <th>Perusahaan</th>
                            <th>Tanggal Pengajuan</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuanTerbaru ?? [] as $pengajuan)
                            <tr>
                                <td><strong>{{ $pengajuan->lowongan->judul ?? 'Lowongan Dihapus' }}</strong></td>
                                <td>{{ $pengajuan->lowongan->nama_perusahaan ?? '-' }}</td>
                                <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill
                                        @if($pengajuan->status == 'Diterima') bg-success
                                        @elseif($pengajuan->status == 'Ditolak') bg-danger
                                        @else bg-secondary @endif">
                                        {{ $pengajuan->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                    Anda belum pernah mengajukan lamaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.stat-card-link { text-decoration: none; color: inherit; }
.stat-card {
    background-color: var(--white-bg);
    border-radius: 12px;
    padding: 25px;
    display: flex;
    align-items: center;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    border-color: var(--primary-blue);
}
.stat-icon { font-size: 2.5rem; margin-right: 20px; }
.stat-info .stat-number { font-size: 1.5rem; font-weight: 600; display: block; }
.stat-info .stat-title { font-size: 0.9rem; color: var(--text-secondary); }
.card { border-radius: 12px; border: none; box-shadow: var(--shadow); }
.card-header { background-color: #f8f9fa; border-bottom: 1px solid var(--border-color); }
.table > :not(caption) > * > * { padding: 1rem 1.25rem; }
.badge { font-size: 0.8rem; font-weight: 500; }
</style>
@endsection
