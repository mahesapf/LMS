@extends('layouts.peserta')

@section('title', 'Program Tersedia')

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
    <h1 class="mb-4">Program Tersedia</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Pendaftaran Saya -->
    @if($myRegistrations->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Pendaftaran Saya</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Tanggal Daftar</th>
                            <th>Status Pendaftaran</th>
                            <th>Status Pembayaran</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myRegistrations as $registration)
                        <tr>
                            <td>{{ $registration->program->name }}</td>
                            <td>{{ $registration->created_at->format('d M Y') }}</td>
                            <td>
                                @if($registration->status == 'payment_pending')
                                    <span class="badge bg-warning">Menunggu Pembayaran</span>
                                @elseif($registration->status == 'payment_uploaded')
                                    <span class="badge bg-info">Menunggu Validasi</span>
                                @elseif($registration->status == 'validated')
                                    <span class="badge bg-success">Tervalidasi</span>
                                @elseif($registration->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($registration->payment)
                                    @if($registration->payment->status == 'pending')
                                        <span class="badge bg-warning">Menunggu Validasi</span>
                                    @elseif($registration->payment->status == 'validated')
                                        <span class="badge bg-success">Tervalidasi</span>
                                    @elseif($registration->payment->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                        <br><small class="text-danger">{{ $registration->payment->rejection_reason }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Belum Upload</span>
                                @endif
                            </td>
                            <td>
                                @if($registration->class)
                                    {{ $registration->class->name }}
                                @else
                                    <span class="text-muted">Belum ditentukan</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Daftar Program -->
    <div class="row">
        @forelse($programs as $program)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $program->name }}</h5>
                    <p class="card-text text-muted small">
                        {{ Str::limit($program->description, 100) }}
                    </p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-calendar"></i> <strong>Mulai:</strong> {{ $program->start_date->format('d M Y') }}</li>
                        <li><i class="bi bi-calendar-check"></i> <strong>Selesai:</strong> {{ $program->end_date->format('d M Y') }}</li>
                        @if($program->registration_fee > 0)
                        <li><i class="bi bi-cash"></i> <strong>Biaya:</strong> Rp {{ number_format($program->registration_fee, 0, ',', '.') }}</li>
                        @endif
                        @if($program->financing_type)
                        <li><i class="bi bi-wallet2"></i> <strong>Pembiayaan:</strong> {{ $program->financing_type }}
                            @if($program->apbn_type) - {{ $program->apbn_type }}@endif
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('peserta.programs.show', $program) }}" class="btn btn-primary btn-sm w-100">
                        Lihat Detail & Daftar
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                Belum ada program yang tersedia saat ini.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
