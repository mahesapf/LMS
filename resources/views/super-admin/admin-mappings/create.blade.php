@extends('layouts.dashboard')

@section('title', 'Tambah Pemetaan Admin')

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
    <div class="mb-4">
        <h1>Tambah Pemetaan Admin</h1>
        <a href="{{ route('super-admin.admin-mappings') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('super-admin.admin-mappings.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Admin <span class="text-danger">*</span></label>
                    <select name="admin_id" class="form-select @error('admin_id') is-invalid @enderror" required>
                        <option value="">Pilih Admin</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ old('admin_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }} ({{ $admin->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('admin_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Program</label>
                    <select name="program_id" class="form-select @error('program_id') is-invalid @enderror">
                        <option value="">Pilih Program (Opsional)</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('program_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kegiatan</label>
                    <select name="activity_id" class="form-select @error('activity_id') is-invalid @enderror">
                        <option value="">Pilih Kegiatan (Opsional)</option>
                        @foreach($activities as $activity)
                            <option value="{{ $activity->id }}" {{ old('activity_id') == $activity->id ? 'selected' : '' }}>
                                {{ $activity->name }} 
                                @if($activity->program)
                                    ({{ $activity->program->name }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('activity_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Admin dapat ditugaskan ke Program, Kegiatan, atau keduanya</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="in" {{ old('status') == 'in' ? 'selected' : '' }}>Aktif (In)</option>
                        <option value="out" {{ old('status') == 'out' ? 'selected' : '' }}>Keluar (Out)</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Ditugaskan</label>
                    <input type="date" name="assigned_date" class="form-control @error('assigned_date') is-invalid @enderror" value="{{ old('assigned_date', date('Y-m-d')) }}">
                    @error('assigned_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('super-admin.admin-mappings') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
