@extends('layouts.admin')

@section('title', 'Edit Profil Mahasiswa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-header"><h5 class="card-title mb-0">Form Edit Profil: {{ $mahasiswa->nama_lengkap }}</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6 form-group">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}" required>
                </div>
                 <div class="col-md-6 form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $mahasiswa->user->email }}" disabled readonly>
                </div>
                <div class="col-md-6 form-group">
                    <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="universitas" class="form-label">Universitas <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="universitas" value="{{ old('universitas', $mahasiswa->universitas) }}" required>
                </div>
                 <div class="col-md-6 form-group">
                    <label for="jurusan" class="form-label">Jurusan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="jurusan" value="{{ old('jurusan', $mahasiswa->jurusan) }}" required>
                </div>
                 <div class="col-md-6 form-group">
                    <label for="angkatan" class="form-label">Angkatan <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" required>
                </div>
                 <div class="col-md-6 form-group">
                    <label for="no_telp" class="form-label">No. Handphone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="no_telp" value="{{ old('no_telp', $mahasiswa->no_telp) }}" required>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.form-label { font-weight: 500; }
.form-control:disabled { background-color: #f8f9fa; }
</style>
@endsection
