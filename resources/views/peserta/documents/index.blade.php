@extends('layouts.dashboard')

@section('title', 'Dokumen Saya')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('peserta.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('peserta.profile') }}">Profil</a>
    <a class="nav-link" href="{{ route('peserta.biodata') }}">Biodata</a>
    <a class="nav-link" href="{{ route('peserta.classes') }}">Kelas & Nilai Saya</a>
    <a class="nav-link active" href="{{ route('peserta.documents') }}">Dokumen</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dokumen Saya</h1>
    <p class="text-muted">Upload dokumen yang diminta sesuai tahap kegiatan</p>

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
                $stages = $mapping->class->stages ?? collect();
            @endphp

            @if($stages->count() > 0)
            <!-- Stages Accordion -->
            <div class="accordion" id="accordion{{ $mapping->class->id }}">
                @foreach($stages as $stage)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $stage->id }}">
                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $stage->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                            <strong>{{ $stage->name }}</strong>
                            <span class="badge ms-2 
                                @if($stage->status == 'ongoing') bg-success
                                @elseif($stage->status == 'completed') bg-secondary
                                @else bg-warning text-dark
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $stage->status)) }}
                            </span>
                            @php
                                $totalDocs = $stage->documentRequirements->count();
                                $uploadedDocs = $stage->documentRequirements->filter(function($req) {
                                    return $req->documents->where('uploaded_by', Auth::id())->count() > 0;
                                })->count();
                            @endphp
                            <span class="badge bg-info ms-2">{{ $uploadedDocs }}/{{ $totalDocs }} dokumen</span>
                        </button>
                    </h2>
                    <div id="collapse{{ $stage->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}">
                        <div class="accordion-body">
                            @if($stage->description)
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> {{ $stage->description }}
                            </div>
                            @endif

                            @if($stage->start_date || $stage->end_date)
                            <p class="text-muted small mb-3">
                                @if($stage->start_date)
                                <i class="bi bi-calendar-check"></i> Mulai: {{ $stage->start_date->format('d M Y') }}
                                @endif
                                @if($stage->end_date)
                                | <i class="bi bi-calendar-x"></i> Selesai: {{ $stage->end_date->format('d M Y') }}
                                @endif
                            </p>
                            @endif

                            @if($stage->documentRequirements->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
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
                                        @foreach($stage->documentRequirements as $req)
                                        @php
                                            $uploaded = $req->documents->where('uploaded_by', Auth::id())->first();
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
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($uploaded)
                                                <div class="btn-group-vertical btn-group-sm" role="group">
                                                    <a href="{{ Storage::url($uploaded->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="bi bi-download"></i> Lihat
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $req->id }}">
                                                        <i class="bi bi-upload"></i> Ganti
                                                    </button>
                                                    <form action="{{ route('peserta.documents.destroy', $uploaded) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Yakin ingin menghapus?')">
                                                            <i class="bi bi-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                                @else
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $req->id }}">
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
                                                        <input type="hidden" name="class_id" value="{{ $mapping->class->id }}">
                                                        
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Upload {{ $req->document_name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if($req->description)
                                                            <div class="alert alert-info">
                                                                {{ $req->description }}
                                                            </div>
                                                            @endif

                                                            <div class="mb-3">
                                                                <label for="file{{ $req->id }}" class="form-label">Pilih File <span class="text-danger">*</span></label>
                                                                <input type="file" name="file" id="file{{ $req->id }}" class="form-control" required 
                                                                       @if($req->document_type) accept=".{{ str_replace(',', ',.', $req->document_type) }}" @endif>
                                                                <small class="text-muted">
                                                                    @if($req->document_type)
                                                                    Tipe: {{ strtoupper($req->document_type) }} | 
                                                                    @endif
                                                                    Maks: {{ number_format($req->max_file_size / 1024, 1) }} MB
                                                                </small>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="notes{{ $req->id }}" class="form-label">Catatan (Opsional)</label>
                                                                <textarea name="notes" id="notes{{ $req->id }}" rows="3" class="form-control" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                                                            </div>

                                                            @if($uploaded)
                                                            <div class="alert alert-warning">
                                                                <i class="bi bi-exclamation-triangle"></i> File yang sudah ada akan diganti dengan file baru.
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Upload</button>
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
                @endforeach
            </div>
            @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Belum ada tahap yang dibuat untuk kelas ini.
            </div>
            @endif
        </div>
    </div>
    @endforeach
    @else
    <div class="alert alert-info text-center">
        <i class="bi bi-info-circle"></i>
        <p class="mb-0">Anda belum terdaftar di kelas manapun.</p>
    </div>
    @endif
</div>
@endsection
