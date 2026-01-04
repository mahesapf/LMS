@extends('layouts.dashboard')

@section('title', 'Tambah Kegiatan')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('super-admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('super-admin.users') }}">Manajemen Pengguna</a>
    <a class="nav-link" href="{{ route('super-admin.programs') }}">Program</a>
    <a class="nav-link active" href="{{ route('super-admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('super-admin.admin-mappings') }}">Pemetaan Admin</a>
</nav>
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

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Sumber Pembiayaan</label>
                        <select name="funding_source" id="funding_source" class="form-select @error('funding_source') is-invalid @enderror" onchange="toggleOtherFunding()">
                            <option value="">Pilih Sumber Pembiayaan</option>
                            <option value="DIPA" {{ old('funding_source') == 'DIPA' ? 'selected' : '' }}>DIPA</option>
                            <option value="PNBP" {{ old('funding_source') == 'PNBP' ? 'selected' : '' }}>PNBP</option>
                            <option value="APBD" {{ old('funding_source') == 'APBD' ? 'selected' : '' }}>APBD</option>
                            <option value="BOS" {{ old('funding_source') == 'BOS' ? 'selected' : '' }}>BOS</option>
                            <option value="Other" {{ old('funding_source') == 'Other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('funding_source')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6" id="other_funding_div" style="display: {{ old('funding_source') == 'Other' ? 'block' : 'none' }};">
                        <label class="form-label">Sumber Pembiayaan Lainnya</label>
                        <input type="text" name="funding_source_other" class="form-control @error('funding_source_other') is-invalid @enderror" value="{{ old('funding_source_other') }}">
                        @error('funding_source_other')
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
function toggleOtherFunding() {
    const fundingSource = document.getElementById('funding_source').value;
    const otherDiv = document.getElementById('other_funding_div');
    
    if (fundingSource === 'Other') {
        otherDiv.style.display = 'block';
    } else {
        otherDiv.style.display = 'none';
    }
}
</script>
@endsection
