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
                <a href="{{ route('login') }}" class="position-absolute top-0 end-0 m-3" style="text-decoration: none;" title="Kembali">
                    <button class="btn btn-outline-secondary btn-sm" type="button" style="color: #374151 !important;">
                        <i class="bi bi-arrow-left" style="color: #374151 !important;"></i>
                    </button>
                </a>
                <img src="{{ asset('storage/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Tut Wuri Handayani" class="auth-logo">
                <h4>Lupa Password?</h4>
                <p>Hubungi Customer Service Kami</p>
            </div>

            <div class="auth-card-body">
                <div class="bg-light p-4 rounded-3 border border-light shadow-sm mb-4">
                    <h6 class="text-dark fw-bold mb-3">Hubungi Tim Customer Service</h6>
                    
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="text-primary me-3">
                                <i class="bi bi-telephone fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Telepon</small>
                                <span class="text-dark fw-semibold" id="phone">+62 (belum tersedia)</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="text-primary me-3">
                                <i class="bi bi-envelope fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span class="text-dark fw-semibold" id="email">cs@example.com</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex align-items-center">
                            <div class="text-primary me-3">
                                <i class="bi bi-clock fs-5"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Jam Operasional</small>
                                <span class="text-dark fw-semibold" id="hours">Senin - Jumat, 08:00 - 17:00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info d-flex align-items-start" role="alert">
                    <i class="bi bi-info-circle me-2 flex-shrink-0 mt-1"></i>
                    <div class="small">
                        <strong>Perhatian:</strong> Untuk reset password, silakan hubungi CS dengan menyertakan informasi akun Anda.
                    </div>
                </div>

                <a href="{{ route('login') }}" class="auth-btn-primary w-100">
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
