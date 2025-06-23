@extends('layouts.admin')

@section('title', 'Detail Perusahaan: ' . $perusahaan->nama_perusahaan)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.perusahaan.index') }}">Perusahaan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail: {{ Str::limit($perusahaan->nama_perusahaan, 25) }}</li>
@endsection

@section('admin_content')
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h1 class="h5 mb-0 text-dark-emphasis d-flex align-items-center">
                <i class="fas fa-building me-2 text-success"></i>
                Detail Perusahaan: <span class="fw-normal ms-1">{{ $perusahaan->nama_perusahaan }}</span>
            </h1>
            <div>
                <a href="{{ route('admin.perusahaan.edit', $perusahaan->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit Perusahaan
                </a>
                <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-outline-secondary btn-sm ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-4 col-lg-3 text-center mb-4 mb-md-0">
                    @if($perusahaan->logo_path && Storage::disk('public')->exists($perusahaan->logo_path))
                        <img src="{{ asset('storage/' . $perusahaan->logo_path) }}" alt="Logo {{ $perusahaan->nama_perusahaan }}" class="img-fluid rounded mb-3 border p-1 shadow-sm bg-white" style="width: 150px; height: 150px; object-fit: contain;">
                    @else
                        <img src="https://placehold.co/150x150/EBF4FF/28a745?text={{ substr(str_replace(' ', '', $perusahaan->nama_perusahaan),0,3) }}" alt="Logo Perusahaan" class="img-fluid rounded mb-3 border p-1 shadow-sm bg-white" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                    <h4 class="h6 fw-bold mb-1">{{ $perusahaan->nama_perusahaan }}</h4>
                    @if($perusahaan->website)
                        <p class="small mb-2"><a href="{{ $perusahaan->website }}" target="_blank" rel="noopener noreferrer" class="text-primary"><i class="fas fa-globe fa-xs me-1"></i> Kunjungi Website</a></p>
                    @endif
                    <span class="badge bg-success-soft text-success">{{ ucfirst($perusahaan->user->role) }} Account</span>
                </div>
                <div class="col-md-8 col-lg-9">
                    {{-- Menggunakan tabel untuk layout yang lebih rapi --}}
                    <div class="border-bottom pb-3 mb-3">
                        <h5 class="text-success mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Umum Perusahaan</h5>
                        <table class="table table-sm table-borderless detail-table">
                            <tbody>
                                <tr>
                                    <th style="width: 35%;">Email Resmi Perusahaan</th>
                                    <td>: <a href="mailto:{{ $perusahaan->email_perusahaan }}">{{ $perusahaan->email_perusahaan }}</a></td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon Kantor</th>
                                    <td>: {{ $perusahaan->nomor_telepon }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Lengkap</th>
                                    <td>: {!! nl2br(e($perusahaan->alamat)) !!}</td>
                                </tr>
                                <tr>
                                    <th>Industri</th>
                                    <td>: {{ $perusahaan->industri ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>: {!! nl2br(e($perusahaan->deskripsi)) ?: '-' !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h5 class="text-success mb-3"><i class="fas fa-user-tie me-2"></i>Informasi Kontak Akun (User)</h5>
                        <table class="table table-sm table-borderless detail-table">
                            <tbody>
                                <tr>
                                    <th style="width: 35%;">Nama Kontak Person</th>
                                    <td>: {{ $perusahaan->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email Kontak (Login)</th>
                                    <td>: <a href="mailto:{{ $perusahaan->user->email }}">{{ $perusahaan->user->email }}</a></td>
                                </tr>
                                <tr>
                                    <th>User Terdaftar Sejak</th>
                                    <td>: {{ $perusahaan->user->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <h4 class="mb-3 text-success"><i class="fas fa-list-alt me-2"></i>Lowongan dari Perusahaan Ini ({{ $perusahaan->lowongans->count() }})</h4>
            @if($perusahaan->lowongans && $perusahaan->lowongans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Judul Lowongan</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Batas Akhir</th>
                                <th scope="col" class="text-center">Pelamar</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Query dipindahkan ke controller idealnya, tapi untuk view ini bisa juga di sini
                                $lowongans = $perusahaan->lowongans()->withCount('pengajuans')->latest()->get();
                            @endphp
                            @foreach($lowongans as $index => $lowongan)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><a href="{{ route('admin.lowongan.show', $lowongan->id) }}" class="text-decoration-none fw-medium">{{ Str::limit($lowongan->judul, 30) }}</a></td>
                                <td><span class="badge bg-secondary-soft text-secondary">{{ $lowongan->jenis }}</span></td>
                                <td>{{ $lowongan->lokasi }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $lowongan->status == 'Dibuka' ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }}">
                                        {{ $lowongan->status }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $lowongan->batas_akhir_lamaran ? $lowongan->batas_akhir_lamaran->isoFormat('D MMM YYYY') : '-' }}</td>
                                <td class="text-center">{{ $lowongan->pengajuans_count }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.lowongan.show', $lowongan->id) }}" class="btn btn-outline-info btn-sm py-0 px-2" title="Lihat Detail Lowongan">
                                        <i class="fas fa-search-plus"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-light text-center">
                    <img src="https://placehold.co/80x80/EBF4FF/6c757d?text=📄" alt="[Ikon Lowongan Kosong]" class="mb-2 opacity-75">
                    <p class="mb-0 text-muted">Perusahaan ini belum memasang lowongan.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card-header h1 { font-weight: 600; }
    /* Perubahan pada detail-table */
    .detail-table th {
        font-weight: 600;
        color: #555;
        font-size: 0.9em;
        padding: .4rem 0; /* Padding atas-bawah */
        border: none !important; /* Hilangkan semua border */
        white-space: nowrap; /* Agar label tidak terpotong */
    }
    .detail-table td {
        color: #333;
        font-size: 0.9em;
        margin-bottom: .5rem;
        padding: .4rem .5rem; /* Padding atas-bawah dan kiri-kanan */
        border: none !important; /* Hilangkan semua border */
    }
    .badge { font-size: 0.85em; padding: .4em .65em; }
    .btn-sm i.fas { font-size: 0.8em; }
    .table-sm th, .table-sm td { padding: .6rem .5rem; font-size: 0.875rem;}
    .fa-xs { font-size: 0.75em; }

    /* Soft Badges */
    .bg-primary-soft { background-color: #cfe2ff; } .text-primary { color: #0a58ca !important; }
    .bg-success-soft { background-color: #d1e7dd; } .text-success { color: #0f5132 !important; }
    .bg-danger-soft { background-color: #f8d7da; } .text-danger { color: #842029 !important; }
    .bg-info-soft { background-color: #cff4fc; } .text-info { color: #055160 !important; }
    .bg-secondary-soft { background-color: #e2e3e5; } .text-secondary { color: #41464b !important; }
</style>
@endpush
