@extends('layouts.admin')

@section('title', 'Detail Pengajuan Lamaran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pengajuan.index') }}">Pengajuan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('admin_content')
<div class="row">
    {{-- Kolom Detail Lowongan --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Detail Lowongan</h5></div>
            <div class="card-body">
                <h3>{{ $pengajuan->lowongan->judul }}</h3>
                <p class="text-secondary h5">{{ $pengajuan->lowongan->nama_perusahaan }}</p>
                <p class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>{{ $pengajuan->lowongan->lokasi }}</p>
                <hr>
                <div>
                    <strong>Deskripsi:</strong>
                    <p>{{ $pengajuan->lowongan->deskripsi }}</p>
                </div>
                <div>
                    <strong>Kualifikasi:</strong>
                    <p>{!! nl2br(e($pengajuan->lowongan->kualifikasi)) !!}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kolom Detail Mahasiswa & Aksi --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Detail Pelamar</h5></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-placeholder me-3">{{ substr($pengajuan->mahasiswa->nama_lengkap, 0, 1) }}</div>
                    <div>
                        <h5 class="mb-0">{{ $pengajuan->mahasiswa->nama_lengkap }}</h5>
                        <p class="text-muted mb-0">{{ $pengajuan->mahasiswa->user->email }}</p>
                    </div>
                </div>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="100px">NIM</td>
                        <td width="10px">:</td>
                        <td>{{ $pengajuan->mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        {{-- PERBAIKAN --}}
                        <td><strong>Jurusan</strong></td>
                        <td>:</td>
                        <td>{{ $pengajuan->mahasiswa->jurusan }}</td>
                    </tr>
                    <tr>
                        {{-- PERBAIKAN --}}
                        <td><strong>No. HP</strong></td>
                        <td>:</td>
                        <td>{{ $pengajuan->mahasiswa->no_telp }}</td>
                    </tr>
                </table>

                <div class="d-grid gap-2 mt-4">
                    <a href="{{ route('admin.pengajuan.downloadCv', $pengajuan->id) }}" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i> Unduh CV Mahasiswa
                    </a>
                </div>

                <hr>

                <form action="{{ route('admin.pengajuan.updateStatus', $pengajuan->id) }}" method="POST">
                     @csrf
                     @method('PUT')
                    <label for="status" class="form-label fw-bold">Ubah Status Lamaran:</label>
                    <div class="input-group">
                        <select name="status" class="form-select">
                            <option value="Diajukan" @selected($pengajuan->status == 'Diajukan')>Diajukan</option>
                            <option value="Dilihat" @selected($pengajuan->status == 'Dilihat')>Dilihat</option>
                            <option value="Diterima" @selected($pengajuan->status == 'Diterima')>Diterima</option>
                            <option value="Ditolak" @selected($pengajuan->status == 'Ditolak')>Ditolak</option>
                        </select>
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px; height: 100%;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.avatar-placeholder { width: 60px; height: 60px; border-radius: 50%; background-color: var(--light-bg); color: var(--text-primary); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; }
.table-sm td { padding: .3rem 0; }
</style>
@endsection
