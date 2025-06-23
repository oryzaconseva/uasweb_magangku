@extends('layouts.admin')

@section('title', 'Kelola Mahasiswa')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Mahasiswa</li>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Daftar Profil Mahasiswa</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Jurusan</th>
                        <th class="text-center">Angkatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $mahasiswa)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">{{ substr($mahasiswa->user->name, 0, 1) }}</div>
                                <div>
                                    <strong>{{ $mahasiswa->user->name }}</strong><br>
                                    <small class="text-secondary">{{ $mahasiswa->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $mahasiswa->nim }}</td>
                        {{-- PERBAIKAN: Menggunakan nama kolom yang benar --}}
                        <td>{{ $mahasiswa->jurusan }}</td>
                        <td class="text-center">{{ $mahasiswa->angkatan }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.mahasiswa.show', $mahasiswa->id) }}" class="btn btn-outline-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Tidak ada data profil mahasiswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $mahasiswas->links() }}
        </div>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.avatar-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1rem; background-color: var(--light-bg); color: var(--text-primary); }
.table thead { background-color: #f8f9fa; }
</style>
@endsection
