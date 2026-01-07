@extends('layouts.dashboard')

@section('title', 'Kelola Pendaftaran Peserta')

@section('sidebar')
<nav class="nav flex-column">
    @if(auth()->user()->role === 'super_admin')
        <a class="nav-link" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('super-admin.users') }}">Manajemen Pengguna</a>
        <a class="nav-link" href="{{ route('super-admin.programs') }}">Program</a>
        <a class="nav-link" href="{{ route('super-admin.activities') }}">Kegiatan</a>
        <a class="nav-link" href="{{ route('super-admin.classes.index') }}">Kelas</a>
        <a class="nav-link" href="{{ route('super-admin.payments.index') }}">Validasi Pembayaran</a>
        <a class="nav-link active" href="{{ route('super-admin.registrations.index') }}">Kelola Pendaftaran</a>
        <a class="nav-link" href="{{ route('super-admin.admin-mappings') }}">Pemetaan Admin</a>
    @else
        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
        <a class="nav-link" href="{{ route('admin.classes.index') }}">Kelas</a>
        <a class="nav-link active" href="{{ route('admin.registrations.index') }}">Manajemen Peserta</a>
    @endif
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Kelola Pendaftaran Peserta</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Untuk menambahkan peserta ke kelas, silakan buka menu <strong>Kelas</strong>, pilih kelas yang diinginkan, lalu klik <strong>Detail</strong>.
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Peserta Tervalidasi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal Daftar</th>
                            <th>Nama & Kontak</th>
                            <th>Jabatan</th>
                            <th>Sekolah</th>
                            <th>Kegiatan</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $registration)
                        <tr>
                            <td>{{ $registration->created_at->format('d M Y') }}</td>
                            <td>
                                {{ $registration->name }}<br>
                                <small class="text-muted">{{ $registration->email }}</small><br>
                                <small class="text-muted">{{ $registration->phone }}</small>
                            </td>
                            <td>{{ $registration->position ?? '-' }}</td>
                            <td>{{ $registration->school ?? '-' }}</td>
                            <td>
                                {{ $registration->activity->name ?? '-' }}
                                @if($registration->activity->program)
                                    <br><small class="text-muted">{{ $registration->activity->program->name }}</small>
                                @endif
                            </td>
                            <td>
                                @if($registration->class)
                                    <a href="{{ route($routePrefix . '.classes.show', $registration->class) }}" class="badge bg-success text-decoration-none">
                                        {{ $registration->class->name }}
                                    </a>
                                @else
                                    <span class="badge bg-warning">Belum Ditentukan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada peserta yang tervalidasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
