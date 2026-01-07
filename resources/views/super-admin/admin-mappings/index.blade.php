@extends('layouts.dashboard')

@section('title', 'Pemetaan Admin')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('super-admin.users') }}">Manajemen Pengguna</a>
    <a class="nav-link" href="{{ route('super-admin.programs') }}">Program</a>
    <a class="nav-link" href="{{ route('super-admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('super-admin.classes.index') }}">Kelas</a>
    <a class="nav-link" href="{{ route('super-admin.payments.index') }}">Validasi Pembayaran</a>
    <a class="nav-link" href="{{ route('super-admin.registrations.index') }}">Kelola Pendaftaran</a>
    <a class="nav-link active" href="{{ route('super-admin.admin-mappings') }}">Pemetaan Admin</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Pemetaan Admin</h1>
        <a href="{{ route('super-admin.admin-mappings.create') }}" class="btn btn-primary">Tambah Pemetaan</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Admin</th>
                            <th>Program</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                            <th>Tanggal Ditugaskan</th>
                            <th>Tanggal Dihapus</th>
                            <th>Ditugaskan Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mappings as $mapping)
                        <tr>
                            <td><strong>{{ $mapping->admin->name }}</strong></td>
                            <td>{{ $mapping->program ? $mapping->program->name : '-' }}</td>
                            <td>{{ $mapping->activity ? $mapping->activity->name : '-' }}</td>
                            <td>
                                @if($mapping->status == 'in')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Keluar</span>
                                @endif
                            </td>
                            <td>{{ $mapping->assigned_date ? $mapping->assigned_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $mapping->removed_date ? $mapping->removed_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $mapping->assignedBy->name }}</td>
                            <td>
                                @if($mapping->status == 'in')
                                    <form method="POST" action="{{ route('super-admin.admin-mappings.update-status', [$mapping, 'out']) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Keluarkan admin dari tugas ini?')">
                                            Keluarkan
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('super-admin.admin-mappings.update-status', [$mapping, 'in']) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Aktifkan Kembali
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $mappings->links() }}
        </div>
    </div>
</div>
@endsection
