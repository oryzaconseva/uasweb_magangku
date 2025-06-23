@extends('layouts.admin')

@section('title', 'Kelola Data Perusahaan - Admin MagangKu')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.perusahaan.index') }}">Perusahaan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar</li>
@endsection

@section('admin_content')
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h1 class="h5 mb-0 text-dark-emphasis"><i class="fas fa-building me-2 text-success"></i>Daftar Semua Perusahaan Terdaftar</h1>
            {{-- Admin biasanya tidak menambah perusahaan via form umum, perusahaan mendaftar sendiri.
                 Jika admin perlu membuat akun user + profil perusahaan, maka perlu controller dan view create terpisah.
            <a href="#" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Data Perusahaan
            </a>
            --}}
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="GET" action="{{ route('admin.perusahaan.index') }}" class="mb-4 p-3 border rounded bg-light-subtle">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6 col-lg-5">
                        <label for="search" class="form-label small fw-medium">Cari Perusahaan:</label>
                        <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Nama perusahaan, email, industri..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label for="industri_filter" class="form-label small fw-medium">Filter Industri:</label>
                        <input type="text" name="industri" id="industri_filter" class="form-control form-control-sm" placeholder="Contoh: Teknologi" value="{{ request('industri') }}">
                    </div>
                    <div class="col-md-12 col-lg-4 d-flex mt-3 mt-lg-0 align-items-end">
                        <button class="btn btn-primary btn-sm w-100 me-2" type="submit">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                           <i class="fas fa-sync-alt me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            @if($perusahaans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%;">No.</th>
                                <th scope="col" style="width: 25%;">Nama Perusahaan</th>
                                <th scope="col" style="width: 20%;">Email Kontak</th>
                                <th scope="col" style="width: 20%;">Email Resmi Perusahaan</th>
                                <th scope="col" style="width: 15%;">Industri</th>
                                <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perusahaans as $index => $perusahaan)
                            <tr>
                                <td class="text-center">{{ $perusahaans->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($perusahaan->logo_path && Storage::disk('public')->exists($perusahaan->logo_path))
                                            <img src="{{ asset('storage/' . $perusahaan->logo_path) }}" alt="Logo" class="rounded me-2" style="width: 32px; height: 32px; object-fit: contain; border:1px solid #eee;">
                                        @else
                                            <img src="https://placehold.co/32x32/EBF4FF/28a745?text={{ substr(str_replace(' ', '', $perusahaan->nama_perusahaan),0,1) }}" alt="Logo" class="rounded me-2" style="width: 32px; height: 32px; object-fit: contain;">
                                        @endif
                                        <div>
                                            <span class="fw-medium">{{ Str::limit($perusahaan->nama_perusahaan, 35) }}</span>
                                            @if($perusahaan->website)
                                                <a href="{{ $perusahaan->website }}" target="_blank" rel="noopener noreferrer" class="d-block small text-muted" title="{{$perusahaan->website}}">
                                                    <i class="fas fa-globe fa-xs me-1"></i> Website
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $perusahaan->user->email ?? 'N/A' }}
                                    <small class="d-block text-muted">{{ $perusahaan->user->name ?? '' }}</small>
                                </td>
                                <td>{{ $perusahaan->email_perusahaan ?: '-' }}</td>
                                <td>{{ $perusahaan->industri ?: '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Aksi Perusahaan">
                                        <a href="{{ route('admin.perusahaan.show', $perusahaan->id) }}" class="btn btn-outline-info" title="Lihat Detail Perusahaan">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.perusahaan.edit', $perusahaan->id) }}" class="btn btn-outline-warning" title="Edit Data Perusahaan">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.perusahaan.destroy', $perusahaan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data perusahaan ini? Ini juga akan menghapus akun pengguna terkait, semua lowongan, dan semua pengajuan lamaran pada lowongan perusahaan ini.');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus Data Perusahaan">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $perusahaans->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <img src="https://placehold.co/100x100/EBF4FF/28a745?text=🏢" alt="[Ikon Perusahaan Kosong]" class="mb-3 opacity-75">
                    <h5 class="text-muted">Tidak ada data perusahaan yang ditemukan.</h5>
                     @if(request('search') || request('industri'))
                        <p class="text-muted">Coba reset filter <a href="{{ route('admin.perusahaan.index') }}" class="alert-link">di sini</a>.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card-header h1 { font-weight: 600; }
    .table thead.table-dark th { background-color: #343a40; color: #fff; border-color: #454d55; font-size: 0.85rem; }
    .table th, .table td { vertical-align: middle; font-size: 0.875rem; }
    .btn-group-sm > .btn i.fas { font-size: 0.85em; }
    .bg-light-subtle { background-color: #f8f9fa !important; }
    .form-label.small { font-size: 0.8rem; margin-bottom: 0.25rem; }
    .fa-xs { font-size: 0.7em; } /* Ukuran ikon kecil untuk link website */
</style>
@endpush
