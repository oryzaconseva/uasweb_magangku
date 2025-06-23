@extends('layouts.app') {{-- Atau layout utama Anda untuk mahasiswa --}}
@section('title', 'Detail Lamaran Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Lamaran Anda</h5>
                    <a href="{{ route('mahasiswa.pengajuan.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h3 class="fw-bold">{{ $pengajuan->lowongan->judul }}</h3>
                            <p class="text-muted fs-5">{{ $pengajuan->lowongan->nama_perusahaan }}</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <label class="small text-muted">Status Lamaran</label>
                            <div class="badge fs-6 rounded-pill
                                @if($pengajuan->status == 'Diterima') bg-success
                                @elseif($pengajuan->status == 'Ditolak') bg-danger
                                @else bg-info @endif">
                                {{ $pengajuan->status }}
                            </div>
                        </div>
                    </div>

                    <p class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>{{ $pengajuan->lowongan->lokasi }}</p>
                    <p class="text-muted"><i class="fas fa-briefcase me-2"></i>{{ $pengajuan->lowongan->jenis }}</p>
                    <hr>

                    <h5 class="mt-4">CV yang Anda Kirim</h5>
                    <div class="card bg-light border">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-file-pdf fa-2x text-danger me-2"></i>
                                <span class="fw-medium">Dokumen CV Anda</span>
                            </div>
                            {{-- Menggunakan nama rute yang baru dan unik --}}
                            <a href="{{ route('mahasiswa.pengajuan.cv.download', $pengajuan->id) }}" class="btn btn-primary">
                                <i class="fas fa-download me-2"></i> Lihat/Unduh CV
                            </a>
                        </div>
                    </div>

                    @if($pengajuan->status == 'Diajukan')
                    <div class="mt-4">
                        <form action="{{ route('mahasiswa.pengajuan.destroy', $pengajuan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan lamaran ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Batalkan Lamaran</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
