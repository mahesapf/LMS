@extends('layouts.dashboard')

@section('title', 'Input Nilai')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('fasilitator.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('fasilitator.profile') }}">Edit Biodata</a>
    <a class="nav-link active" href="{{ route('fasilitator.classes') }}">Input Nilai</a>
    <a class="nav-link" href="{{ route('fasilitator.documents') }}">Upload Dokumen</a>
    <a class="nav-link" href="{{ route('fasilitator.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Input Nilai</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        @forelse($mappings as $mapping)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
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

                    <p class="card-text">
                        <small class="text-muted">
                            <i class="bi bi-person"></i> Max Peserta: {{ $mapping->class->max_participants ?? 'Unlimited' }}<br>
                            <i class="bi bi-calendar"></i> Ditugaskan: {{ $mapping->created_at->format('d M Y') }}
                        </small>
                    </p>

                    <div class="d-flex gap-2">
                        <a href="{{ route('fasilitator.classes.detail', $mapping->class) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <a href="{{ route('fasilitator.grades', $mapping->class) }}" class="btn btn-sm btn-success">
                            <i class="bi bi-star"></i> Nilai
                        </a>
                    </div>
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
                <p class="mb-0">Anda belum ditugaskan ke kelas manapun.</p>
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
