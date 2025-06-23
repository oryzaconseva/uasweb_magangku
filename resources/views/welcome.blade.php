<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di {{ config('settings.site_name', 'MagangKu') }}</title>

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
            background-color: var(--white-bg);
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
        .hero-section {
            background: linear-gradient(135deg, var(--primary-blue-dark), var(--primary-blue));
            color: white;
            padding: 120px 0;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 800;
        }
        .hero-section p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto;
        }
        .btn-primary-custom {
            background-color: #fff;
            color: var(--primary-blue);
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background-color: #f0f0f0;
            transform: translateY(-3px);
        }
        .lowongan-section {
            padding: 80px 0;
            background-color: var(--light-bg);
        }
        .section-title {
            font-weight: 700;
            margin-bottom: 40px;
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
        .footer a {
            color: #fff;
            text-decoration: none;
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
                {{-- PERBAIKAN: Menampilkan tombol sesuai status login --}}
                @guest
                    {{-- Tombol untuk pengunjung yang belum login --}}
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endguest

                @auth
                    {{-- Tombol untuk pengguna yang sudah login --}}
                     <a href="{{ route('dashboard') }}" class="btn btn-outline-primary me-2">Dashboard</a>
                     <form action="{{ route('logout.submit') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <h1 class="mb-3">Langkah Awal Karir Impianmu</h1>
            <p class="mb-4">{{ config('settings.site_description', 'Temukan dan lamar ribuan peluang magang dari perusahaan terbaik di Indonesia. Mulai petualangan karirmu bersama kami!') }}</p>
            <a href="#lowongan" class="btn btn-primary-custom">Lihat Lowongan Terbaru</a>
        </div>
    </section>

    <section class="lowongan-section" id="lowongan">
        <div class="container">
            <h2 class="text-center section-title">Lowongan Terbaru</h2>
            <div class="row g-4">
                @forelse ($lowonganTerbaru as $lowongan)
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
            <div class="text-center mt-5">
                <a href="{{ route('lowongan.index.public') }}" class="btn btn-primary">Lihat Semua Lowongan</a>
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
