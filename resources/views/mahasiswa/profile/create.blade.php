@extends('layouts.app')

@section('title', 'Lengkapi Profil Anda')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light text-center py-4">
                    <h4 class="mb-0">Selamat Datang, {{ Auth::user()->name }}!</h4>
                    <p class="text-muted mb-0">Mohon lengkapi profil Anda untuk melanjutkan.</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('mahasiswa.store.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h5 class="mb-3">Informasi Akademik</h5>
                        <div class="row g-3">
                             <div class="col-md-6 form-group">
                                <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nim" value="{{ old('nim') }}" required>
                            </div>
                             <div class="col-md-6 form-group">
                                <label for="prodi" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="prodi" value="{{ old('prodi') }}" required>
                            </div>
                             <div class="col-md-6 form-group">
                                <label for="tahun_masuk" class="form-label">Tahun Masuk <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="tahun_masuk" placeholder="Contoh: 2021" value="{{ old('tahun_masuk') }}" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Informasi Kontak & Dokumen</h5>
                        <div class="row g-3">
                            <div class="col-12 form-group">
                                <label for="universitas" class="form-label">Nama Universitas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="universitas" value="{{ old('universitas') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="no_hp" class="form-label">Nomor Handphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp') }}" required>
                            </div>
                            <div class="col-12 form-group">
                                <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                            </div>
                            <div class="col-12 form-group">
                                <label for="cv" class="form-label">Upload CV (PDF, maks 2MB) <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="cv" accept=".pdf" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Profil & Lanjutkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
