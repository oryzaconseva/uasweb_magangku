@extends('layouts.app')

@section('title', 'Lamar Lowongan: ' . $lowongan->judul)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Formulir Lamaran Lowongan</h2>
                </div>
                <div class="card-body">
                    <h3 class="h5 mb-3">{{ $lowongan->judul }}</h3>
                    <p class="text-muted">Perusahaan: <strong>{{ $lowongan->perusahaan->nama_perusahaan }}</strong></p>
                    <p class="text-muted mb-4">Lokasi: {{ $lowongan->lokasi }} | Jenis: {{ $lowongan->jenis }}</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h5 class="alert-heading">Oops! Ada beberapa kesalahan:</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!$mahasiswa)
                        <div class="alert alert-warning">
                            Profil mahasiswa Anda tidak ditemukan atau belum lengkap. Mohon <a href="{{ route('mahasiswa.create.profile') }}">lengkapi profil Anda</a> terlebih dahulu sebelum melamar.
                        </div>
                    @elseif(Auth::user()->mahasiswa->pengajuans()->where('lowongan_id', $lowongan->id)->exists())
                        <div class="alert alert-info">
                            Anda sudah pernah melamar untuk lowongan ini. Anda bisa melihat status lamaran Anda di <a href="{{ route('mahasiswa.pengajuan.index') }}">halaman pengajuan saya</a>.
                        </div>
                    @elseif($lowongan->status !== 'Dibuka')
                        <div class="alert alert-warning">
                            Maaf, lowongan ini sudah ditutup.
                        </div>
                    @else
                        <form method="POST" action="{{ route('mahasiswa.pengajuan.store', $lowongan->id) }}" enctype="multipart/form-data">
                            @csrf
                            {{-- Tidak perlu field mahasiswa_id karena diambil dari Auth::user() di controller --}}

                            <div class="form-group mb-3">
                                <label for="nama_pelamar" class="form-label">Nama Pelamar:</label>
                                <input type="text" class="form-control" id="nama_pelamar" value="{{ $mahasiswa->nama_lengkap ?: Auth::user()->name }}" readonly>
                                <small class="form-text text-muted">Nama diambil dari profil Anda.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email_pelamar" class="form-label">Email Kontak:</label>
                                <input type="email" class="form-control" id="email_pelamar" value="{{ Auth::user()->email }}" readonly>
                                <small class="form-text text-muted">Email diambil dari akun Anda.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="surat_lamaran" class="form-label">Surat Lamaran / Motivasi Diri <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('surat_lamaran') is-invalid @enderror" id="surat_lamaran" name="surat_lamaran" rows="8" required placeholder="Tuliskan mengapa Anda tertarik dan cocok untuk lowongan ini...">{{ old('surat_lamaran') }}</textarea>
                                @error('surat_lamaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="cv_path" class="form-label">Unggah CV (PDF/DOC/DOCX, max 2MB):</label>
                                <input type="file" class="form-control @error('cv_path') is-invalid @enderror" id="cv_path" name="cv_path" accept=".pdf,.doc,.docx">
                                @error('cv_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted">Pastikan CV Anda terbaru dan relevan.</small>
                            </div>

                            {{-- Anda bisa menambahkan field untuk portofolio atau dokumen pendukung lainnya di sini --}}
                            {{--
                            <div class="form-group mb-3">
                                <label for="portofolio_url" class="form-label">Link Portofolio (Opsional):</label>
                                <input type="url" class="form-control @error('portofolio_url') is-invalid @enderror" id="portofolio_url" name="portofolio_url" value="{{ old('portofolio_url') }}" placeholder="https://contohportofolio.com">
                                @error('portofolio_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            --}}

                            <div class="alert alert-info small mt-4">
                                Dengan mengirimkan lamaran ini, Anda menyatakan bahwa semua informasi yang diberikan adalah benar dan akurat.
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('mahasiswa.lowongan.show', $lowongan->id) }}" class="btn btn-outline-secondary">
                                    &laquo; Kembali ke Detail Lowongan
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <img src="https://placehold.co/16x16/ffffff/000000?text=✉️" alt="Kirim" style="filter: invert(1); margin-right: 5px;"> Kirim Lamaran Saya
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header { border-bottom: 0; }
    .form-label { font-weight: 500; }
    .form-control[readonly] { background-color: #e9ecef; opacity: 1; }
</style>
@endpush
