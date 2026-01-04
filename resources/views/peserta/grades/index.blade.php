@extends('layouts.dashboard')

@section('title', 'Nilai Saya')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('peserta.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('peserta.profile') }}">Profil</a>
    <a class="nav-link" href="{{ route('peserta.classes') }}">Kelas Saya</a>
    <a class="nav-link active" href="{{ route('peserta.grades') }}">Nilai Saya</a>
    <a class="nav-link" href="{{ route('peserta.documents') }}">Dokumen</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Nilai Saya</h1>
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
                            <th>Kelas</th>
                            <th>Kegiatan</th>
                            <th>Jenis Penilaian</th>
                            <th>Nilai</th>
                            <th>Fasilitator</th>
                            <th>Tanggal</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $grade)
                        <tr>
                            <td>{{ $loop->iteration + ($grades->currentPage() - 1) * $grades->perPage() }}</td>
                            <td>{{ $grade->class->name ?? '-' }}</td>
                            <td>{{ $grade->class->activity->name ?? '-' }}</td>
                            <td>{{ $grade->assessment_type }}</td>
                            <td>
                                <span class="badge 
                                    @if($grade->score >= 80) bg-success
                                    @elseif($grade->score >= 70) bg-primary
                                    @elseif($grade->score >= 60) bg-warning
                                    @else bg-danger
                                    @endif
                                    fs-6">
                                    {{ $grade->score }}
                                </span>
                            </td>
                            <td>{{ $grade->fasilitator->name ?? '-' }}</td>
                            <td>{{ $grade->graded_date ? \Carbon\Carbon::parse($grade->graded_date)->format('d M Y') : '-' }}</td>
                            <td>
                                @if($grade->notes)
                                <small class="text-muted">{{ Str::limit($grade->notes, 50) }}</small>
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada nilai</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($grades->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $grades->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Summary Card -->
    @if($grades->count() > 0)
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ringkasan Nilai</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-6">Total Nilai:</dt>
                        <dd class="col-sm-6">{{ $grades->total() }}</dd>
                        
                        <dt class="col-sm-6">Rata-rata:</dt>
                        <dd class="col-sm-6">
                            <strong>{{ number_format($grades->avg('score'), 2) }}</strong>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
