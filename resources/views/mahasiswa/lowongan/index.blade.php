@extends('layouts.app') {{-- Atau layout utama Anda untuk mahasiswa --}}
@section('title', 'Cari Lowongan - MagangKu')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Temukan Peluang Magang Terbaikmu</h1>
        <p class="lead text-muted">Jelajahi berbagai lowongan yang tersedia dan mulailah karirmu.</p>
    </div>

    <div class="row g-4">
        @forelse ($lowongans as $lowongan)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm card-hover-zoom">
                    @if($lowongan->logo_perusahaan)
                        <div class="text-center pt-4">
                            <img src="{{ asset('storage/' . $lowongan->logo_perusahaan) }}" alt="Logo {{ $lowongan->nama_perusahaan }}" style="max-height: 50px; width: auto;">
                        </div>
                    @else
                        <div class="text-center pt-4">
                             <div class="avatar-placeholder">{{ substr($lowongan->nama_perusahaan, 0, 1) }}</div>
                        </div>
                    @endif

                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $lowongan->judul }}</h5>
                        <p class="card-text text-muted mb-2">{{ $lowongan->nama_perusahaan }}</p>
                        <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>{{ $lowongan->lokasi }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                         <a href="{{ route('mahasiswa.lowongan.show', $lowongan->id) }}" class="btn btn-primary w-100">Lihat Detail & Lamar</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search-dollar fa-4x text-muted mb-3"></i>
                    <h4 class="fw-bold">Belum Ada Lowongan</h4>
                    <p class="text-muted">Saat ini belum ada lowongan yang tersedia. Silakan cek kembali nanti.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $lowongans->links() }}
    </div>
</div>

<style>
.card-hover-zoom {
    transition: all 0.3s ease;
}
.card-hover-zoom:hover {
    transform: scale(1.03);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}
.avatar-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #e9ecef;
    color: #495057;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
}
</style>
@endsection
