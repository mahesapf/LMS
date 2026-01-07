@extends('layouts.dashboard')

@section('title', 'Detail Program')

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
        <h1>Detail Program</h1>
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
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">{{ $program->name }}</h2>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <i class="bi bi-calendar text-primary"></i>
                                <strong>Tanggal Pelaksanaan:</strong><br>
                                <span class="ms-4">{{ $program->start_date->format('d F Y') }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <i class="bi bi-calendar-check text-success"></i>
                                <strong>Tanggal Selesai:</strong><br>
                                <span class="ms-4">{{ $program->end_date->format('d F Y') }}</span>
                            </p>
                        </div>
                    </div>

                    @if($program->registration_fee > 0)
                    <div class="alert alert-info">
                        <i class="bi bi-cash-stack"></i>
                        <strong>Biaya Pendaftaran:</strong> Rp {{ number_format($program->registration_fee, 0, ',', '.') }}
                    </div>
                    @endif

                    @if($program->financing_type)
                    <div class="mb-3">
                        <p class="mb-1"><strong>Jenis Pembiayaan:</strong> {{ $program->financing_type }}</p>
                        @if($program->apbn_type)
                        <p class="mb-0"><strong>Tipe APBN:</strong> {{ $program->apbn_type }}</p>
                        @endif
                    </div>
                    @endif

                    <hr>

                    <h5>Deskripsi Program</h5>
                    <p class="text-justify">{!! nl2br(e($program->description)) !!}</p>

                    @if($program->activities->count() > 0)
                    <hr>
                    <h5>Kegiatan dalam Program</h5>
                    <ul>
                        @foreach($program->activities as $activity)
                        <li>{{ $activity->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pendaftaran</h5>
                </div>
                <div class="card-body">
                    @if($existingRegistration)
                        <div class="alert alert-info mb-0">
                            <h6>Status Pendaftaran Anda:</h6>
                            @if($existingRegistration->status == 'payment_pending')
                                <p>Menunggu pembayaran</p>
                                <a href="{{ route('peserta.payment.create', $existingRegistration) }}" class="btn btn-success btn-sm">
                                    Lanjutkan Pembayaran
                                </a>
                            @elseif($existingRegistration->status == 'payment_uploaded')
                                <p class="mb-0">Pembayaran sedang divalidasi oleh admin</p>
                            @elseif($existingRegistration->status == 'validated')
                                <p class="mb-0 text-success">
                                    <i class="bi bi-check-circle"></i> Pendaftaran tervalidasi
                                </p>
                            @elseif($existingRegistration->status == 'rejected')
                                <p class="mb-0 text-danger">
                                    <i class="bi bi-x-circle"></i> Pendaftaran ditolak
                                </p>
                            @endif
                        </div>
                    @else
                        @php
                            $paymentDeadline = $program->start_date->copy()->subWeek();
                            $canRegister = now()->lessThan($paymentDeadline);
                        @endphp

                        @if($canRegister)
                            <p class="text-muted small mb-3">
                                Batas pembayaran: {{ $paymentDeadline->format('d F Y') }}
                                <br>(1 minggu sebelum pelaksanaan)
                            </p>

                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#registrationModal">
                                <i class="bi bi-clipboard-check"></i> Daftar Sekarang
                            </button>
                        @else
                            <div class="alert alert-warning mb-0">
                                Pendaftaran sudah ditutup
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registration Modal -->
<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('peserta.programs.register', $program) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationModalLabel">Form Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select class="form-select @error('position') is-invalid @enderror" 
                                id="position" name="position" required>
                            <option value="">Pilih Jabatan</option>
                            <option value="Kepala Sekolah" {{ old('position') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                            <option value="Guru" {{ old('position') == 'Guru' ? 'selected' : '' }}>Guru</option>
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="school_name" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('school_name') is-invalid @enderror" 
                               id="school_name" name="school_name" value="{{ old('school_name', Auth::user()->institution) }}" required>
                        @error('school_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
