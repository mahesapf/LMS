@extends('layouts.dashboard')

@section('title', 'Manajemen Peserta')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link active" href="{{ route('admin.participants') }}">Manajemen Peserta</a>
    <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('admin.classes') }}">Kelas</a>
    <a class="nav-link" href="{{ route('admin.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manajemen Peserta</h1>
        <a href="{{ route('admin.participants.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Peserta
        </a>
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
                            <th>Nama</th>
                            <th>Gelar</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Institusi</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($participants as $participant)
                        <tr>
                            <td>{{ $loop->iteration + ($participants->currentPage() - 1) * $participants->perPage() }}</td>
                            <td>{{ $participant->name }}</td>
                            <td>{{ $participant->degree ?? '-' }}</td>
                            <td>{{ $participant->email }}</td>
                            <td>{{ $participant->phone }}</td>
                            <td>{{ $participant->institution ?? '-' }}</td>
                            <td>{{ $participant->position ?? '-' }}</td>
                            <td>
                                @if($participant->status == 'active')
                                <span class="badge bg-success">Aktif</span>
                                @elseif($participant->status == 'suspended')
                                <span class="badge bg-warning">Suspended</span>
                                @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.participants.edit', $participant) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($participant->status == 'active')
                                    <form action="{{ route('admin.participants.suspend', $participant) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning" title="Suspend" onclick="return confirm('Yakin ingin suspend peserta ini?')">
                                            <i class="bi bi-pause-circle"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.participants.delete', $participant) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus peserta ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data peserta</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($participants->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $participants->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
