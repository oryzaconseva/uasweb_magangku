@extends('layouts.admin')

@section('title', 'Edit Data Perusahaan: ' . $perusahaan->nama_perusahaan)

@section('breadcrumb')
    <li style="margin-left:5px;"><span>/</span></li>
    <li style="margin-left:5px;"><a href="{{ route('admin.perusahaan.index') }}">Perusahaan</a></li>
    <li style="margin-left:5px;"><span>/</span></li>
    <li style="margin-left:5px;"><a href="{{ route('admin.perusahaan.show', $perusahaan->id) }}">{{ Str::limit($perusahaan->nama_perusahaan, 20) }}</a></li>
    <li style="margin-left:5px;"><span>/</span></li>
    <li style="margin-left:5px;"><span>Edit</span></li>
@endsection

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h2 style="margin:0;">Edit Data Perusahaan: {{ $perusahaan->nama_perusahaan }}</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5 class="alert-heading">Oops! Ada kesalahan:</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.perusahaan.update', $perusahaan->id) }}" enctype="multipart/form-data"> {{-- Tambah enctype untuk upload logo --}}
                @csrf
                @method('PUT')

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="w-auto px-2 h5" style="font-size: 1.2rem;">Informasi Akun Kontak (User)</legend>
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nama Kontak Person:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email Kontak (Untuk Login):</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </fieldset>

                <fieldset class="mb-4 p-3 border rounded">
                    <legend class="w-auto px-2 h5" style="font-size: 1.2rem;">Informasi Detail Perusahaan</legend>
                    <div class="form-group mb-3">
                        <label for="nama_perusahaan" class="form-label">Nama Resmi Perusahaan:</label>
                        <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan) }}" required>
                        @error('nama_perusahaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="email_perusahaan" class="form-label">Email Resmi Perusahaan (Korespondensi):</label>
                        <input type="email" class="form-control @error('email_perusahaan') is-invalid @enderror" id="email_perusahaan" name="email_perusahaan" value="{{ old('email_perusahaan', $perusahaan->email_perusahaan) }}" required>
                        @error('email_perusahaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="nomor_telepon" class="form-label">Nomor Telepon Kantor:</label>
                        <input type="tel" class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', $perusahaan->nomor_telepon) }}" required placeholder="Contoh: 021-xxxxxxx">
                        @error('nomor_telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap Perusahaan:</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $perusahaan->alamat) }}</textarea>
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="website" class="form-label">Website Perusahaan (Opsional):</label>
                        <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $perusahaan->website) }}" placeholder="https://www.contoh.com">
                        @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="industri" class="form-label">Industri (Opsional):</label>
                        <input type="text" class="form-control @error('industri') is-invalid @enderror" id="industri" name="industri" value="{{ old('industri', $perusahaan->industri) }}" placeholder="Contoh: Teknologi Informasi">
                        @error('industri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Singkat Perusahaan (Opsional):</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $perusahaan->deskripsi) }}</textarea>
                        @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                     <div class="form-group mb-3">
                        <label for="logo_path" class="form-label">Logo Perusahaan (Opsional, max 1MB):</label>
                        <input type="file" class="form-control @error('logo_path') is-invalid @enderror" id="logo_path" name="logo_path" accept="image/png, image/jpeg, image/jpg, image/webp">
                        @if($perusahaan->logo_path)
                            <small class="form-text text-muted">Logo saat ini: <a href="{{ asset('storage/' . $perusahaan->logo_path) }}" target="_blank">Lihat Logo</a>. Kosongkan jika tidak ingin mengubah.</small>
                        @endif
                        @error('logo_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </fieldset>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.perusahaan.show', $perusahaan->id) }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <img src="https://placehold.co/16x16/ffffff/000000?text=💾" alt="Simpan" style="filter: invert(1); margin-right: 5px;"> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card-header h2 { font-size: 1.5rem; }
    .form-label { font-weight: 500; }
    .border.rounded { border-color: #dee2e6 !important; }
    legend { font-weight: 600; }
</style>
@endpush
