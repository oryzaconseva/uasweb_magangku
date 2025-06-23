@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-form">
    <h2>Hello Again!</h2>
    <p>Selamat datang kembali, silakan masuk.</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            Email atau password salah. Silakan coba lagi.
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="form-group">
            <i class="fa fa-envelope input-icon"></i>
            <input type="email" name="email" class="form-control" placeholder="Alamat Email" required value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <i class="fa fa-lock input-icon"></i>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn-submit">Login</button>
    </form>

    <div class="auth-switch-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>
</div>
@endsection
