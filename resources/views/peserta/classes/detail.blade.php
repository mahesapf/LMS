@extends('layouts.dashboard')

@section('title', 'Detail Kelas - ' . $class->name)

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
        <div>
            <h1>{{ $class->name }}</h1>
            <p class="text-muted mb-0">{{ $class->activity->name ?? '-' }}</p>
        </div>
        <a href="{{ route('peserta.classes') }}" class="btn btn-secondary">
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

                        <dt class="col-sm-4">Tanggal Terdaftar:</dt>
                        <dd class="col-sm-8">{{ $mapping->enrolled_date ? $mapping->enrolled_date->format('d F Y') : '-' }}</dd>

                        @if($mapping->assignedBy)
                        <dt class="col-sm-4">Ditambahkan Oleh:</dt>
                        <dd class="col-sm-8">{{ $mapping->assignedBy->name }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- My Grades -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Nilai Saya</h5>
                </div>
                <div class="card-body">
                    @if($myGrades->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Penilaian</th>
                                    <th>Nilai</th>
                                    <th>Tanggal</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myGrades as $grade)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $grade->assessment_type }}</strong></td>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ number_format($grade->score, 1) }}</span>
                                    </td>
                                    <td>{{ $grade->graded_date ? $grade->graded_date->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $grade->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-info">
                                    <td colspan="2" class="text-end"><strong>Rata-rata:</strong></td>
                                    <td colspan="3">
                                        <strong>
                                            <span class="badge bg-success fs-6">
                                                {{ number_format($myGrades->avg('score'), 2) }}
                                            </span>
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> Belum ada nilai yang diinput untuk kelas ini.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-md-4">
            <!-- Fasilitators -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Fasilitator</h5>
                </div>
                <div class="card-body">
                    @if($fasilitators && $fasilitators->count() > 0)
                    <ul class="list-unstyled mb-0">
                        @foreach($fasilitators as $fasilitator)
                        <li class="mb-2">
                            <i class="bi bi-person-badge text-primary"></i>
                            <strong>{{ $fasilitator->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $fasilitator->institution ?? '-' }}</small>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted mb-0">Belum ada fasilitator ditugaskan</p>
                    @endif
                </div>
            </div>

            <!-- Status Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Status Saya</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-6">Status:</dt>
                        <dd class="col-sm-6">
                            @if($mapping->status == 'in')
                            <span class="badge bg-success">Aktif</span>
                            @elseif($mapping->status == 'move')
                            <span class="badge bg-warning">Pindah</span>
                            @else
                            <span class="badge bg-danger">Keluar</span>
                            @endif
                        </dd>

                        <dt class="col-sm-6">Total Nilai:</dt>
                        <dd class="col-sm-6">
                            <span class="badge bg-primary">{{ $myGrades->count() }}</span>
                        </dd>

                        @if($myGrades->count() > 0)
                        <dt class="col-sm-6">Nilai Rata-rata:</dt>
                        <dd class="col-sm-6">
                            <span class="badge bg-success">{{ number_format($myGrades->avg('score'), 2) }}</span>
                        </dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
