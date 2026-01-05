@extends('layouts.dashboard')

@section('title', 'Kelola Dokumen - ' . $class->name)

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
            <h1>Kelola Dokumen Kelas</h1>
            <p class="text-muted mb-0">{{ $class->name }} - {{ $class->activity->name ?? '-' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.classes') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Requirement Dokumen</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.classes.documents.store', $class->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="document_name" class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('document_name') is-invalid @enderror" 
                                   id="document_name" name="document_name" value="{{ old('document_name') }}" 
                                   placeholder="Contoh: KTP, Ijazah, Sertifikat" required>
                            @error('document_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="document_type" class="form-label">Tipe File</label>
                            <select class="form-select @error('document_type') is-invalid @enderror" 
                                    id="document_type" name="document_type">
                                <option value="">Semua Tipe</option>
                                <option value="pdf" {{ old('document_type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="doc,docx" {{ old('document_type') == 'doc,docx' ? 'selected' : '' }}>Word</option>
                                <option value="jpg,jpeg,png" {{ old('document_type') == 'jpg,jpeg,png' ? 'selected' : '' }}>Gambar</option>
                                <option value="pdf,doc,docx" {{ old('document_type') == 'pdf,doc,docx' ? 'selected' : '' }}>PDF/Word</option>
                            </select>
                            @error('document_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Keterangan tambahan tentang dokumen ini">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="max_file_size" class="form-label">Ukuran Maksimal (KB)</label>
                            <input type="number" class="form-control @error('max_file_size') is-invalid @enderror" 
                                   id="max_file_size" name="max_file_size" value="{{ old('max_file_size', 5120) }}" min="100">
                            <small class="text-muted">Default: 5120 KB (5 MB)</small>
                            @error('max_file_size')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_required" name="is_required" value="1" 
                                   {{ old('is_required', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_required">
                                Dokumen Wajib
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Tambah Requirement
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Requirement Dokumen</h5>
                </div>
                <div class="card-body">
                    @if($requirements->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dokumen</th>
                                    <th>Tipe File</th>
                                    <th>Status</th>
                                    <th>Uploaded</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requirements as $req)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $req->document_name }}</strong>
                                        @if($req->description)
                                        <br><small class="text-muted">{{ Str::limit($req->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->document_type)
                                        <span class="badge bg-info">{{ strtoupper($req->document_type) }}</span>
                                        @else
                                        <span class="badge bg-secondary">Semua</span>
                                        @endif
                                        <br><small class="text-muted">Max: {{ number_format($req->max_file_size / 1024, 1) }} MB</small>
                                    </td>
                                    <td>
                                        @if($req->is_required)
                                        <span class="badge bg-danger">Wajib</span>
                                        @else
                                        <span class="badge bg-secondary">Opsional</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $req->documents->count() }}</span> peserta
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" 
                                                data-bs-toggle="modal" data-bs-target="#viewModal{{ $req->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $req->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.classes.documents.destroy', [$class->id, $req->id]) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Hapus requirement ini? Data upload peserta juga akan terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal{{ $req->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Upload Dokumen: {{ $req->document_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if($req->documents->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Peserta</th>
                                                                <th>File</th>
                                                                <th>Tanggal Upload</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($req->documents as $doc)
                                                            <tr>
                                                                <td>{{ $doc->uploader->name ?? '-' }}</td>
                                                                <td>
                                                                    {{ Str::limit(basename($doc->file_path), 30) }}
                                                                    <br><small class="text-muted">{{ number_format($doc->file_size / 1024, 1) }} MB</small>
                                                                </td>
                                                                <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                                                                <td>
                                                                    <a href="{{ Storage::url($doc->file_path) }}" 
                                                                       class="btn btn-sm btn-primary" target="_blank">
                                                                        <i class="bi bi-download"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @else
                                                <p class="text-muted mb-0">Belum ada peserta yang mengupload dokumen ini.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $req->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.classes.documents.update', [$class->id, $req->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Requirement</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Dokumen</label>
                                                        <input type="text" class="form-control" name="document_name" 
                                                               value="{{ $req->document_name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tipe File</label>
                                                        <select class="form-select" name="document_type">
                                                            <option value="" {{ !$req->document_type ? 'selected' : '' }}>Semua Tipe</option>
                                                            <option value="pdf" {{ $req->document_type == 'pdf' ? 'selected' : '' }}>PDF</option>
                                                            <option value="doc,docx" {{ $req->document_type == 'doc,docx' ? 'selected' : '' }}>Word</option>
                                                            <option value="jpg,jpeg,png" {{ $req->document_type == 'jpg,jpeg,png' ? 'selected' : '' }}>Gambar</option>
                                                            <option value="pdf,doc,docx" {{ $req->document_type == 'pdf,doc,docx' ? 'selected' : '' }}>PDF/Word</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Deskripsi</label>
                                                        <textarea class="form-control" name="description" rows="3">{{ $req->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Ukuran Maksimal (KB)</label>
                                                        <input type="number" class="form-control" name="max_file_size" 
                                                               value="{{ $req->max_file_size }}" min="100">
                                                    </div>
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox" class="form-check-input" name="is_required" 
                                                               value="1" {{ $req->is_required ? 'checked' : '' }}>
                                                        <label class="form-check-label">Dokumen Wajib</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> Belum ada requirement dokumen untuk kelas ini. Silakan tambahkan requirement di form sebelah kiri.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
