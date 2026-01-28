@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">{{ __('Lupa Password') }}</h5>
                </div>

                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-lock" style="font-size: 3rem; color: #ff9800;"></i>
                    </div>
                    
                    <h4 class="mb-3">Anda Lupa Password?</h4>
                    
                    <p class="text-muted mb-4">
                        Untuk keamanan akun Anda, fitur reset password telah dinonaktifkan.
                    </p>

                    <div class="alert alert-info" role="alert">
                        <h6 class="alert-heading mb-3">Hubungi Customer Service Kami</h6>
                        <p class="mb-2">
                            <strong>Silakan hubungi tim CS untuk membantu reset password Anda</strong>
                        </p>
                        <hr>
                        <p class="mb-1">
                            <i class="bi bi-telephone"></i> <strong>Telepon:</strong> <span id="phone">+62 (belum tersedia)</span>
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-envelope"></i> <strong>Email:</strong> <span id="email">cs@example.com</span>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-clock"></i> <strong>Jam Operasional:</strong> <span id="hours">Senin - Jumat, 08:00 - 17:00</span>
                        </p>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
