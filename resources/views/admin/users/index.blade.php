@extends('layouts.admin')

@section('title', 'Kelola Pengguna Sistem')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Daftar Pengguna</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Tambah Pengguna
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th class="text-center">Peran</th>
                        <th>Tanggal Terdaftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3" style="background-color: #e9ecef;">{{ substr($user->name, 0, 1) }}</div>
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill {{ $user->role == 'admin' ? 'bg-danger-soft text-danger' : 'bg-primary-soft text-primary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                {{-- Tombol hapus sebaiknya tidak menghapus admin yang sedang login --}}
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Tidak ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $users->links() }}
        </div>
    </div>
</div>
<style>
.card { border: none; box-shadow: var(--shadow); border-radius: 12px;}
.card-header { background-color: transparent; border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
.avatar-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1rem; }
.table thead { background-color: #f8f9fa; }
.badge { font-weight: 500; padding: .5em .9em; }
.bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; }
.bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
</style>
@endsection
