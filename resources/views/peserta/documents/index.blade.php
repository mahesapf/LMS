@extends('layouts.dashboard')

@section('title', 'Dokumen Saya')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('peserta.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('peserta.profile') }}">Profil</a>
    <a class="nav-link" href="{{ route('peserta.classes') }}">Kelas & Nilai Saya</a>
    <a class="nav-link active" href="{{ route('peserta.documents') }}">Dokumen</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dokumen Saya</h1>

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

    @if($myClasses->count() > 0)
    @foreach($myClasses as $mapping)
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-folder"></i> {{ $mapping->class->name }}
            </h5>
            <small>{{ $mapping->class->activity->name ?? '-' }}</small>
        </div>
        <div class="card-body">
            @php
                $requirements = $mapping->class->documentRequirements;
            @endphp

            @if($requirements->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama Dokumen</th>
                            <th width="20%">Deskripsi</th>
                            <th width="15%">Status</th>
                            <th width="20%">File</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requirements as $req)
                        @php
                            $uploaded = $req->getUploadedBy(Auth::id());
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $req->document_name }}</strong>
                                @if($req->is_required)
                                <span class="badge bg-danger ms-1">Wajib</span>
                                @endif
                            </td>
                            <td>
                                <small>
                                    {{ $req->description ?? '-' }}
                                    @if($req->document_type)
                                    <br><span class="badge bg-info">{{ strtoupper($req->document_type) }}</span>
                                    @endif
                                    <br><span class="text-muted">Max: {{ number_format($req->max_file_size / 1024, 1) }} MB</span>
                                </small>
                            </td>
                            <td>
                                @if($uploaded)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Sudah Upload
                                </span>
                                @else
                                <span class="badge bg-warning">
                                    <i class="bi bi-exclamation-circle"></i> Belum Upload
                                </span>
                                @endif
                            </td>
                            <td>
                                @if($uploaded)
                                <small>
                                    {{ Str::limit(basename($uploaded->file_path), 25) }}
                                    <br><span class="text-muted">
                                        {{ $uploaded->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </small>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($uploaded)
                                <a href="{{ Storage::url($uploaded->file_path) }}" 
                                   class="btn btn-sm btn-info" target="_blank" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-warning" 
                                        data-bs-toggle="modal" data-bs-target="#uploadModal{{ $req->id }}" title="Ganti">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                                <form action="{{ route('peserta.documents.destroy', $uploaded->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button type="button" class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" data-bs-target="#uploadModal{{ $req->id }}">
                                    <i class="bi bi-upload"></i> Upload
                                </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Upload Modal -->
                        <div class="modal fade" id="uploadModal{{ $req->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('peserta.documents.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="document_requirement_id" value="{{ $req->id }}">
                                        <input type="hidden" name="class_id" value="{{ $mapping->class_id }}">
                                        
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload: {{ $req->document_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-info">
                                                <strong>Ketentuan:</strong>
                                                <ul class="mb-0">
                                                    @if($req->document_type)
                                                    <li>Tipe file: {{ strtoupper($req->document_type) }}</li>
                                                    @endif
                                                    <li>Ukuran maksimal: {{ number_format($req->max_file_size / 1024, 1) }} MB</li>
                                                    @if($req->description)
                                                    <li>{{ $req->description }}</li>
                                                    @endif
                                                </ul>
                                            </div>

                                            <div class="mb-3">
                                                <label for="file{{ $req->id }}" class="form-label">Pilih File <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" id="file{{ $req->id }}" name="file" 
                                                       @if($req->document_type)
                                                       accept=".{{ str_replace(',', ',.', $req->document_type) }}"
                                                       @endif
                                                       required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="notes{{ $req->id }}" class="form-label">Catatan (opsional)</label>
                                                <textarea class="form-control" id="notes{{ $req->id }}" name="notes" rows="3" 
                                                          placeholder="Catatan atau keterangan tambahan">{{ $uploaded->notes ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-upload"></i> {{ $uploaded ? 'Ganti' : 'Upload' }} Dokumen
                                            </button>
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
                <i class="bi bi-info-circle"></i> Tidak ada dokumen yang harus diupload untuk kelas ini.
            </div>
            @endif
        </div>
    </div>
    @endforeach
    @else
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i> Anda belum terdaftar di kelas manapun. Silakan hubungi admin untuk mendaftar.
    </div>
    @endif
</div>
@endsection
