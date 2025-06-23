@extends('layouts.app')

@section('title', 'Edit Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Edit Profil Anda</h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('mahasiswa.update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3">Informasi Pribadi</h5>
                        <div class="row g-3">
                            <div class="col-12 form-group">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap ?? Auth::user()->name) }}" required>
                            </div>
                             <div class="col-md-6 form-group">
                                <label for="no_telp" class="form-label">Nomor Handphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_telp" value="{{ old('no_telp', $mahasiswa->no_telp ?? '') }}" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Informasi Akademik</h5>
                        <div class="row g-3">
                            <div class="col-12 form-group">
                                <label for="universitas" class="form-label">Universitas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="universitas" value="{{ old('universitas', $mahasiswa->universitas ?? '') }}" required>
                            </div>
                             <div class="col-md-6 form-group">
                                <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nim" value="{{ old('nim', $mahasiswa->nim ?? '') }}" required>
                            </div>
                             <div class="col-md-6 form-group">
                                <label for="jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jurusan" value="{{ old('jurusan', $mahasiswa->jurusan ?? '') }}" required>
                            </div>
                             <div class="col-md-6 form-group">
                                <label for="angkatan" class="form-label">Angkatan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan ?? '') }}" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Dokumen</h5>
                        <div class="row g-3">
                            <div class="col-12 form-group">
                                <label for="cv" class="form-label">Upload CV Baru (PDF, maks 2MB)</label>
                                <input type="file" class="form-control" name="cv" accept=".pdf">
                                @if(isset($mahasiswa) && $mahasiswa->cv_path)
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah CV yang sudah ada.</small>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
