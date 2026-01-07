@extends('layouts.dashboard')

@section('title', 'Edit Program')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('super-admin.users') }}">Manajemen Pengguna</a>
    <a class="nav-link active" href="{{ route('super-admin.programs') }}">Program</a>
    <a class="nav-link" href="{{ route('super-admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('super-admin.admin-mappings') }}">Pemetaan Admin</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1>Edit Program</h1>
        <a href="{{ route('super-admin.programs') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('super-admin.programs.update', $program) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Program <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $program->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $program->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Pembiayaan</label>
                        <select name="financing_type" id="financing_type" class="form-select @error('financing_type') is-invalid @enderror">
                            <option value="">Pilih Jenis</option>
                            <option value="APBN" {{ old('financing_type', $program->financing_type) == 'APBN' ? 'selected' : '' }}>APBN</option>
                            <option value="Non-APBN" {{ old('financing_type', $program->financing_type) == 'Non-APBN' ? 'selected' : '' }}>Non-APBN</option>
                        </select>
                        @error('financing_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipe APBN</label>
                        <select name="apbn_type" id="apbn_type" class="form-select @error('apbn_type') is-invalid @enderror">
                            <option value="">Pilih Tipe</option>
                            <option value="BOS Reguler" {{ old('apbn_type', $program->apbn_type) == 'BOS Reguler' ? 'selected' : '' }}>BOS Reguler</option>
                            <option value="BOS Kinerja" {{ old('apbn_type', $program->apbn_type) == 'BOS Kinerja' ? 'selected' : '' }}>BOS Kinerja</option>
                            <option value="DIPA" {{ old('apbn_type', $program->apbn_type) == 'DIPA' ? 'selected' : '' }}>DIPA</option>
                        </select>
                        @error('apbn_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Biaya Pendaftaran</label>
                        <input type="number" name="registration_fee" class="form-control @error('registration_fee') is-invalid @enderror" 
                               value="{{ old('registration_fee', $program->registration_fee) }}" min="0" step="0.01">
                        @error('registration_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                               value="{{ old('start_date', $program->start_date?->format('Y-m-d')) }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                               value="{{ old('end_date', $program->end_date?->format('Y-m-d')) }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $program->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $program->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="completed" {{ old('status', $program->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('super-admin.programs') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Enable/disable APBN type based on financing type
    document.getElementById('financing_type').addEventListener('change', function() {
        const apbnType = document.getElementById('apbn_type');
        if (this.value === 'APBN') {
            apbnType.disabled = false;
        } else {
            apbnType.disabled = true;
            apbnType.value = '';
        }
    });

    // Set initial state
    document.addEventListener('DOMContentLoaded', function() {
        const financingType = document.getElementById('financing_type');
        const apbnType = document.getElementById('apbn_type');
        if (financingType.value !== 'APBN') {
            apbnType.disabled = true;
        }
    });
</script>
@endsection
