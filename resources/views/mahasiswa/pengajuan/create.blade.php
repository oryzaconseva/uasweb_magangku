@extends('layouts.app')
@section('title', 'Lamar Lowongan - ' . $lowongan->judul)

@section('content')
<div class="container py-5">
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-light border-0 py-4">
                <h2 class="h4 mb-0 text-center text-dark">Formulir Lamaran Lowongan</h2>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h3 class="h5 mb-1">{{ $lowongan->judul }}</h3>
                    <p class="text-muted mb-0">{{ $lowongan->nama_perusahaan }}</p>
                </div>

                <form method="POST" action="{{ route('mahasiswa.pengajuan.store', $lowongan->id) }}">
                    @csrf

                    {{-- PERBAIKAN: Menggunakan relasi user untuk mendapatkan nama --}}
                    <div class="alert alert-info small p-3 mb-4">
                        <strong>Pelamar:</strong> {{ $mahasiswa->user->name }} ({{ $mahasiswa->user->email }})
                        <br>
                        <small>Pastikan data di profil Anda sudah yang terbaru.</small>
                    </div>

                    {{-- Form ini tidak memerlukan input tambahan karena data diambil dari profil --}}
                    <div class="text-center">
                        <p>Anda akan mengirimkan lamaran untuk posisi ini menggunakan CV yang tersimpan di profil Anda.</p>
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('mahasiswa.lowongan.show', $lowongan->id) }}" class="btn btn-outline-secondary">&laquo; Kembali</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Lamaran Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
