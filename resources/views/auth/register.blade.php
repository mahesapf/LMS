@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('content')
<div class="auth-wrapper">
    <div class="auth-left"></div>
    <div class="auth-right">
        <div class="auth-card">
            <div class="auth-card-header">
                <img src="{{ asset('storage/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Tut Wuri Handayani" class="auth-logo">
                <h4>Daftar Akun Baru</h4>
                <p>Sistem Informasi Penjaminan Mutu</p>
            </div>

    <div class="auth-card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="auth-form-group">
                <label for="name" class="auth-form-label">Nama Lengkap</label>
                <input id="name" type="text" class="auth-form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Masukkan nama lengkap">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="email" class="auth-form-label">Email Address</label>
                <input id="email" type="email" class="auth-form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password" class="auth-form-label">Password</label>
                <input id="password" type="password" class="auth-form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password-confirm" class="auth-form-label">Konfirmasi Password</label>
                <input id="password-confirm" type="password" class="auth-form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password">
            </div>

            <button type="submit" class="auth-btn-primary">
                Daftar
            </button>

            <div class="auth-footer-text">
                Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
@endsection
