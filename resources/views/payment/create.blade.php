@extends('layouts.app')

@section('title', 'Upload Bukti Pembayaran')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Upload Bukti Pembayaran</h4>
                </div>
                <div class="card-body">
                    <!-- Activity Info -->
                    <div class="alert alert-info mb-4">
                        <h5 class="alert-heading">Informasi Kegiatan</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Kegiatan:</strong> {{ $registration->activity->name }}</p>
                                <p class="mb-1"><strong>Program:</strong> {{ $registration->activity->program->name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Biaya Pendaftaran:</strong></p>
                                <h4 class="text-primary mb-0">
                                    @if($registration->activity->registration_fee > 0)
                                        Rp {{ number_format($registration->activity->registration_fee, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Info -->
                    <div class="mb-4">
                        <h5>Data Pendaftaran Anda</h5>
                        <table class="table table-sm">
                            <tr>
                                <th width="30%">Nama</th>
                                <td>{{ $registration->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $registration->email }}</td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>{{ $registration->phone }}</td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>{{ $registration->position }}</td>
                            </tr>
                            <tr>
                                <th>Sekolah</th>
                                <td>{{ $registration->school_name }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Payment Form -->
                    <form action="{{ route('payment.store', $registration) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" 
                                   value="{{ old('bank_name') }}" placeholder="Contoh: BCA, Mandiri, BNI" required>
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Transfer <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                   value="{{ old('amount', $registration->activity->registration_fee) }}" 
                                   min="0" step="0.01" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Masukkan jumlah yang Anda transfer.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" 
                                   value="{{ old('payment_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file" name="proof_file" class="form-control @error('proof_file') is-invalid @enderror" 
                                   accept="image/*" required>
                            @error('proof_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Upload foto/scan bukti transfer. Format: JPG, PNG (Max: 2MB)
                            </small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Perhatian:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Pastikan bukti transfer yang diupload jelas dan dapat dibaca</li>
                                <li>Pembayaran akan divalidasi oleh super admin</li>
                                <li>Anda akan menjadi peserta setelah pembayaran divalidasi</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Upload Bukti Pembayaran
                            </button>
                            <a href="{{ route('activities.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
