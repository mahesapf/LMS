@extends('layouts.dashboard')

@section('title', 'Pembayaran')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('peserta.dashboard') }}">Dashboard</a>
    <a class="nav-link active" href="{{ route('peserta.programs.index') }}">Program Tersedia</a>
    <a class="nav-link" href="{{ route('peserta.profile') }}">Profil</a>
    <a class="nav-link" href="{{ route('peserta.classes') }}">Kelas & Nilai Saya</a>
    <a class="nav-link" href="{{ route('peserta.documents') }}">Dokumen</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Pembayaran Pendaftaran</h1>
        <a href="{{ route('peserta.programs.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('peserta.payment.store', $registration) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                   id="bank_name" name="bank_name" value="{{ old('bank_name') }}" 
                                   placeholder="Contoh: BCA, Mandiri, BNI" required>
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah yang Dibayar <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                       id="amount" name="amount" value="{{ old('amount', $registration->program->registration_fee) }}" 
                                       min="0" step="0.01" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Biaya pendaftaran: Rp {{ number_format($registration->program->registration_fee, 0, ',', '.') }}
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                                   id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" 
                                   max="{{ date('Y-m-d') }}" required>
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="proof_file" class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('proof_file') is-invalid @enderror" 
                                   id="proof_file" name="proof_file" accept="image/*" required>
                            @error('proof_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Format: JPG, JPEG, PNG. Maksimal 2MB
                            </small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Perhatian:</strong> Pembayaran harus dilakukan maksimal 1 minggu sebelum program dimulai 
                            ({{ $registration->program->start_date->copy()->subWeek()->format('d F Y') }})
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Upload Bukti Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <h6>Program</h6>
                    <p class="fw-bold">{{ $registration->program->name }}</p>

                    <h6>Data Pendaftar</h6>
                    <table class="table table-sm">
                        <tr>
                            <td>Nama</td>
                            <td>: {{ $registration->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: {{ $registration->email }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>: {{ $registration->phone }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>: {{ $registration->position }}</td>
                        </tr>
                        <tr>
                            <td>Sekolah</td>
                            <td>: {{ $registration->nama_sekolah }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Informasi Pembayaran</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Rekening Tujuan:</strong></p>
                    <p class="mb-2">Bank BCA<br>No. Rek: 1234567890<br>A.n. LMS Program</p>
                    <hr>
                    <p class="mb-1"><strong>Jumlah:</strong></p>
                    <h4 class="text-primary">Rp {{ number_format($registration->program->registration_fee, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
