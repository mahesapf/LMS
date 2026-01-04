@extends('layouts.dashboard')

@section('title', 'Kegiatan')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('admin.participants') }}">Manajemen Peserta</a>
    <a class="nav-link active" href="{{ route('admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('admin.classes') }}">Kelas</a>
    <a class="nav-link" href="{{ route('admin.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kegiatan</h1>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Program</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Jumlah Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                        <tr>
                            <td>{{ $loop->iteration + ($activities->currentPage() - 1) * $activities->perPage() }}</td>
                            <td>
                                <strong>{{ $activity->name }}</strong>
                                @if($activity->description)
                                <br><small class="text-muted">{{ Str::limit($activity->description, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $activity->program->name ?? '-' }}</td>
                            <td>{{ $activity->start_date ? \Carbon\Carbon::parse($activity->start_date)->format('d M Y') : '-' }}</td>
                            <td>{{ $activity->end_date ? \Carbon\Carbon::parse($activity->end_date)->format('d M Y') : '-' }}</td>
                            <td>
                                @if($activity->status == 'planned')
                                <span class="badge bg-info">Direncanakan</span>
                                @elseif($activity->status == 'ongoing')
                                <span class="badge bg-primary">Berlangsung</span>
                                @elseif($activity->status == 'completed')
                                <span class="badge bg-success">Selesai</span>
                                @else
                                <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>{{ $activity->classes->count() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data kegiatan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($activities->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $activities->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
