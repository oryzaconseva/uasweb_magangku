<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- PERBAIKAN: Mengambil judul dari database --}}
    <title>@yield('title') - {{ config('settings.site_name', 'MagangKu') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        :root {
            --primary-blue: #0d6efd;
            --gradient-start: #0a4b9e;
            --gradient-end: #1a7cfd;
            --light-gray: #f8f9fa;
            --text-color: #6c757d;
            --dark-text: #343a40;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #eef5ff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .auth-container {
            display: flex;
            width: 1000px;
            max-width: 90%;
            min-height: 600px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .auth-left-panel {
            flex: 1;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: #fff;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .auth-left-panel::before {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .auth-left-panel::after {
            content: '';
            position: absolute;
            bottom: 50px;
            left: 150px;
            width: 100px;
            height: 100px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .auth-left-panel h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .auth-left-panel p {
            font-size: 1.1rem;
            opacity: 0.8;
            line-height: 1.6;
        }

        .auth-left-panel .btn-read-more {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: #fff;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            margin-top: 20px;
            width: fit-content;
        }
        .auth-left-panel .btn-read-more:hover {
            background: #fff;
            color: var(--primary-blue);
        }

        .auth-right-panel {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-form h2 {
            color: var(--dark-text);
            font-weight: 600;
            font-size: 1.5rem;
        }

        .auth-form p {
            color: var(--text-color);
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group .form-control {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-group .form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .form-group .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: #fff;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }
        .btn-submit:hover {
             transform: translateY(-2px);
             box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
        }

        .auth-switch-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .auth-switch-link a {
            color: var(--primary-blue);
            font-weight: 600;
            text-decoration: none;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-left-panel">
            {{-- PERBAIKAN: Mengambil nama situs dan deskripsi dari database --}}
            <h1>{{ config('settings.site_name', 'MagangKu') }}</h1>
            <p>{{ config('settings.site_description', 'Platform terdepan untuk menghubungkan mahasiswa berbakat dengan peluang magang impian di seluruh Indonesia.') }}</p>
            <a href="{{ route('home.public') }}" class="btn-read-more">Jelajahi Lowongan</a>
        </div>
        <div class="auth-right-panel">
            @yield('content')
        </div>
    </div>
</body>
</html>
