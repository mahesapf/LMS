@extends('layouts.dashboard')

@section('title', 'Manajemen Kelas')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('admin.participants') }}">Manajemen Peserta</a>
    <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
    <a class="nav-link active" href="{{ route('admin.classes') }}">Kelas</a>
    <a class="nav-link" href="{{ route('admin.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Kelas</h1>
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kelas
        </a>
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
            <form method="GET" action="{{ route('admin.classes') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Filter Kegiatan</label>
                    <select name="activity_id" class="form-select">
                        <option value="">Semua Kegiatan</option>
                        @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ request('activity_id') == $activity->id ? 'selected' : '' }}>
                            {{ $activity->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('admin.classes') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Kegiatan</th>
                            <th>Max Peserta</th>
                            <th>Status</th>
                            <th>Pembuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $class)
                        <tr>
                            <td>{{ $loop->iteration + ($classes->currentPage() - 1) * $classes->perPage() }}</td>
                            <td>
                                <strong>{{ $class->name }}</strong>
                                @if($class->description)
                                <br><small class="text-muted">{{ Str::limit($class->description, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $class->activity->name ?? '-' }}</td>
                            <td>{{ $class->max_participants ?? 'Unlimited' }}</td>
                            <td>
                                @if($class->status == 'open')
                                <span class="badge bg-success">Buka</span>
                                @elseif($class->status == 'closed')
                                <span class="badge bg-warning">Tutup</span>
                                @else
                                <span class="badge bg-secondary">Selesai</span>
                                @endif
                            </td>
                            <td>{{ $class->creator->name ?? '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.classes.participants', $class) }}" class="btn btn-outline-info" title="Peserta">
                                        <i class="bi bi-people"></i>
                                    </a>
                                    <a href="{{ route('admin.classes.fasilitators', $class) }}" class="btn btn-outline-success" title="Fasilitator">
                                        <i class="bi bi-person-badge"></i>
                                    </a>
                                    <a href="{{ route('admin.classes.documents', $class) }}" class="btn btn-outline-warning" title="Kelola Dokumen">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </a>
                                    <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.classes.delete', $class) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus kelas ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data kelas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($classes->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $classes->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
