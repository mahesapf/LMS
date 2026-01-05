@extends('layouts.dashboard')

@section('title', 'Peserta Kelas - ' . $class->name)

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('fasilitator.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('fasilitator.profile') }}">Edit Biodata</a>
    <a class="nav-link" href="{{ route('fasilitator.classes') }}">Input Nilai</a>
    <a class="nav-link" href="{{ route('fasilitator.documents') }}">Upload Dokumen</a>
    <a class="nav-link active" href="{{ route('fasilitator.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Pemetaan Peserta</h1>
            <p class="text-muted mb-0">Kelas: <strong>{{ $class->name }}</strong> - {{ $class->activity->name ?? '-' }}</p>
        </div>
        <a href="{{ route('fasilitator.mappings.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Form Add Participant -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Peserta</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('fasilitator.classes.participants.assign', $class) }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="participant_id" class="form-label">Pilih Peserta <span class="text-danger">*</span></label>
                            <select name="participant_id" id="participant_id" class="form-select @error('participant_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Peserta --</option>
                                @foreach($availableParticipants as $participant)
                                <option value="{{ $participant->id }}">
                                    {{ $participant->name }} ({{ $participant->institution ?? '-' }})
                                </option>
                                @endforeach
                            </select>
                            @error('participant_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="enrolled_date" class="form-label">Tanggal Masuk</label>
                            <input type="date" name="enrolled_date" id="enrolled_date" class="form-control @error('enrolled_date') is-invalid @enderror" value="{{ old('enrolled_date', date('Y-m-d')) }}">
                            @error('enrolled_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea name="notes" id="notes" rows="2" class="form-control @error('notes') is-invalid @enderror" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Tambahkan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Participants -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Peserta</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peserta</th>
                                    <th>Email</th>
                                    <th>Institusi</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mappings as $mapping)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $mapping->participant->name ?? '-' }}</strong>
                                        @if($mapping->notes)
                                        <br><small class="text-muted">{{ $mapping->notes }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $mapping->participant->email ?? '-' }}</td>
                                    <td>{{ $mapping->participant->institution ?? '-' }}</td>
                                    <td>{{ $mapping->enrolled_date ? $mapping->enrolled_date->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($mapping->status == 'in')
                                        <span class="badge bg-success">Aktif</span>
                                        @elseif($mapping->status == 'move')
                                        <span class="badge bg-warning">Pindah</span>
                                        @else
                                        <span class="badge bg-danger">Keluar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($mapping->status == 'in')
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#moveModal{{ $mapping->id }}" title="Pindah Kelas">
                                                <i class="bi bi-arrow-right-circle"></i>
                                            </button>
                                            <form action="{{ route('fasilitator.mappings.remove', $mapping) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengeluarkan peserta ini dari kelas?')">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Move Modal -->
                                        <div class="modal fade" id="moveModal{{ $mapping->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('fasilitator.mappings.move', $mapping) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Pindah Kelas</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Pindahkan <strong>{{ $mapping->participant->name }}</strong> ke kelas:</p>
                                                            <div class="mb-3">
                                                                <label for="new_class_id{{ $mapping->id }}" class="form-label">Pilih Kelas Baru <span class="text-danger">*</span></label>
                                                                <select name="new_class_id" id="new_class_id{{ $mapping->id }}" class="form-select" required>
                                                                    <option value="">-- Pilih Kelas --</option>
                                                                    @foreach($availableClasses as $availableClass)
                                                                    <option value="{{ $availableClass->id }}">{{ $availableClass->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="move_notes{{ $mapping->id }}" class="form-label">Catatan</label>
                                                                <textarea name="notes" id="move_notes{{ $mapping->id }}" rows="2" class="form-control" placeholder="Alasan pemindahan"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-warning">Pindahkan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada peserta di kelas ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle"></i> <strong>Info:</strong>
                <ul class="mb-0 mt-2">
                    <li><strong>Tambah:</strong> Menambahkan peserta baru ke kelas</li>
                    <li><strong>Pindah:</strong> Memindahkan peserta ke kelas lain yang Anda handle</li>
                    <li><strong>Hapus:</strong> Mengeluarkan peserta dari kelas (status menjadi OUT)</li>
                    <li>Hanya peserta dengan status AKTIF yang dapat dipindah/dihapus</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
