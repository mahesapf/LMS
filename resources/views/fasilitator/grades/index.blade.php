@extends('layouts.dashboard')

@section('title', 'Input Nilai - ' . $class->name)

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('fasilitator.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('fasilitator.profile') }}">Edit Biodata</a>
    <a class="nav-link active" href="{{ route('fasilitator.classes') }}">Input Nilai</a>
    <a class="nav-link" href="{{ route('fasilitator.documents') }}">Upload Dokumen</a>
    <a class="nav-link" href="{{ route('fasilitator.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Input Nilai</h1>
            <p class="text-muted mb-0">Kelas: <strong>{{ $class->name }}</strong> - {{ $class->activity->name ?? '-' }}</p>
        </div>
        <a href="{{ route('fasilitator.classes') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Peserta dan Nilai</h5>
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
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($participants as $mapping)
                        @php
                            $participant = $mapping->participant;
                            $grades = $participant->grades ?? collect();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $participant->name }}</strong></td>
                            <td>{{ $participant->email }}</td>
                            <td>{{ $participant->institution ?? '-' }}</td>
                            <td>
                                @if($grades->count() > 0)
                                    @foreach($grades as $grade)
                                    <span class="badge bg-primary me-1">
                                        {{ $grade->assessment_type }}: {{ $grade->score }}
                                    </span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Belum ada nilai</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#gradeModal{{ $participant->id }}">
                                    <i class="bi bi-pencil"></i> Input Nilai
                                </button>
                            </td>
                        </tr>

                        <!-- Grade Modal -->
                        <div class="modal fade" id="gradeModal{{ $participant->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('fasilitator.grades.store', $class) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="participant_id" value="{{ $participant->id }}">
                                        
                                        <div class="modal-header">
                                            <h5 class="modal-title">Input Nilai - {{ $participant->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="assessment_type{{ $participant->id }}" class="form-label">Jenis Penilaian <span class="text-danger">*</span></label>
                                                <select name="assessment_type" id="assessment_type{{ $participant->id }}" class="form-select @error('assessment_type') is-invalid @enderror" required>
                                                    <option value="">-- Pilih Jenis --</option>
                                                    <option value="Tugas">Tugas</option>
                                                    <option value="Quiz">Quiz</option>
                                                    <option value="UTS">UTS</option>
                                                    <option value="UAS">UAS</option>
                                                    <option value="Praktik">Praktik</option>
                                                    <option value="Proyek">Proyek</option>
                                                    <option value="Presentasi">Presentasi</option>
                                                    <option value="Kehadiran">Kehadiran</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                                @error('assessment_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="score{{ $participant->id }}" class="form-label">Nilai (0-100) <span class="text-danger">*</span></label>
                                                <input type="number" name="score" id="score{{ $participant->id }}" class="form-control @error('score') is-invalid @enderror" min="0" max="100" step="0.01" required>
                                                @error('score')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="graded_date{{ $participant->id }}" class="form-label">Tanggal Penilaian</label>
                                                <input type="date" name="graded_date" id="graded_date{{ $participant->id }}" class="form-control @error('graded_date') is-invalid @enderror" value="{{ date('Y-m-d') }}">
                                                @error('graded_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="notes{{ $participant->id }}" class="form-label">Catatan</label>
                                                <textarea name="notes" id="notes{{ $participant->id }}" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Catatan tambahan (opsional)"></textarea>
                                                @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Existing Grades -->
                                            @if($grades->count() > 0)
                                            <div class="alert alert-info">
                                                <strong>Nilai yang sudah ada:</strong>
                                                <ul class="mb-0 mt-2">
                                                    @foreach($grades as $grade)
                                                    <li>{{ $grade->assessment_type }}: {{ $grade->score }} ({{ $grade->graded_date ? $grade->graded_date->format('d/m/Y') : '-' }})</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada peserta aktif di kelas ini</td>
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
            <li>Klik tombol <strong>Input Nilai</strong> untuk menambah atau mengupdate nilai peserta</li>
            <li>Jika nilai dengan jenis penilaian yang sama sudah ada, maka akan diupdate</li>
            <li>Satu peserta dapat memiliki beberapa jenis nilai (Tugas, Quiz, UTS, UAS, dll)</li>
            <li>Nilai harus dalam rentang 0-100</li>
        </ul>
    </div>
</div>
@endsection
