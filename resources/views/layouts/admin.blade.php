<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- PERBAIKAN: Mengambil judul dari variabel $settings --}}
    <title>@yield('title', 'Admin Dashboard') - {{ $settings['site_name'] ?? 'MagangKu' }}</title>

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
            --sidebar-bg: #ffffff;
            --text-primary: #343a40;
            --text-secondary: #6c757d;
            --border-color: #e9ecef;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            margin: 0;
            padding: 0;
            color: var(--text-primary);
        }

        .admin-wrapper {
            display: flex;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
            transition: width 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-header .logo-icon {
            font-size: 2rem;
            color: var(--primary-blue);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: var(--primary-blue-dark);
        }

        .sidebar-nav {
            flex-grow: 1;
            padding: 20px 0;
        }

        .sidebar-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            padding: 0 20px;
        }

        .nav-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            padding: 15px 0 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .nav-link i {
            width: 20px;
            margin-right: 15px;
            font-size: 1rem;
        }

        .nav-link:hover {
            background-color: var(--light-bg);
            color: var(--text-primary);
        }

        .nav-link.active {
            background: linear-gradient(90deg, var(--primary-blue), var(--primary-blue-dark));
            color: #fff;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
        }

        .logout-btn {
             background: none;
             border: none;
             width: 100%;
             text-align: left;
             cursor: pointer;
        }

        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 30px;
            transition: all 0.3s ease;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .breadcrumb ol {
            padding: 0;
            margin: 0;
            background: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .breadcrumb .breadcrumb-item {
            font-size: 0.9rem;
        }
        .breadcrumb .breadcrumb-item a {
             color: var(--text-secondary);
             text-decoration: none;
        }
        .breadcrumb .breadcrumb-item.active {
             color: var(--text-primary);
             font-weight: 500;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-profile .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-blue);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .alert {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-graduation-cap logo-icon"></i>
                {{-- PERBAIKAN: Mengambil nama situs dari variabel $settings --}}
                <h2>{{ $settings['site_name'] ?? 'MagangKu' }}</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item">
                        <p class="nav-title">Utama</p>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <p class="nav-title">Manajemen</p>
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Pengguna</span>
                        </a>
                         <a href="{{ route('admin.mahasiswa.index') }}" class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                            <i class="fas fa-user-graduate"></i>
                            <span>Mahasiswa</span>
                        </a>
                        <a href="{{ route('admin.lowongan.index') }}" class="nav-link {{ request()->routeIs('admin.lowongan.*') ? 'active' : '' }}">
                            <i class="fas fa-briefcase"></i>
                            <span>Lowongan</span>
                        </a>
                         <a href="{{ route('admin.pengajuan.index') }}" class="nav-link {{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Pengajuan</span>
                        </a>
                    </li>
                     <li class="nav-item">
                        <p class="nav-title">Lainnya</p>
                        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <i class="fas fa-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <form action="{{ route('logout.submit') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link logout-btn">
                         <i class="fas fa-sign-out-alt"></i>
                         <span>Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header class="main-header">
                <nav aria-label="breadcrumb" class="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
                <div class="user-profile">
                    <span>Halo, <strong>{{ Auth::user()->name }}</strong></span>
                    <div class="avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <main>
                 @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                @endif

                @yield('admin_content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
