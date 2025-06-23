@extends('layouts.admin')

@section('title', 'Detail Lowongan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lowongan.index') }}">Lowongan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Lowongan</h5>
        <a href="{{ route('admin.lowongan.edit', $lowongan->id) }}" class="btn btn-outline-warning btn-sm">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 text-center">
                @if($lowongan->logo_perusahaan)
                    <img src="{{ asset('storage/' . $lowongan->logo_perusahaan) }}" alt="Logo" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <div class="avatar-placeholder">{{ substr($lowongan->nama_perusahaan, 0, 1) }}</div>
                @endif
            </div>
            <div class="col-md-10">
                <h2>{{ $lowongan->judul }}</h2>
                <p class="h5 text-secondary">{{ $lowongan->nama_perusahaan }}</p>
                <p class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>{{ $lowongan->lokasi }}</p>
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-md-6">
                <h6><strong>Deskripsi Pekerjaan</strong></h6>
                <p>{{ $lowongan->deskripsi }}</p>
            </div>
            <div class="col-md-6">
                <h6><strong>Kualifikasi</strong></h6>
                <p>{!! nl2br(e($lowongan->kualifikasi)) !!}</p>
            </div>
        </div>

        <div class="card bg-light mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">Jenis</small>
                        <p class="fw-bold">{{ $lowongan->jenis }}</p>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Status</small>
                        <p class="fw-bold"><span class="badge {{ $lowongan->status == 'Dibuka' ? 'bg-success' : 'bg-danger' }}">{{ $lowongan->status }}</span></p>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Batas Akhir Lamaran</small>
                        <p class="fw-bold">{{ $lowongan->batas_akhir_lamaran ? $lowongan->batas_akhir_lamaran->format('d M Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.avatar-placeholder { width: 100px; height: 100px; border-radius: 50%; background-color: var(--light-bg); display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: bold; color: var(--text-secondary); }
</style>
@endsection
