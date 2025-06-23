@extends('layouts.admin')

@section('title', 'Kelola Pengajuan Lamaran')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengajuan</li>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Daftar Pengajuan Lamaran</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Melamar Posisi</th>
                        <th>Tanggal Pengajuan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuans as $pengajuan)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">{{ substr($pengajuan->mahasiswa->user->name, 0, 1) }}</div>
                                <div>
                                    <strong>{{ $pengajuan->mahasiswa->user->name }}</strong><br>
                                    <small class="text-secondary">{{ $pengajuan->mahasiswa->nim }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $pengajuan->lowongan->judul }}</strong><br>
                            <small class="text-secondary">{{ $pengajuan->lowongan->nama_perusahaan }}</small>
                        </td>
                        <td>{{ $pengajuan->created_at->format('d M Y, H:i') }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill
                                @if($pengajuan->status == 'Diterima') bg-success-soft text-success
                                @elseif($pengajuan->status == 'Ditolak') bg-danger-soft text-danger
                                @elseif($pengajuan->status == 'Dilihat') bg-info-soft text-info
                                @else bg-secondary-soft text-secondary @endif">
                                {{ $pengajuan->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail & Proses">
                                <i class="fas fa-search-plus me-1"></i> Proses
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Tidak ada data pengajuan lamaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $pengajuans->links() }}
        </div>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.avatar-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1rem; background-color: var(--light-bg); color: var(--text-primary); }
.table thead { background-color: #f8f9fa; }
.badge { font-weight: 500; padding: .5em .9em; }
.bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); color: #6c757d; }
.bg-success-soft { background-color: rgba(25, 135, 84, 0.1); color: #198754; }
.bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
.bg-info-soft { background-color: rgba(13, 202, 240, 0.1); color: #0dcaf0; }
</style>
@endsection
