@extends('layouts.admin')

@section('title', 'Kelola Lowongan')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Lowongan</li>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Daftar Lowongan</h5>
        <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Lowongan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Perusahaan</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Pelamar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowongans as $lowongan)
                    <tr>
                        <td>
                            <strong>{{ $lowongan->judul }}</strong><br>
                            <small class="text-secondary">{{ $lowongan->lokasi }}</small>
                        </td>
                        <td>{{ $lowongan->nama_perusahaan }}</td>
                        <td class="text-center"><span class="badge bg-secondary-soft">{{ $lowongan->jenis }}</span></td>
                        <td class="text-center">
                            <span class="badge {{ $lowongan->status == 'Dibuka' ? 'bg-success-soft' : 'bg-danger-soft' }}">
                                {{ $lowongan->status }}
                            </span>
                        </td>
                        <td class="text-center">{{ $lowongan->pengajuans_count }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.lowongan.show', $lowongan->id) }}" class="btn btn-outline-info" title="Lihat"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.lowongan.edit', $lowongan->id) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.lowongan.destroy', $lowongan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Tidak ada data lowongan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $lowongans->links() }}
        </div>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.btn-primary { background-color: var(--primary-blue); border-color: var(--primary-blue); font-weight: 500;}
.table thead { background-color: #f8f9fa; }
.badge { font-weight: 500; padding: .5em .9em; border-radius: 50px; }
.bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); color: #6c757d; }
.bg-success-soft { background-color: rgba(25, 135, 84, 0.1); color: #198754; }
.bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
.btn-group-sm .btn { padding: .25rem .5rem; font-size: .8rem; }
</style>
@endsection
