@extends('layouts.dashboard')

@section('title', 'Pemetaan Peserta')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('fasilitator.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('fasilitator.profile') }}">Edit Biodata</a>
    <a class="nav-link" href="{{ route('fasilitator.classes') }}">Input Nilai</a>
    <a class="nav-link active" href="{{ route('fasilitator.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Pemetaan Peserta</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Peserta In</h6>
                    <h3 class="mb-0">{{ $stats['in'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h6 class="card-title">Total Peserta Move</h6>
                    <h3 class="mb-0">{{ $stats['move'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Peserta Out</h6>
                    <h3 class="mb-0">{{ $stats['out'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Classes with Participant Count -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Kelas dan Pemetaan Peserta</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Kegiatan</th>
                            <th>Status Kelas</th>
                            <th>Peserta In</th>
                            <th>Peserta Move</th>
                            <th>Peserta Out</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classesWithMappings as $class)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $class->name }}</strong>
                                @if($class->description)
                                <br><small class="text-muted">{{ Str::limit($class->description, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $class->activity->name ?? '-' }}</td>
                            <td>
                                @if($class->status == 'open')
                                <span class="badge bg-success">Buka</span>
                                @elseif($class->status == 'closed')
                                <span class="badge bg-warning">Tutup</span>
                                @else
                                <span class="badge bg-secondary">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success fs-6">{{ $class->participantMappings->where('status', 'in')->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning fs-6">{{ $class->participantMappings->where('status', 'move')->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-danger fs-6">{{ $class->participantMappings->where('status', 'out')->count() }}</span>
                            </td>
                            <td>
                                <strong>{{ $class->participantMappings->count() }}</strong>
                            </td>
                            <td>
                                <a href="{{ route('fasilitator.classes.participants', $class) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Anda belum ditugaskan ke kelas manapun</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle"></i> <strong>Info:</strong>
        <ul class="mb-0 mt-2">
            <li><strong>In:</strong> Peserta yang aktif di kelas</li>
            <li><strong>Move:</strong> Peserta yang dipindahkan ke kelas lain</li>
            <li><strong>Out:</strong> Peserta yang dikeluarkan dari kelas</li>
            <li>Pemetaan peserta dilakukan oleh Admin</li>
        </ul>
    </div>
</div>
@endsection
