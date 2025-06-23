@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Baru</li>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-header"><h5 class="card-title mb-0">Form Tambah Pengguna Baru</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-12 form-group">
                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>
                 <div class="col-md-6 form-group">
                    <label for="role" class="form-label">Peran (Role) <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        <option value="mahasiswa" @selected(old('role') == 'mahasiswa')>Mahasiswa</option>
                        <option value="admin" @selected(old('role') == 'admin')>Admin</option>
                    </select>
                </div>
                 <div class="col-md-6 form-group">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.form-label { font-weight: 500; }
</style>
@endsection
