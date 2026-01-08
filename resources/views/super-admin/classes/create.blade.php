@extends('layouts.dashboard')

@section('title', 'Tambah Kelas')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tambah Kelas</h1>
        <a href="{{ route($routePrefix . '.classes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route($routePrefix . '.classes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="activity_id" class="form-label">Kegiatan <span class="text-danger">*</span></label>
                    <select name="activity_id" id="activity_id" class="form-select @error('activity_id') is-invalid @enderror" required>
                        <option value="">Pilih Kegiatan</option>
                        @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ old('activity_id') == $activity->id ? 'selected' : '' }}>
                            {{ $activity->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('activity_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Contoh: Kelas A, Kelas B, Angkatan 1, dll.</small>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="max_participants" class="form-label">Maksimal Peserta</label>
                    <input type="number" name="max_participants" id="max_participants" class="form-control @error('max_participants') is-invalid @enderror" value="{{ old('max_participants') }}" min="1">
                    @error('max_participants')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Kosongkan jika tidak ada batasan</small>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Buka</option>
                        <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Tutup</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route($routePrefix . '.classes.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
