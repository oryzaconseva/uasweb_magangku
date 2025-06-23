<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lowongan - {{ config('settings.site_name', 'MagangKu') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0d6efd;
            --primary-blue-dark: #0a4b9e;
            --light-bg: #f5f7fa;
            --white-bg: #ffffff;
            --text-primary: #343a40;
            --text-secondary: #6c757d;
            --border-color: #e9ecef;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
        }
        .navbar-public {
            background-color: var(--white-bg);
            box-shadow: var(--shadow);
        }
        .navbar-brand {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--primary-blue-dark) !important;
        }
        .section-header {
            padding: 60px 0;
            background-color: #eef5ff;
        }
        .section-title {
            font-weight: 700;
        }
        .lowongan-section {
            padding: 60px 0;
        }
        .card-lowongan {
            background-color: var(--white-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }
        .card-lowongan:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        .card-lowongan .card-body {
            padding: 1.5rem;
        }
        .footer {
            background-color: var(--text-primary);
            color: #ccc;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-public">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand" href="{{ route('home.public') }}">
                <i class="fas fa-graduation-cap me-2"></i>{{ config('settings.site_name', 'MagangKu') }}
            </a>
            <div>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register.form') }}" class="btn btn-primary">Register</a>
                @endguest
                @auth
                     <a href="{{ route('dashboard') }}" class="btn btn-outline-primary me-2">Dashboard</a>
                     <form action="{{ route('logout.submit') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <header class="section-header text-center">
        <div class="container">
            <h1 class="section-title">Temukan Peluang Magang Terbaikmu</h1>
            <p class="lead text-muted">Jelajahi berbagai lowongan yang tersedia dan mulailah karirmu.</p>
        </div>
    </header>

    <section class="lowongan-section">
        <div class="container">
            <div class="row g-4">
                @forelse ($lowongans as $lowongan)
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-lowongan h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $lowongan->judul }}</h5>
                                <p class="card-text text-secondary mb-2">{{ $lowongan->nama_perusahaan }}</p>
                                <p class="card-text small text-muted"><i class="fas fa-map-marker-alt me-2"></i>{{ $lowongan->lokasi }}</p>
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $lowongan->jenis }}</span>
                            </div>
                            <div class="card-footer bg-transparent border-0 p-3">
                                <a href="{{ route('lowongan.show.public', $lowongan->id) }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <p class="text-muted">Saat ini belum ada lowongan yang tersedia.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $lowongans->links() }}
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('settings.site_name', 'MagangKu') }}. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
