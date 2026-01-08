@extends('layouts.dashboard')

@section('title', 'Kelola Dokumen - ' . $class->name)

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('admin.participants') }}">Peserta</a>
    <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
    <a class="nav-link active" href="{{ route('admin.classes') }}">Kelas</a>
    <a class="nav-link" href="{{ route('admin.mappings.index') }}">Pemetaan</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Kelola Dokumen Requirement</h1>
            <p class="text-muted mb-0">Kelas: <strong>{{ $class->name }}</strong></p>
        </div>
        <div>
            <a href="{{ route('admin.classes.stages', $class) }}" class="btn btn-info me-2">
                <i class="bi bi-layers"></i> Kelola Tahap
            </a>
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

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($stages->count() == 0)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i> Belum ada tahap dibuat. Silakan <a href="{{ route('admin.classes.stages', $class) }}" class="alert-link">buat tahap terlebih dahulu</a> sebelum menambahkan dokumen requirement.
    </div>
    @else
    <!-- Stages Accordion -->
    <div class="accordion" id="stagesAccordion">
        @foreach($stages as $stage)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $stage->id }}">
                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $stage->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $stage->id }}">
                    <strong>{{ $stage->name }}</strong>
                    <span class="badge bg-primary ms-2">{{ $stage->documentRequirements->count() }} dokumen</span>
                    <span class="badge ms-2
                        @if($stage->status == 'ongoing') bg-success
                        @elseif($stage->status == 'completed') bg-secondary
                        @else bg-warning text-dark
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $stage->status)) }}
                    </span>
                </button>
            </h2>
            <div id="collapse{{ $stage->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $stage->id }}" data-bs-parent="#stagesAccordion">
                <div class="accordion-body">
                    @if($stage->description)
                    <p class="text-muted">{{ $stage->description }}</p>
                    @endif

                    <!-- Add Document Button -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDocModal{{ $stage->id }}">
                            <i class="bi bi-plus-circle"></i> Tambah Dokumen Requirement
                        </button>
                    </div>

                    <!-- Document Requirements Table -->
                    @if($stage->documentRequirements->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="30">#</th>
                                    <th>Nama Dokumen</th>
                                    <th>Tipe File</th>
                                    <th width="100">Max Size</th>
                                    <th width="100">Wajib</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stage->documentRequirements as $req)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $req->document_name }}</strong>
                                        @if($req->description)
                                        <br><small class="text-muted">{{ $req->description }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $req->document_type ?: 'Semua' }}</td>
                                    <td>{{ number_format($req->max_file_size / 1024, 1) }} MB</td>
                                    <td>
                                        @if($req->is_required)
                                        <span class="badge bg-danger">Ya</span>
                                        @else
                                        <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editDocModal{{ $req->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.classes.documents.destroy', [$class, $req]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus requirement ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editDocModal{{ $req->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.classes.documents.update', [$class, $req]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="stage_id" value="{{ $stage->id }}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Dokumen Requirement</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="document_name{{ $req->id }}" class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                                                        <input type="text" name="document_name" id="document_name{{ $req->id }}" class="form-control" value="{{ $req->document_name }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="document_type{{ $req->id }}" class="form-label">Tipe File</label>
                                                        <select name="document_type" id="document_type{{ $req->id }}" class="form-select">
                                                            <option value="">Semua Tipe</option>
                                                            <option value="pdf" {{ $req->document_type == 'pdf' ? 'selected' : '' }}>PDF</option>
                                                            <option value="doc,docx" {{ $req->document_type == 'doc,docx' ? 'selected' : '' }}>Word</option>
                                                            <option value="jpg,jpeg,png" {{ $req->document_type == 'jpg,jpeg,png' ? 'selected' : '' }}>Gambar</option>
                                                            <option value="pdf,doc,docx" {{ $req->document_type == 'pdf,doc,docx' ? 'selected' : '' }}>PDF/Word</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="description{{ $req->id }}" class="form-label">Deskripsi</label>
                                                        <textarea name="description" id="description{{ $req->id }}" rows="3" class="form-control">{{ $req->description }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="max_file_size{{ $req->id }}" class="form-label">Ukuran Maksimal (KB)</label>
                                                        <input type="number" name="max_file_size" id="max_file_size{{ $req->id }}" class="form-control" value="{{ $req->max_file_size }}" min="100">
                                                    </div>

                                                    <div class="form-check">
                                                        <input type="checkbox" name="is_required" id="is_required{{ $req->id }}" class="form-check-input" value="1" {{ $req->is_required ? 'checked' : '' }}>
                                                        <label for="is_required{{ $req->id }}" class="form-check-label">Dokumen Wajib</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                        <i class="bi bi-info-circle"></i> Belum ada dokumen requirement untuk tahap ini.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Add Document Modal -->
        <div class="modal fade" id="addDocModal{{ $stage->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.classes.documents.store', $class) }}" method="POST">
                        @csrf
                        <input type="hidden" name="stage_id" value="{{ $stage->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Dokumen Requirement - {{ $stage->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="document_name_new{{ $stage->id }}" class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                                <input type="text" name="document_name" id="document_name_new{{ $stage->id }}" class="form-control" placeholder="Contoh: KTP, Ijazah, Laporan Tugas 1" required>
                            </div>

                            <div class="mb-3">
                                <label for="document_type_new{{ $stage->id }}" class="form-label">Tipe File</label>
                                <select name="document_type" id="document_type_new{{ $stage->id }}" class="form-select">
                                    <option value="">Semua Tipe</option>
                                    <option value="pdf">PDF</option>
                                    <option value="doc,docx">Word</option>
                                    <option value="jpg,jpeg,png">Gambar</option>
                                    <option value="pdf,doc,docx">PDF/Word</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description_new{{ $stage->id }}" class="form-label">Deskripsi</label>
                                <textarea name="description" id="description_new{{ $stage->id }}" rows="3" class="form-control" placeholder="Keterangan tambahan tentang dokumen ini"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="max_file_size_new{{ $stage->id }}" class="form-label">Ukuran Maksimal (KB)</label>
                                <input type="number" name="max_file_size" id="max_file_size_new{{ $stage->id }}" class="form-control" value="5120" min="100">
                                <small class="text-muted">Default: 5120 KB (5 MB)</small>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" name="is_required" id="is_required_new{{ $stage->id }}" class="form-check-input" value="1" checked>
                                <label for="is_required_new{{ $stage->id }}" class="form-check-label">Dokumen Wajib</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
