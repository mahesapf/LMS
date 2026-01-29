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
                <img src="{{ asset('images/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Tut Wuri Handayani" class="auth-logo">
                <h4>Lupa Password?</h4>
                <p>Hubungi Customer Service Kami</p>
            </div>

            <div class="auth-card-body">
                <!-- Informasi Header -->
                <div class="mb-5 text-center">
                    <p class="text-muted mb-0">
                        Untuk keperluan reset password, silakan hubungi tim Customer Service kami. Tim kami siap membantu Anda 24/7.
                    </p>
                </div>

                <!-- Contact Information Grid -->
                <div class="row g-3 mb-5">
                    <!-- Telepon -->
                    <div class="col-12">
                        <div class="contact-box p-3 rounded-2 border border-light-subtle bg-light">
                            <div class="d-flex align-items-start">
                                <div class="contact-icon me-3 mt-1">
                                    <i class="bi bi-telephone text-primary fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-dark fw-bold mb-1">Telepon</h6>
                                    <p class="text-muted small mb-0" id="phone">+62 (belum tersedia)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-12">
                        <div class="contact-box p-3 rounded-2 border border-light-subtle bg-light">
                            <div class="d-flex align-items-start">
                                <div class="contact-icon me-3 mt-1">
                                    <i class="bi bi-envelope text-primary fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-dark fw-bold mb-1">Email</h6>
                                    <p class="text-muted small mb-0" id="email">cs@example.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="col-12">
                        <div class="contact-box p-3 rounded-2 border border-light-subtle bg-light">
                            <div class="d-flex align-items-start">
                                <div class="contact-icon me-3 mt-1">
                                    <i class="bi bi-clock-history text-primary fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-dark fw-bold mb-1">Jam Operasional</h6>
                                    <p class="text-muted small mb-0" id="hours">Senin - Jumat, 08:00 - 17:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Steps Information -->
                <div class="bg-light rounded-2 p-4 border border-light-subtle">
                    <h6 class="text-dark fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-list-check text-primary me-2"></i>
                        Langkah Mengajukan Reset Password:
                    </h6>
                    <ol class="small text-muted ps-3 mb-0">
                        <li class="mb-2">Hubungi Customer Service melalui telepon atau email</li>
                        <li class="mb-2">Siapkan informasi akun Anda (email/NPSN yang terdaftar)</li>
                        <li class="mb-2">Verifikasi identitas sesuai instruksi CS</li>
                        <li>Tim CS akan melakukan reset password untuk Anda</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
