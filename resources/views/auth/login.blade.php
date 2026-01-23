@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('content')
<div class="auth-wrapper">
    <div class="auth-left"></div>
    <div class="auth-right">
        <div class="auth-card">
            <div class="auth-card-header position-relative">
                <a href="{{ url('/') }}" class="position-absolute top-0 end-0 m-3" style="text-decoration: none;" title="Kembali">
                    <button class="btn btn-outline-secondary btn-sm" type="button" style="color: #374151 !important;">
                        <i class="bi bi-arrow-left" style="color: #374151 !important;"></i>
                    </button>
                </a>
                <img src="{{ asset('storage/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Tut Wuri Handayani" class="auth-logo">
                <h4>Login ke Akun Anda</h4>
                <p>Sistem Informasi Penjaminan Mutu</p>
            </div>

    <div class="auth-card-body">
        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Terjadi Kesalahan</h3>
                        <div class="text-sm text-red-700">
                            {!! session('error') !!}
                        </div>
                    </div>
                    <button type="button" class="ml-3 flex-shrink-0 text-red-400 hover:text-red-600 transition-colors" onclick="this.parentElement.parentElement.remove()">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-emerald-500 shadow-md">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-base font-bold text-emerald-900 mb-2">Pendaftaran Berhasil!</h3>
                        <div class="text-sm text-emerald-800 leading-relaxed space-y-2">
                            <p class="font-medium">Akun Anda sedang menunggu persetujuan dari administrator.</p>
                            <p>Silakan cek email Anda untuk notifikasi persetujuan.</p>
                        </div>
                    </div>
                    <button type="button" class="ml-3 flex-shrink-0 text-emerald-400 hover:text-emerald-600 transition-colors" onclick="this.parentElement.parentElement.remove()">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-semibold text-red-800 mb-2">Mohon perbaiki kesalahan berikut:</h3>
                        <ul class="space-y-1 text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="ml-3 flex-shrink-0 text-red-400 hover:text-red-600 transition-colors" onclick="this.parentElement.parentElement.remove()">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="auth-form-group">
                <label for="email" class="auth-form-label">Email atau NPSN</label>
                <input id="email" type="text" class="auth-form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus maxlength="100" placeholder="Email atau NPSN">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password" class="auth-form-label">Password</label>
                <input id="password" type="password" class="auth-form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" minlength="8" maxlength="255" placeholder="••••••••">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="remember-forgot-wrapper">
                <div class="auth-checkbox">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Ingat Saya</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link">Lupa Password?</a>
                @endif
            </div>

            <button type="submit" class="auth-btn-primary">
                Login
            </button>

            <div class="auth-footer-text text-center mt-3">
                <small class="text-muted">
                    Sekolah belum punya akun?
                    <a href="{{ route('sekolah.register') }}" class="auth-link">Daftar di sini</a>
                </small>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>
@endsection
