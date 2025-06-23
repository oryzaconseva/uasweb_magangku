@extends('layouts.admin')

@section('title', 'Pengaturan Situs')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengaturan</li>
@endsection

@section('admin_content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pengaturan Umum</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Pengaturan Nama Situs --}}
                    <div class="mb-4">
                        <label for="site_name" class="form-label">Nama Situs</label>
                        {{-- PERBAIKAN: Mengambil nilai langsung dari variabel $settings --}}
                        <input type="text" id="site_name" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'MagangKu' }}">
                        <small class="form-text text-muted">Nama ini akan muncul di judul halaman dan header.</small>
                    </div>

                    {{-- Pengaturan Email Kontak --}}
                    <div class="mb-4">
                        <label for="contact_email" class="form-label">Email Kontak</label>
                        <input type="email" id="contact_email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'contact@magangku.com' }}">
                        <small class="form-text text-muted">Email yang akan dihubungi oleh pengunjung untuk pertanyaan.</small>
                    </div>

                    {{-- Pengaturan Deskripsi Singkat --}}
                    <div class="mb-3">
                        <label for="site_description" class="form-label">Deskripsi Singkat Situs</label>
                        <textarea id="site_description" name="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? 'Platform untuk menghubungkan mahasiswa dengan peluang magang impian.' }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
         <div class="card">
             <div class="card-body">
                <h5 class="card-title">Tentang Halaman Ini</h5>
                <p class="text-secondary small">
                    Halaman ini memungkinkan Anda untuk mengelola konfigurasi dasar situs Anda secara langsung dari dasbor.
                </p>
                <p class="text-secondary small">
                    Perubahan yang Anda simpan di sini akan langsung diterapkan di seluruh bagian situs yang relevan setelah disimpan.
                </p>
             </div>
         </div>
    </div>
</div>

<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.form-label { font-weight: 500; }
</style>
@endsection
