{{-- ========================================================================= --}}
{{-- File: resources/views/mahasiswa/lowongan/show.blade.php --}}
{{-- ========================================================================= --}}
@extends('layouts.app')
@section('title', Str::limit($lowongan->judul, 50))
@section('content')
<div class="container py-5"><div class="row"><div class="col-lg-8">
    <div class="card shadow-sm"><div class="card-body p-4 p-md-5">
        <div class="d-flex align-items-start mb-4">
            <img src="{{ $lowongan->logo_perusahaan ? asset('storage/' . $lowongan->logo_perusahaan) : 'https://placehold.co/80x80/4A90E2/FFFFFF?text=' . substr($lowongan->nama_perusahaan, 0, 1) }}" alt="Logo" class="me-4 rounded border p-1" style="width: 80px; height: 80px; object-fit: contain;">
            <div><h1 class="h3 fw-bold mb-1">{{ $lowongan->judul }}</h1><p class="text-muted fs-5">{{ $lowongan->nama_perusahaan }}</p></div>
        </div>
        <div class="mb-4 pb-3 border-bottom"><h5 class="text-dark-emphasis mb-3"><i class="fas fa-file-alt me-2 text-primary"></i>Deskripsi Pekerjaan</h5><div class="text-content">{!! nl2br(e($lowongan->deskripsi)) !!}</div></div>
        <div class="mb-4"><h5 class="text-dark-emphasis mb-3"><i class="fas fa-bullseye me-2 text-primary"></i>Kualifikasi</h5><div class="text-content">{!! nl2br(e($lowongan->kualifikasi)) !!}</div></div>
    </div></div>
</div><div class="col-lg-4">
    <div class="card shadow-sm sticky-md-top" style="top: 100px;">
        <div class="card-header bg-light"><h6 class="mb-0 fw-medium">Informasi & Aksi</h6></div>
        <div class="card-body">
            <dl class="detail-list"><dt>Lokasi</dt><dd>{{ $lowongan->lokasi }}</dd><dt>Jenis</dt><dd>{{ $lowongan->jenis }}</dd><dt>Status</dt><dd><span class="badge {{ $lowongan->status == 'Dibuka' ? 'bg-success' : 'bg-danger' }}">{{ $lowongan->status }}</span></dd>
            @if($lowongan->batas_akhir_lamaran)<dt>Batas Akhir</dt><dd class="text-danger fw-bold">{{ $lowongan->batas_akhir_lamaran->format('d F Y') }}</dd>@endif</dl>
            @php $sudahMelamar = Auth::check() && Auth::user()->mahasiswa ? Auth::user()->mahasiswa->pengajuans()->where('lowongan_id', $lowongan->id)->exists() : false; @endphp
            @if($lowongan->status == 'Dibuka')
                @if($sudahMelamar)<button class="btn btn-secondary w-100 disabled"><i class="fas fa-check-circle me-2"></i>Anda Sudah Melamar</button>
                @else<a href="{{ route('mahasiswa.pengajuan.create', $lowongan->id) }}" class="btn btn-primary w-100 btn-lg"><i class="fas fa-paper-plane me-2"></i> Lamar Sekarang</a>@endif
            @else<button class="btn btn-secondary w-100 disabled">Lowongan Ditutup</button>@endif
        </div>
    </div>
</div></div></div>
@endsection
@push('styles')<style>.text-dark-emphasis { color: #343a40; } .text-content { font-size: 0.95rem; line-height: 1.7; } .detail-list dt { font-weight: 600; font-size: 0.9em; } .detail-list dd { margin-bottom: 1rem; }</style>@endpush
