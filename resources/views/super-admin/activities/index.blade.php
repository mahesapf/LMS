@extends('layouts.dashboard')

@section('title', 'Kegiatan')

@section('sidebar')
<nav class="nav flex-column">
    @if(auth()->user()->role === 'super_admin')
        <a class="nav-link" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('super-admin.users') }}">Manajemen Pengguna</a>
        <a class="nav-link" href="{{ route('super-admin.programs') }}">Program</a>
        <a class="nav-link active" href="{{ route('super-admin.activities') }}">Kegiatan</a>
        <a class="nav-link" href="{{ route('super-admin.classes.index') }}">Kelas</a>
        <a class="nav-link" href="{{ route('super-admin.payments.index') }}">Validasi Pembayaran</a>
        <a class="nav-link" href="{{ route('super-admin.registrations.index') }}">Kelola Pendaftaran</a>
        <a class="nav-link" href="{{ route('super-admin.admin-mappings') }}">Pemetaan Admin</a>
    @else
        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="nav-link active" href="{{ route('admin.activities') }}">Kegiatan</a>
        <a class="nav-link" href="{{ route('admin.classes.index') }}">Kelas</a>
        <a class="nav-link" href="{{ route('admin.registrations.index') }}">Manajemen Peserta</a>
    @endif
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Kegiatan</h1>
        <a href="{{ route($routePrefix . '.activities.create') }}" class="btn btn-primary">Tambah Kegiatan</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Kegiatan</th>
                            <th>Program</th>
                            <th>Batch</th>
                            <th>Tanggal</th>
                            <th>Sumber Dana</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                        <tr>
                            <td><strong>{{ $activity->name }}</strong></td>
                            <td>{{ $activity->program ? $activity->program->name : '-' }}</td>
                            <td>{{ $activity->batch ?? '-' }}</td>
                            <td>
                                {{ $activity->start_date->format('d/m/Y') }} - 
                                {{ $activity->end_date->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($activity->funding_source == 'Other')
                                    {{ $activity->funding_source_other }}
                                @else
                                    {{ $activity->funding_source }}
                                @endif
                            </td>
                            <td>
                                @if($activity->status == 'planned')
                                    <span class="badge bg-secondary">Direncanakan</span>
                                @elseif($activity->status == 'ongoing')
                                    <span class="badge bg-primary">Berlangsung</span>
                                @elseif($activity->status == 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route($routePrefix . '.activities.edit', $activity) }}" class="btn btn-warning">Edit</a>
                                    <form method="POST" action="{{ route($routePrefix . '.activities.delete', $activity) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus kegiatan ini?')">Hapus</button>
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

            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
