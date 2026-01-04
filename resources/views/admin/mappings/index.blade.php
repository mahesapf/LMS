
@extends('layouts.dashboard')

@section('title', 'Pemetaan Peserta')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('admin.participants') }}">Manajemen Peserta</a>
    <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('admin.classes') }}">Kelas</a>
    <a class="nav-link active" href="{{ route('admin.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Pemetaan Peserta</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.mappings.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Filter Kegiatan</label>
                    <select name="activity_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kegiatan</option>
                        @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ request('activity_id') == $activity->id ? 'selected' : '' }}>
                            {{ $activity->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filter Kelas</label>
                    <select name="class_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('admin.mappings.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Peserta In</h6>
                    <h3 class="mb-0">{{ $stats['in'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h6 class="card-title">Total Peserta Move</h6>
                    <h3 class="mb-0">{{ $stats['move'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Peserta Out</h6>
                    <h3 class="mb-0">{{ $stats['out'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Kelas</h6>
                    <h3 class="mb-0">{{ $classes->count() }}</h3>
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
                                <span class="badge bg-success fs-6">{{ $class->mappings->where('status', 'in')->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning fs-6">{{ $class->mappings->where('status', 'move')->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-danger fs-6">{{ $class->mappings->where('status', 'out')->count() }}</span>
                            </td>
                            <td>
                                <strong>{{ $class->mappings->count() }}</strong>
                            </td>
                            <td>
                                <a href="{{ route('admin.classes.participants', $class) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-people"></i> Kelola Peserta
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data kelas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
