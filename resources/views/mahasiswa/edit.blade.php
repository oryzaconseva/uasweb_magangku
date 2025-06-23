@extends('layouts.app')

@section('title', 'Edit Profil Mahasiswa - MagangKu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">Edit Profil Mahasiswa Anda</h2>
                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-sm btn-outline-light">&laquo; Kembali ke Dashboard</a>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Perbarui informasi profil Anda di bawah ini. Pastikan data yang Anda masukkan akurat.
                    </p>

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
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif


                    <form method="POST" action="{{ route('mahasiswa.update.profile') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Method untuk update --}}

                        <fieldset class="mb-4">
                            <legend class="h6 mb-3 fw-bold text-primary">Informasi Akun</legend>
                            <div class="form-group mb-3">
                                <label for="user_name" class="form-label">Nama Akun:</label>
                                {{-- Nama akun biasanya tidak diubah oleh user, tapi bisa ditampilkan atau diizinkan edit oleh admin --}}
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="user_name" name="name" value="{{ old('name', $user->name) }}" required>
                                 @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="user_email" class="form-label">Email Akun:</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="user_email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                             {{-- Pertimbangkan untuk halaman ganti password terpisah --}}
                        </fieldset>

                        <fieldset>
                            <legend class="h6 mb-3 fw-bold text-primary">Detail Mahasiswa</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap Mahasiswa:</label>
                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}" required>
                                        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nim" class="form-label">NIM (Nomor Induk Mahasiswa):</label>
                                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required>
                                        @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="universitas" class="form-label">Universitas:</label>
                                        <input type="text" class="form-control @error('universitas') is-invalid @enderror" id="universitas" name="universitas" value="{{ old('universitas', $mahasiswa->universitas) }}" required>
                                        @error('universitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="jurusan" class="form-label">Jurusan:</label>
                                        <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" value="{{ old('jurusan', $mahasiswa->jurusan) }}" required>
                                        @error('jurusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="angkatan" class="form-label">Angkatan (Tahun Masuk):</label>
                                        <input type="number" class="form-control @error('angkatan') is-invalid @enderror" id="angkatan" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" required min="1980" max="{{ date('Y') + 2 }}">
                                        @error('angkatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="no_telp" class="form-label">Nomor Telepon Aktif (WhatsApp):</label>
                                        <input type="tel" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp', $mahasiswa->no_telp) }}" placeholder="Contoh: 081234567890">
                                        @error('no_telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Contoh untuk CV:
                            <div class="form-group mb-3">
                                <label for="cv_path" class="form-label">Upload CV Baru (PDF, max 2MB) (Opsional):</label>
                                <input type="file" class="form-control @error('cv_path') is-invalid @enderror" id="cv_path" name="cv_path" accept=".pdf">
                                @if($mahasiswa->cv_path)
                                    <small class="form-text text-muted">CV saat ini: <a href="{{ asset('storage/' . $mahasiswa->cv_path) }}" target="_blank">Lihat CV</a>. Kosongkan jika tidak ingin mengubah.</small>
                                @endif
                                @error('cv_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            --}}
                        </fieldset>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <img src="https://placehold.co/16x16/ffffff/000000?text=💾" alt="Simpan" style="filter: invert(1); margin-right: 5px;">
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
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
    legend.h6 { font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem !important; }
    fieldset { padding: 1.5rem; border: 1px solid #e0e0e0; border-radius: .25rem; }
</style>
@endpush
