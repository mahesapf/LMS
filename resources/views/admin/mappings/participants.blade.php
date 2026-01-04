@extends('layouts.dashboard')

@section('title', 'Pemetaan Peserta - ' . $class->name)

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('admin.participants') }}">Manajemen Peserta</a>
    <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
    <a class="nav-link" href="{{ route('admin.classes') }}">Kelas</a>
    <a class="nav-link active" href="{{ route('admin.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Pemetaan Peserta</h1>
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

    <!-- Add Participant Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Peserta ke Kelas</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.classes.participants.assign', $class) }}" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label for="participant_id" class="form-label">Pilih Peserta <span class="text-danger">*</span></label>
                    <select class="form-select @error('participant_id') is-invalid @enderror" 
                            id="participant_id" name="participant_id" required>
                        <option value="">Pilih Peserta</option>
                        @foreach($availableParticipants as $participant)
                        <option value="{{ $participant->id }}">
                            {{ $participant->name }} ({{ $participant->email }})
                        </option>
                        @endforeach
                    </select>
                    @error('participant_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="enrolled_date" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control @error('enrolled_date') is-invalid @enderror" 
                           id="enrolled_date" name="enrolled_date" value="{{ old('enrolled_date', date('Y-m-d')) }}">
                    @error('enrolled_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="notes" class="form-label">Catatan</label>
                    <input type="text" class="form-control @error('notes') is-invalid @enderror" 
                           id="notes" name="notes" value="{{ old('notes') }}">
                    @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Participants List -->
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
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mappings as $mapping)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mapping->participant->name ?? '-' }}</td>
                            <td>{{ $mapping->participant->email ?? '-' }}</td>
                            <td>{{ $mapping->participant->institution ?? '-' }}</td>
                            <td>
                                @if($mapping->status == 'in')
                                <span class="badge bg-success">In</span>
                                @elseif($mapping->status == 'move')
                                <span class="badge bg-warning">Move</span>
                                @else
                                <span class="badge bg-danger">Out</span>
                                @endif
                            </td>
                            <td>
                                @if($mapping->status == 'in')
                                {{ $mapping->enrolled_date ? \Carbon\Carbon::parse($mapping->enrolled_date)->format('d M Y') : '-' }}
                                @elseif($mapping->status == 'move')
                                {{ $mapping->moved_date ? \Carbon\Carbon::parse($mapping->moved_date)->format('d M Y') : '-' }}
                                @else
                                {{ $mapping->removed_date ? \Carbon\Carbon::parse($mapping->removed_date)->format('d M Y') : '-' }}
                                @endif
                            </td>
                            <td>{{ $mapping->notes ?? '-' }}</td>
                            <td>
                                @if($mapping->status == 'in')
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#moveModal{{ $mapping->id }}"
                                            title="Pindah">
                                        <i class="bi bi-arrow-right-circle"></i>
                                    </button>
                                    <form action="{{ route('admin.mappings.remove', $mapping) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger" 
                                                title="Keluar"
                                                onclick="return confirm('Yakin ingin mengeluarkan peserta ini dari kelas?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Move Modal -->
                                <div class="modal fade" id="moveModal{{ $mapping->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Pindah Peserta</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.mappings.move', $mapping) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Peserta:</label>
                                                        <input type="text" class="form-control" value="{{ $mapping->participant->name }}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="new_class_id{{ $mapping->id }}" class="form-label">Pindah ke Kelas <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="new_class_id{{ $mapping->id }}" name="new_class_id" required>
                                                            <option value="">Pilih Kelas</option>
                                                            @foreach(\App\Models\Classes::where('id', '!=', $class->id)->where('status', 'open')->get() as $otherClass)
                                                            <option value="{{ $otherClass->id }}">{{ $otherClass->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="notes{{ $mapping->id }}" class="form-label">Catatan</label>
                                                        <textarea class="form-control" id="notes{{ $mapping->id }}" name="notes" rows="2"></textarea>
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
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada peserta di kelas ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
