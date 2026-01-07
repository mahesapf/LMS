@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
    <a class="nav-link active" href="{{ route('super-admin.users') }}">Manajemen Pengguna</a>
    <a class="nav-link" href="{{ route('super-admin.programs') }}">Program</a>
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
        <h1>Manajemen Pengguna</h1>
        <div>
            <a href="{{ route('super-admin.users.import') }}" class="btn btn-success">Import CSV</a>
            <a href="{{ route('super-admin.users.create') }}" class="btn btn-primary">Tambah Pengguna</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="role" class="form-select" onchange="this.form.submit()">
                            <option value="all" {{ $role == 'all' ? 'selected' : '' }}>Semua Role</option>
                            <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="fasilitator" {{ $role == 'fasilitator' ? 'selected' : '' }}>Fasilitator</option>
                            <option value="peserta" {{ $role == 'peserta' ? 'selected' : '' }}>Peserta</option>
                        </select>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->degree }} {{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($user->status == 'suspended')
                                    <span class="badge bg-danger">Suspended</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('super-admin.users.edit', $user) }}" class="btn btn-warning">Edit</a>
                                    @if($user->status == 'active')
                                        <form method="POST" action="{{ route('super-admin.users.suspend', $user) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Suspend user ini?')">Suspend</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('super-admin.users.activate', $user) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Aktifkan</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('super-admin.users.delete', $user) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
