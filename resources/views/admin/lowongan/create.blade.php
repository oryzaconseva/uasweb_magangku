@extends('layouts.admin')

@section('title', 'Tambah Lowongan Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lowongan.index') }}">Lowongan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Baru</li>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-header"><h5 class="card-title mb-0">Form Tambah Lowongan</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.lowongan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.lowongan._form')
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="{{ route('admin.lowongan.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.form-label { font-weight: 500; }
.btn-primary { background-color: var(--primary-blue); border-color: var(--primary-blue); }
</style>
@endsection
