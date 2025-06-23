{{-- ========================================================================= --}}
{{-- File: resources/views/mahasiswa/pengajuan/index.blade.php --}}
{{-- ========================================================================= --}}
@extends('layouts.app')
@section('title', 'Riwayat Pengajuan Lamaran')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap"><h1 class="h3 mb-2 mb-md-0 text-dark">Riwayat Pengajuan Lamaran Saya</h1><a href="{{ route('mahasiswa.lowongan.index') }}" class="btn btn-sm btn-primary"><i class="fas fa-search me-1"></i> Cari Lowongan Baru</a></div>
    <div class="card shadow-sm"><div class="card-header bg-light border-0 py-3"><h6 class="mb-0 fw-medium"><i class="fas fa-history me-2"></i>Daftar Lamaran yang Telah Anda Kirim</h6></div>
        <div class="card-body p-0">
            @if(session('success'))<div class="alert alert-success m-3">{{ session('success') }}</div>@endif
            @if($pengajuans->count() > 0)
                <div class="table-responsive"><table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th scope="col">Lowongan</th><th scope="col">Perusahaan</th><th class="text-center">Tanggal</th><th class="text-center">Status</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                        @foreach ($pengajuans as $pengajuan)
                        <tr>
                            <td><a href="{{ $pengajuan->lowongan ? route('mahasiswa.lowongan.show', $pengajuan->lowongan_id) : '#' }}" class="fw-semibold">{{ Str::limit($pengajuan->lowongan->judul ?? 'Lowongan Dihapus', 40) }}</a></td>
                            <td>{{ $pengajuan->lowongan->nama_perusahaan ?? 'N/A' }}</td>
                            <td class="text-center">{{ $pengajuan->tanggal_pengajuan->isoFormat('D MMM YY') }}</td>
                            <td class="text-center"><span class="badge rounded-pill @if($pengajuan->status == 'Diterima') bg-success-soft text-success @elseif(in_array($pengajuan->status, ['Ditolak', 'Tidak Memenuhi Syarat'])) bg-danger-soft text-danger @else bg-secondary-soft text-secondary @endif">{{ $pengajuan->status }}</span></td>
                            <td class="text-end"><a href="{{ route('mahasiswa.pengajuan.show', $pengajuan->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2">Lihat Detail</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table></div>
                @if($pengajuans->hasPages())<div class="card-footer">{{ $pengajuans->links() }}</div>@endif
            @else
                <div class="text-center p-5"><p class="text-muted mb-0">Anda belum memiliki riwayat pengajuan.</p></div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('styles')<style>.table th { font-weight: 600; font-size: 0.9rem; } .table td { font-size: 0.9rem; }</style>@endpush
