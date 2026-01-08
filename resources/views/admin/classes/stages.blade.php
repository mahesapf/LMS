@extends('layouts.dashboard')

@section('title', 'Kelola Tahap - ' . $class->name)

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
            <h1>Kelola Tahap</h1>
            <p class="text-muted mb-0">Kelas: <strong>{{ $class->name }}</strong></p>
        </div>
        <a href="{{ route('admin.classes') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
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

    <!-- Add Stage Button -->
    <div class="mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStageModal">
            <i class="bi bi-plus-circle"></i> Tambah Tahap
        </button>
        <a href="{{ route('admin.classes.documents', $class) }}" class="btn btn-info">
            <i class="bi bi-file-earmark-text"></i> Kelola Dokumen Requirement
        </a>
    </div>

    <!-- Stages List -->
    <div class="row">
        @forelse($stages as $stage)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $stage->name }}</h5>
                    <span class="badge
                        @if($stage->status == 'ongoing') bg-success
                        @elseif($stage->status == 'completed') bg-secondary
                        @else bg-warning
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $stage->status)) }}
                    </span>
                </div>
                <div class="card-body">
                    @if($stage->description)
                    <p class="card-text">{{ $stage->description }}</p>
                    @endif

                    <dl class="row mb-0">
                        <dt class="col-sm-5">Urutan:</dt>
                        <dd class="col-sm-7">{{ $stage->order }}</dd>

                        @if($stage->start_date)
                        <dt class="col-sm-5">Mulai:</dt>
                        <dd class="col-sm-7">{{ $stage->start_date->format('d M Y') }}</dd>
                        @endif

                        @if($stage->end_date)
                        <dt class="col-sm-5">Selesai:</dt>
                        <dd class="col-sm-7">{{ $stage->end_date->format('d M Y') }}</dd>
                        @endif

                        <dt class="col-sm-5">Dokumen:</dt>
                        <dd class="col-sm-7">{{ $stage->documentRequirements->count() }} requirement</dd>
                    </dl>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStageModal{{ $stage->id }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <form action="{{ route('admin.classes.stages.destroy', [$class, $stage]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus tahap ini? Semua dokumen requirement di tahap ini akan ikut terhapus.')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Stage Modal -->
        <div class="modal fade" id="editStageModal{{ $stage->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.classes.stages.update', [$class, $stage]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Tahap</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name{{ $stage->id }}" class="form-label">Nama Tahap <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name{{ $stage->id }}" class="form-control" value="{{ $stage->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description{{ $stage->id }}" class="form-label">Deskripsi</label>
                                <textarea name="description" id="description{{ $stage->id }}" rows="3" class="form-control">{{ $stage->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="order{{ $stage->id }}" class="form-label">Urutan <span class="text-danger">*</span></label>
                                <input type="number" name="order" id="order{{ $stage->id }}" class="form-control" value="{{ $stage->order }}" min="1" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date{{ $stage->id }}" class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date{{ $stage->id }}" class="form-control" value="{{ $stage->start_date?->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date{{ $stage->id }}" class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="end_date" id="end_date{{ $stage->id }}" class="form-control" value="{{ $stage->end_date?->format('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status{{ $stage->id }}" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status{{ $stage->id }}" class="form-select" required>
                                    <option value="not_started" {{ $stage->status == 'not_started' ? 'selected' : '' }}>Belum Dimulai</option>
                                    <option value="ongoing" {{ $stage->status == 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                                    <option value="completed" {{ $stage->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
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
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Belum ada tahap dibuat. Klik tombol "Tambah Tahap" untuk membuat tahap baru.
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Stage Modal -->
<div class="modal fade" id="addStageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.classes.stages.store', $class) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tahap Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Tahap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g., Tahap 1, Tahap Persiapan" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Deskripsi tahap (opsional)"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Urutan <span class="text-danger">*</span></label>
                        <input type="number" name="order" id="order" class="form-control" value="{{ $stages->count() + 1 }}" min="1" required>
                        <small class="text-muted">Urutan tahap dalam kelas</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="not_started" selected>Belum Dimulai</option>
                            <option value="ongoing">Sedang Berjalan</option>
                            <option value="completed">Selesai</option>
                        </select>
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
@endsection
