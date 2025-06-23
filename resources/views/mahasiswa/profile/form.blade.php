@extends('layouts.app')

@section('title', isset($mahasiswa) && $mahasiswa->exists ? 'Edit Profil Mahasiswa' : 'Lengkapi Profil Mahasiswa - MagangKu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="h4 mb-0 py-2">{{ isset($mahasiswa) && $mahasiswa->exists ? 'Edit Profil Mahasiswa Anda' : 'Lengkapi Profil Mahasiswa Anda' }}</h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if(!isset($mahasiswa) && Auth::user()->mahasiswa)
                        <div class="alert alert-info text-center">
                            Anda sudah melengkapi profil mahasiswa. Anda bisa <a href="{{ route('mahasiswa.edit.profile') }}" class="alert-link">mengedit profil Anda di sini</a> atau kembali ke <a href="{{ route('mahasiswa.dashboard') }}" class="alert-link">dashboard</a>.
                        </div>
                    @else
                        <p class="text-muted mb-4 text-center">
                            @if(isset($mahasiswa) && $mahasiswa->exists)
                                Perbarui informasi profil Anda di bawah ini agar tetap akurat.
                            @else
                                Selamat datang, <span class="fw-bold">{{ $user->name }}</span>! Mohon lengkapi detail profil mahasiswa Anda untuk memaksimalkan peluang magang.
                            @endif
                        </p>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h5 class="alert-heading mb-2"><img src="https://placehold.co/20x20/dc3545/white?text=❗" alt="[Ikon Error]" class="me-2">Oops! Ada beberapa kesalahan:</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ isset($mahasiswa) && $mahasiswa->exists ? route('mahasiswa.update.profile') : route('mahasiswa.store.profile') }}" enctype="multipart/form-data">
                            @csrf
                            @if(isset($mahasiswa) && $mahasiswa->exists)
                                @method('PUT')
                            @endif

                            <fieldset class="mb-4">
                                <legend class="h6 mb-3 fw-bold text-primary d-flex align-items-center"><img src="https://placehold.co/20x20/007bff/white?text=👤" alt="[Ikon Akun]" class="me-2">Informasi Akun</legend>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="user_name" class="form-label">Nama Akun:</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="user_name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="user_email" class="form-label">Email Akun:</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="user_email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend class="h6 mb-3 fw-bold text-primary d-flex align-items-center"><img src="https://placehold.co/20x20/007bff/white?text=🎓" alt="[Ikon Detail Mahasiswa]" class="me-2">Detail Mahasiswa</legend>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap Mahasiswa: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap ?? $user->name) }}" required>
                                        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="nim" class="form-label">NIM (Nomor Induk Mahasiswa): <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim ?? '') }}" required>
                                        @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="universitas" class="form-label">Universitas: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('universitas') is-invalid @enderror" id="universitas" name="universitas" value="{{ old('universitas', $mahasiswa->universitas ?? '') }}" required>
                                        @error('universitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="jurusan" class="form-label">Jurusan: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" value="{{ old('jurusan', $mahasiswa->jurusan ?? '') }}" required>
                                        @error('jurusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="angkatan" class="form-label">Angkatan (Tahun Masuk): <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('angkatan') is-invalid @enderror" id="angkatan" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan ?? '') }}" required min="1980" max="{{ date('Y') + 2 }}">
                                        @error('angkatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="no_telp" class="form-label">Nomor Telepon Aktif (WhatsApp):</label>
                                        <input type="tel" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp', $mahasiswa->no_telp ?? '') }}" placeholder="Contoh: 081234567890">
                                        @error('no_telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="cv_path" class="form-label">Upload CV (PDF, max 2MB):</label>
                                    <input type="file" class="form-control @error('cv_path') is-invalid @enderror" id="cv_path" name="cv_path" accept=".pdf">
                                    @if(isset($mahasiswa) && $mahasiswa->cv_path)
                                        <small class="form-text text-muted mt-1 d-block">CV saat ini:
                                            <a href="{{ asset('storage/' . $mahasiswa->cv_path) }}" target="_blank" class="fw-medium">
                                                <img src="https://placehold.co/16x16/007bff/white?text=📄" alt="[Ikon CV]" class="me-1">Lihat CV
                                            </a>.
                                            Kosongkan jika tidak ingin mengubah.
                                        </small>
                                    @endif
                                    @error('cv_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </fieldset>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                @if(isset($mahasiswa) && $mahasiswa->exists)
                                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary me-2">
                                        <img src="https://placehold.co/16x16/6c757d/white?text=❌" alt="[Ikon Batal]" class="me-1" style="filter: invert(1);">Batal
                                    </a>
                                @endif
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <img src="https://placehold.co/16x16/ffffff/000000?text=💾" alt="[Ikon Simpan]" class="me-1" style="filter: invert(1);">
                                    {{ isset($mahasiswa) && $mahasiswa->exists ? 'Simpan Perubahan Profil' : 'Simpan & Lanjutkan' }}
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
    .card-header { border-bottom: 2px solid rgba(0,0,0,0.05) !important; }
    .form-label { font-weight: 500; color: #495057; }
    legend.h6 { font-size: 1.1rem; border-bottom: 1px solid #e0e0e0; padding-bottom: 0.6rem; margin-bottom: 1.2rem !important; color: #0056b3; }
    fieldset { padding: 1.5rem; border: 1px solid #e9ecef; border-radius: .3rem; background-color: #fdfdff; }
    .form-control:focus { border-color: #86b7fe; box-shadow: 0 0 0 .25rem rgba(0, 123, 255, .25); }
    .btn-lg { padding: .7rem 1.5rem; font-size: 1rem; }
    .btn img { vertical-align: text-bottom; }
</style>
@endpush

@push('scripts')
<script>
    // Script untuk Bootstrap alert dismissal jika menggunakan Bootstrap JS
    var alertList = document.querySelectorAll('.alert[data-bs-dismiss="alert"]')
    alertList.forEach(function (alert) {
        new bootstrap.Alert(alert)
    })
</script>
@endpush
