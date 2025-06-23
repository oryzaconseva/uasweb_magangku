@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="auth-form">
    <h2>Hello!</h2>
    <p>Silakan mendaftar untuk memulai.</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div class="form-group">
            <i class="fa fa-user input-icon"></i>
            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <i class="fa fa-envelope input-icon"></i>
            <input type="email" name="email" class="form-control" placeholder="Alamat Email" required value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <i class="fa fa-lock input-icon"></i>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="form-group">
            <i class="fa fa-lock input-icon"></i>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
        </div>
        <button type="submit" class="btn-submit">Register</button>
    </form>

    <div class="auth-switch-link">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
</div>
@endsection
