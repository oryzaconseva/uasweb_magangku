<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- PERBAIKAN: Mengambil judul dari variabel $settings --}}
    <title>@yield('title', 'MagangKu') - {{ $settings['site_name'] ?? 'MagangKu' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            color: var(--text-primary);
        }

        .navbar {
            background-color: var(--white-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .navbar-brand {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--primary-blue-dark) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .navbar-brand .logo-icon {
            margin-right: 10px;
            color: var(--primary-blue);
        }

        .btn-logout {
            background: var(--primary-blue);
            color: #fff !important;
            font-weight: 500;
            border-radius: 8px;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background: var(--primary-blue-dark);
            transform: translateY(-2px);
        }

        .nav-link.btn-dashboard {
             border: 1px solid var(--primary-blue);
             color: var(--primary-blue) !important;
             font-weight: 500;
             border-radius: 8px;
             padding: 0.5rem 1rem !important;
             margin-right: 10px;
        }
        .nav-link.btn-dashboard:hover {
            background: var(--primary-blue);
            color: #fff !important;
        }

        .main-content {
            min-height: 80vh;
        }

        .footer {
            text-align: center;
            padding: 1.5rem 0;
            background-color: var(--white-bg);
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand" href="{{ route('mahasiswa.dashboard') }}">
                    <i class="fas fa-graduation-cap logo-icon"></i>
                     {{-- PERBAIKAN: Mengambil nama situs dari variabel $settings --}}
                    <span>{{ $settings['site_name'] ?? 'MagangKu' }}</span>
                </a>
                <div class="d-flex align-items-center">
                     <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link btn-dashboard">Dashboard</a>
                     <form action="{{ route('logout.submit') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                             <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger">{{ session('error') }}</div>
            </div>
        @endif
        @if(session('info'))
            <div class="container mt-3">
                <div class="alert alert-info">{{ session('info') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer mt-auto">
        <div class="container">
             {{-- PERBAIKAN: Mengambil nama situs dari variabel $settings --}}
            &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'MagangKu' }} - Oryza Conseva. All Rights Reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
