@extends('layouts.dashboard')

@section('title', 'Program')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('super-admin.users') }}">Manajemen Pengguna</a>
    <a class="nav-link active" href="{{ route('super-admin.programs') }}">Program</a>
    <a class="nav-link" href="{{ route('super-admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('super-admin.classes.index') }}">Kelas</a>
    <a class="nav-link" href="{{ route('super-admin.payments.index') }}">Validasi Pembayaran</a>
    <a class="nav-link" href="{{ route('super-admin.registrations.index') }}">Kelola Pendaftaran</a>
    <a class="nav-link" href="{{ route('super-admin.admin-mappings') }}">Pemetaan Admin</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Program</h1>
        <a href="{{ route('super-admin.programs.create') }}" class="btn btn-primary">Tambah Program</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Program</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                        <tr>
                            <td><strong>{{ $program->name }}</strong></td>
                            <td>{{ Str::limit($program->description, 50) }}</td>
                            <td>{{ $program->start_date ? $program->start_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $program->end_date ? $program->end_date->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($program->status == 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($program->status == 'completed')
                                    <span class="badge bg-info">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ $program->creator->name }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('super-admin.programs.edit', $program) }}" class="btn btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('super-admin.programs.delete', $program) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus program ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $programs->links() }}
        </div>
    </div>
</div>
@endsection
