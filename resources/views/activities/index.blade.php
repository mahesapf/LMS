@extends('layouts.app')

@section('title', 'Kegiatan Tersedia')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Kegiatan Tersedia</h1>

    @if(!Auth::check())
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle"></i>
            <strong>Informasi:</strong> Anda dapat mendaftar kegiatan tanpa harus login. Cukup isi formulir pendaftaran sekolah dan lakukan pembayaran.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- My Registrations -->
    @if($myRegistrations->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Kegiatan Saya</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kegiatan</th>
                            <th>Sekolah</th>
                            <th>Peserta</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myRegistrations as $registration)
                        <tr>
                            <td>{{ $registration->activity->name }}</td>
                            <td>{{ $registration->nama_sekolah }}</td>
                            <td>
                                {{ $registration->jumlah_peserta > 0 ? $registration->jumlah_peserta : ($registration->jumlah_kepala_sekolah + $registration->jumlah_guru) }} orang
                            </td>
                            <td>{{ $registration->activity->start_date->format('d M Y') }}</td>
                            <td>
                                @if($registration->status == 'pending')
                                    <span class="badge bg-secondary">Pending</span>
                                @elseif($registration->status == 'payment_pending')
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
                                @if($registration->status == 'payment_pending' && !$registration->payment)
                                    <a href="{{ route('payment.create', $registration) }}" class="btn btn-sm btn-primary">
                                        Upload Pembayaran
                                    </a>
                                @else
                                    <a href="{{ route('activities.show', $registration->activity) }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Detail
                                    </a>
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

    <!-- Available Activities -->
    <div class="row">
        <div class="col-12 mb-4">
            <h3>Kegiatan Tersedia untuk Pendaftaran</h3>
        </div>
        
        @forelse($activities as $activity)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $activity->name }}</h5>
                    @if($activity->program)
                        <p class="text-muted small mb-2">
                            <i class="bi bi-folder"></i> {{ $activity->program->name }}
                        </p>
                    @endif
                    @if($activity->description)
                        <p class="card-text">{{ Str::limit($activity->description, 100) }}</p>
                    @endif
                    
                    <ul class="list-unstyled small">
                        <li class="mb-1">
                            <i class="bi bi-calendar"></i> 
                            <strong>Mulai:</strong> {{ $activity->start_date->format('d M Y') }}
                        </li>
                        <li class="mb-1">
                            <i class="bi bi-calendar-check"></i> 
                            <strong>Selesai:</strong> {{ $activity->end_date->format('d M Y') }}
                        </li>
                        @if($activity->batch)
                        <li class="mb-1">
                            <i class="bi bi-tag"></i> 
                            <strong>Batch:</strong> {{ $activity->batch }}
                        </li>
                        @endif
                        @if($activity->registration_fee > 0)
                        <li class="mb-1">
                            <i class="bi bi-cash"></i> 
                            <strong>Biaya:</strong> Rp {{ number_format($activity->registration_fee, 0, ',', '.') }} <small class="text-muted">per peserta</small>
                        </li>
                        @endif
                        @if($activity->financing_type)
                        <li class="mb-1">
                            <i class="bi bi-wallet2"></i> 
                            <strong>Pembiayaan:</strong> {{ $activity->financing_type }}
                            @if($activity->apbn_type) - {{ $activity->apbn_type }}@endif
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="{{ route('activities.show', $activity) }}" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-eye"></i> Lihat Detail & Daftar
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                Saat ini belum ada kegiatan yang tersedia untuk pendaftaran.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
