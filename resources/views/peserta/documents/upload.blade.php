@extends('layouts.peserta')

@section('title', 'Upload Dokumen')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Upload Dokumen</h1>
        <a href="{{ route('peserta.documents') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Upload Dokumen</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('peserta.documents.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Dokumen <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                    id="type" name="type" required>
                                <option value="">Pilih Tipe</option>
                                <option value="surat_tugas" {{ old('type') == 'surat_tugas' ? 'selected' : '' }}>Surat Tugas</option>
                                <option value="tugas_kegiatan" {{ old('type') == 'tugas_kegiatan' ? 'selected' : '' }}>Tugas Kegiatan</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="class_id" class="form-label">Kelas (Opsional)</label>
                            <select class="form-select @error('class_id') is-invalid @enderror"
                                    id="class_id" name="class_id">
                                <option value="">Tidak terkait kelas</option>
                                @foreach($myClasses as $mapping)
                                <option value="{{ $mapping->class->id }}" {{ old('class_id') == $mapping->class->id ? 'selected' : '' }}>
                                    {{ $mapping->class->name }} - {{ $mapping->class->activity->name ?? '' }}
                                </option>
                                @endforeach
                            </select>
                            @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih kelas jika dokumen terkait dengan kelas tertentu</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">File Dokumen <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror"
                                   id="file" name="file" required
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 5MB</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Upload Dokumen
                            </button>
                            <a href="{{ route('peserta.documents') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi</h5>
                </div>
                <div class="card-body">
                    <h6>Ketentuan Upload:</h6>
                    <ul class="small">
                        <li>File maksimal 5MB</li>
                        <li>Format: PDF, DOC, DOCX, JPG, PNG</li>
                        <li>Pastikan file dapat dibuka dengan baik</li>
                        <li>Gunakan nama file yang jelas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
