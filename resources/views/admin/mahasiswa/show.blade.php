@extends('layouts.admin')

@section('title', 'Detail Profil Mahasiswa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Profil: {{ $mahasiswa->nama_lengkap }}</h5>
        <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-outline-warning btn-sm">
            <i class="fas fa-edit me-2"></i>Edit Profil
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                 <div class="avatar-placeholder-lg mb-3">{{ substr($mahasiswa->nama_lengkap, 0, 1) }}</div>
                 @if($mahasiswa->cv_path)
                    {{-- Anda bisa membuat rute khusus untuk admin mengunduh CV jika diperlukan --}}
                 @else
                    <span class="badge bg-danger">CV Belum Diunggah</span>
                 @endif
            </div>
            <div class="col-md-9">
                <h3>{{ $mahasiswa->nama_lengkap }}</h3>
                <p class="text-secondary mb-4">{{ $mahasiswa->user->email }}</p>

                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="150"><strong>NIM</strong></td>
                        <td>: {{ $mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <td><strong>Universitas</strong></td>
                        <td>: {{ $mahasiswa->universitas }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jurusan</strong></td>
                        <td>: {{ $mahasiswa->jurusan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Angkatan</strong></td>
                        <td>: {{ $mahasiswa->angkatan }}</td>
                    </tr>
                    <tr>
                        <td><strong>No. Handphone</strong></td>
                        <td>: {{ $mahasiswa->no_telp }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.avatar-placeholder-lg {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background-color: var(--light-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    font-weight: bold;
    color: var(--text-secondary);
    margin: 0 auto;
}
.table-sm td { padding: .5rem 0; }
</style>
@endsection
