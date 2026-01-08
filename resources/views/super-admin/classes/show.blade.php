@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Kelas: {{ $class->name }}</h5>
                    <a href="{{ route($routePrefix . '.classes.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="200">Nama Kelas</th>
                                    <td>{{ $class->name }}</td>
                                </tr>
                                <tr>
                                    <th>Kegiatan</th>
                                    <td>{{ $class->activity->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kapasitas</th>
                                    <td>{{ $class->capacity }} peserta</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Peserta Saat Ini</th>
                                    <td>
                                        <span class="badge {{ $class->participantMappings->count() >= $class->capacity ? 'bg-danger' : 'bg-success' }}">
                                            {{ $class->participantMappings->count() }} / {{ $class->capacity }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="200">Tanggal Mulai</th>
                                    <td>{{ $class->start_date ? \Carbon\Carbon::parse($class->start_date)->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>{{ $class->end_date ? \Carbon\Carbon::parse($class->end_date)->format('d/m/Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($class->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($class->status == 'completed')
                                            <span class="badge bg-secondary">Selesai</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat Oleh</th>
                                    <td>{{ $class->creator->name ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if($class->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Deskripsi:</h6>
                            <p>{{ $class->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill"></i> Daftar Peserta Kelas
                    </h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#assignModal">
                        <i class="bi bi-plus-circle"></i> Tambah Peserta
                    </button>
                </div>
                <div class="card-body">
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

                    @if($class->participantMappings->isEmpty())
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Belum ada peserta di kelas ini. Klik tombol "Tambah Peserta" untuk menambahkan peserta.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Nama Peserta</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Tanggal Bergabung</th>
                                        <th>Status</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($class->participantMappings as $index => $mapping)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $mapping->participant->name ?? '-' }}</td>
                                        <td>{{ $mapping->participant->email ?? '-' }}</td>
                                        <td>{{ $mapping->participant->phone ?? '-' }}</td>
                                        <td>{{ $mapping->enrolled_date ? \Carbon\Carbon::parse($mapping->enrolled_date)->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            @if($mapping->status == 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($mapping->status == 'completed')
                                                <span class="badge bg-primary">Selesai</span>
                                            @elseif($mapping->status == 'dropped')
                                                <span class="badge bg-danger">Keluar</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $mapping->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route($routePrefix . '.classes.removeParticipant', [$class, $mapping]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Keluarkan dari Kelas"
                                                    onclick="return confirm('Yakin ingin mengeluarkan {{ $mapping->participant->name ?? 'peserta ini' }} dari kelas?')">
                                                    <i class="bi bi-person-dash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Fasilitator Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-person-badge"></i> Daftar Fasilitator Kelas
                    </h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#assignFasilitatorModal">
                        <i class="bi bi-plus-circle"></i> Tambah Fasilitator
                    </button>
                </div>
                <div class="card-body">
                    @if($class->fasilitatorMappings->where('status', 'in')->isEmpty())
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Belum ada fasilitator di kelas ini. Klik tombol "Tambah Fasilitator" untuk menambahkan fasilitator.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Nama Fasilitator</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Tanggal Ditambahkan</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($class->fasilitatorMappings->where('status', 'in') as $index => $mapping)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $mapping->fasilitator->name ?? '-' }}</td>
                                        <td>{{ $mapping->fasilitator->email ?? '-' }}</td>
                                        <td>{{ $mapping->fasilitator->phone ?? '-' }}</td>
                                        <td>{{ $mapping->assigned_date ? \Carbon\Carbon::parse($mapping->assigned_date)->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            <form action="{{ route($routePrefix . '.classes.removeFasilitator', [$class, $mapping]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Keluarkan dari Kelas"
                                                    onclick="return confirm('Yakin ingin mengeluarkan {{ $mapping->fasilitator->name ?? 'fasilitator ini' }} dari kelas?')">
                                                    <i class="bi bi-person-dash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Assign Peserta -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route($routePrefix . '.classes.assignParticipant', $class) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Tambah Peserta ke Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($availableParticipants->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            Tidak ada peserta yang tersedia untuk ditambahkan.
                            Semua peserta sudah terdaftar di kelas atau belum ada peserta yang tervalidasi untuk kegiatan ini.
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="participant_id" class="form-label">Pilih Peserta <span class="text-danger">*</span></label>
                            <select class="form-select" id="participant_id" name="participant_id" required>
                                <option value="">-- Pilih Peserta --</option>
                                @foreach($availableParticipants as $participant)
                                    <option value="{{ $participant->id }}">
                                        {{ $participant->name }} - {{ $participant->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <small>
                                <i class="bi bi-info-circle"></i>
                                Hanya peserta yang sudah divalidasi pembayarannya dan belum masuk kelas yang ditampilkan.
                            </small>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    @if(!$availableParticipants->isEmpty())
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambahkan
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Assign Fasilitator -->
<div class="modal fade" id="assignFasilitatorModal" tabindex="-1" aria-labelledby="assignFasilitatorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route($routePrefix . '.classes.assignFasilitator', $class) }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="assignFasilitatorModalLabel">Tambah Fasilitator ke Kelas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($availableFasilitators->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            Tidak ada fasilitator yang tersedia untuk ditambahkan.
                            Semua fasilitator sudah terdaftar di kelas atau belum ada fasilitator aktif.
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="fasilitator_id" class="form-label">Pilih Fasilitator <span class="text-danger">*</span></label>
                            <select class="form-select @error('fasilitator_id') is-invalid @enderror" id="fasilitator_id" name="fasilitator_id" required>
                                <option value="">-- Pilih Fasilitator --</option>
                                @foreach($availableFasilitators as $fasilitator)
                                    <option value="{{ $fasilitator->id }}">
                                        {{ $fasilitator->name }} - {{ $fasilitator->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <small>
                                <i class="bi bi-info-circle"></i>
                                Hanya fasilitator yang aktif dan belum ditugaskan di kelas ini yang ditampilkan.
                            </small>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    @if(!$availableFasilitators->isEmpty())
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Tambahkan
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
