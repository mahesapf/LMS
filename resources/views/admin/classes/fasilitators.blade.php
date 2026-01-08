@extends('layouts.dashboard')

@section('title', 'Pemetaan Fasilitator - ' . $class->name)

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('admin.participants') }}">Manajemen Peserta</a>
    <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
    <a class="nav-link active" href="{{ route('admin.classes') }}">Kelas</a>
    <a class="nav-link" href="{{ route('admin.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Pemetaan Fasilitator</h1>
            <p class="text-muted mb-0">Kelas: <strong>{{ $class->name }}</strong> - {{ $class->activity->name ?? '-' }}</p>
        </div>
        <a href="{{ route('admin.classes') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Form Add Fasilitator -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Fasilitator</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.classes.fasilitators.assign', $class) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="fasilitator_id" class="form-label">Pilih Fasilitator <span class="text-danger">*</span></label>
                            <select name="fasilitator_id" id="fasilitator_id" class="form-select @error('fasilitator_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Fasilitator --</option>
                                @foreach($availableFasilitators as $fasilitator)
                                <option value="{{ $fasilitator->id }}">
                                    {{ $fasilitator->name }} ({{ $fasilitator->institution ?? '-' }})
                                </option>
                                @endforeach
                            </select>
                            @error('fasilitator_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="assigned_date" class="form-label">Tanggal Penugasan</label>
                            <input type="date" name="assigned_date" id="assigned_date" class="form-control @error('assigned_date') is-invalid @enderror" value="{{ old('assigned_date', date('Y-m-d')) }}">
                            @error('assigned_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Tambahkan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Fasilitator -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Fasilitator</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Fasilitator</th>
                                    <th>Institusi</th>
                                    <th>Tanggal Penugasan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mappings as $mapping)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $mapping->fasilitator->name ?? '-' }}</strong>
                                        <br><small class="text-muted">{{ $mapping->fasilitator->email ?? '-' }}</small>
                                    </td>
                                    <td>{{ $mapping->fasilitator->institution ?? '-' }}</td>
                                    <td>{{ $mapping->assigned_date ? $mapping->assigned_date->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($mapping->status == 'in')
                                        <span class="badge bg-success">Aktif</span>
                                        @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($mapping->status == 'in')
                                        <form action="{{ route('admin.fasilitators.remove', $mapping) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus fasilitator ini dari kelas?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada fasilitator di kelas ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle"></i> <strong>Info:</strong>
                <ul class="mb-0 mt-2">
                    <li>Fasilitator yang ditugaskan akan dapat mengakses kelas ini</li>
                    <li>Fasilitator dapat menginput nilai dan melihat peserta di kelas</li>
                    <li>Satu kelas dapat memiliki beberapa fasilitator</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
