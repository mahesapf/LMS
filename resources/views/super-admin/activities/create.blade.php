@extends('layouts.dashboard')

@section('title', 'Tambah Kegiatan')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1>Tambah Kegiatan Baru</h1>
        <a href="{{ route('super-admin.activities') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('super-admin.activities.store') }}">
                @csrf

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
                    <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Batch</label>
                    <input type="text" name="batch" class="form-control @error('batch') is-invalid @enderror" value="{{ old('batch') }}" placeholder="Contoh: Batch 1, Angkatan 2024">
                    @error('batch')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Pembiayaan</label>
                        <select name="financing_type" id="financing_type" class="form-select @error('financing_type') is-invalid @enderror">
                            <option value="">Pilih Jenis</option>
                            <option value="APBN" {{ old('financing_type') == 'APBN' ? 'selected' : '' }}>APBN</option>
                            <option value="Non-APBN" {{ old('financing_type') == 'Non-APBN' ? 'selected' : '' }}>Non-APBN</option>
                        </select>
                        @error('financing_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipe APBN</label>
                        <select name="apbn_type" id="apbn_type" class="form-select @error('apbn_type') is-invalid @enderror">
                            <option value="">Pilih Tipe</option>
                            <option value="BOS Reguler" {{ old('apbn_type') == 'BOS Reguler' ? 'selected' : '' }}>BOS Reguler</option>
                            <option value="BOS Kinerja" {{ old('apbn_type') == 'BOS Kinerja' ? 'selected' : '' }}>BOS Kinerja</option>
                            <option value="DIPA" {{ old('apbn_type') == 'DIPA' ? 'selected' : '' }}>DIPA</option>
                        </select>
                        @error('apbn_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Biaya Pendaftaran</label>
                        <input type="number" name="registration_fee" class="form-control @error('registration_fee') is-invalid @enderror"
                               value="{{ old('registration_fee', 0) }}" min="0" step="0.01">
                        @error('registration_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Direncanakan</option>
                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('super-admin.activities') }}" class="btn btn-secondary">Batal</a>
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
