@extends('layouts.dashboard')

@section('title', 'Detail Kelas - ' . $class->name)

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('fasilitator.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('fasilitator.profile') }}">Edit Biodata</a>
    <a class="nav-link active" href="{{ route('fasilitator.classes') }}">Input Nilai</a>

    <a class="nav-link" href="{{ route('fasilitator.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>{{ $class->name }}</h1>
            <p class="text-muted mb-0">{{ $class->activity->name ?? '-' }}</p>
        </div>
        <a href="{{ route('fasilitator.classes') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Class Information -->
        <div class="col-md-8 mb-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Kelas</h5>
                </div>
                <div class="card-body">
                    @if($class->description)
                    <p>{{ $class->description }}</p>
                    @else
                    <p class="text-muted">Tidak ada deskripsi</p>
                    @endif

                    <hr>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Kegiatan:</dt>
                        <dd class="col-sm-8">{{ $class->activity->name ?? '-' }}</dd>

                        <dt class="col-sm-4">Status Kelas:</dt>
                        <dd class="col-sm-8">
                            @if($class->status == 'open')
                            <span class="badge bg-success">Buka</span>
                            @elseif($class->status == 'closed')
                            <span class="badge bg-warning">Tutup</span>
                            @else
                            <span class="badge bg-secondary">Selesai</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Maksimal Peserta:</dt>
                        <dd class="col-sm-8">{{ $class->max_participants ?? 'Tidak terbatas' }}</dd>

                        <dt class="col-sm-4">Jumlah Peserta:</dt>
                        <dd class="col-sm-8">{{ $participants->count() }} peserta</dd>
                    </dl>
                </div>
            </div>

            <!-- Participants List -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Peserta</h5>
                    <a href="{{ route('fasilitator.grades', $class) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-star"></i> Input Nilai
                    </a>
                </div>
                <div class="card-body">
                    @if($participants->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Institusi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($participants as $mapping)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $mapping->participant->name }}</strong></td>
                                    <td>{{ $mapping->participant->email }}</td>
                                    <td>{{ $mapping->participant->institution ?? '-' }}</td>
                                    <td>
                                        @if($mapping->status == 'in')
                                        <span class="badge bg-success">Aktif</span>
                                        @elseif($mapping->status == 'move')
                                        <span class="badge bg-warning">Pindah</span>
                                        @else
                                        <span class="badge bg-danger">Keluar</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> Belum ada peserta terdaftar di kelas ini.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('fasilitator.grades', $class) }}" class="btn btn-success">
                            <i class="bi bi-star"></i> Input Nilai
                        </a>
                        <a href="{{ route('fasilitator.classes.document-requirements', $class) }}" class="btn btn-info">
                            <i class="bi bi-file-earmark-text"></i> Lihat Tugas Peserta
                        </a>
                        <a href="{{ route('fasilitator.classes.participants', $class) }}" class="btn btn-primary">
                            <i class="bi bi-people"></i> Kelola Peserta
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-7">Total Peserta:</dt>
                        <dd class="col-sm-5">
                            <span class="badge bg-primary">{{ $participants->count() }}</span>
                        </dd>

                        <dt class="col-sm-7">Peserta Aktif:</dt>
                        <dd class="col-sm-5">
                            <span class="badge bg-success">{{ $participants->where('status', 'in')->count() }}</span>
                        </dd>

                        @if($class->max_participants)
                        <dt class="col-sm-7">Kuota Tersisa:</dt>
                        <dd class="col-sm-5">
                            <span class="badge bg-info">{{ max(0, $class->max_participants - $participants->where('status', 'in')->count()) }}</span>
                        </dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
