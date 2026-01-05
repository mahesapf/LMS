@extends('layouts.dashboard')

@section('title', 'Kelas & Nilai Saya')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('peserta.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('peserta.profile') }}">Profil</a>
    <a class="nav-link active" href="{{ route('peserta.classes') }}">Kelas & Nilai Saya</a>
    <a class="nav-link" href="{{ route('peserta.documents') }}">Dokumen</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kelas & Nilai Saya</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        @forelse($mappings as $mapping)
        @php
            $classGrades = $grades->get($mapping->class_id, collect());
            $averageScore = $classGrades->count() > 0 ? $classGrades->avg('score') : null;
        @endphp
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">{{ $mapping->class->name }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong>Kegiatan:</strong><br>
                        {{ $mapping->class->activity->name ?? '-' }}
                    </p>
                    
                    @if($mapping->class->description)
                    <p class="card-text text-muted">
                        {{ Str::limit($mapping->class->description, 100) }}
                    </p>
                    @endif

                    <!-- Nilai Section -->
                    <div class="mb-3">
                        <strong>Nilai:</strong>
                        @if($classGrades->count() > 0)
                        <div class="mt-2">
                            @foreach($classGrades as $grade)
                            <span class="badge bg-primary me-1 mb-1">
                                {{ $grade->assessment_type }}: {{ number_format($grade->score, 1) }}
                            </span>
                            @endforeach
                            <div class="mt-2">
                                <strong>Rata-rata: 
                                    <span class="badge bg-info">{{ number_format($averageScore, 2) }}</span>
                                </strong>
                            </div>
                        </div>
                        @else
                        <div class="text-muted">
                            <small>Belum ada nilai</small>
                        </div>
                        @endif
                    </div>

                    <p class="card-text">
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i> Terdaftar: {{ $mapping->created_at->format('d M Y') }}<br>
                            @if($mapping->assignedBy)
                            <i class="bi bi-person"></i> Oleh: {{ $mapping->assignedBy->name }}
                            @endif
                        </small>
                    </p>

                    <a href="{{ route('peserta.classes.detail', $mapping->class) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i> Detail Kelas
                    </a>
                </div>
                <div class="card-footer text-muted">
                    <small>
                        Status: 
                        @if($mapping->class->status == 'open')
                        <span class="badge bg-success">Buka</span>
                        @elseif($mapping->class->status == 'closed')
                        <span class="badge bg-warning">Tutup</span>
                        @else
                        <span class="badge bg-secondary">Selesai</span>
                        @endif
                    </small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <p class="mb-0">Anda belum terdaftar di kelas manapun.</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($mappings->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $mappings->links() }}
    </div>
    @endif
</div>
@endsection
