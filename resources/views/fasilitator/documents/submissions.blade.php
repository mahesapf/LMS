@extends('layouts.dashboard')

@section('title', 'Detail Submisi - ' . $requirement->document_name)

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>{{ $requirement->document_name }}</h1>
            <p class="text-muted mb-0">{{ $class->name }} - {{ $class->activity->name ?? '-' }}</p>
        </div>
        <a href="{{ route('fasilitator.classes.document-requirements', $class) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Requirement Info -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Tugas</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nama Tugas:</dt>
                        <dd class="col-sm-8"><strong>{{ $requirement->document_name }}</strong></dd>

                        <dt class="col-sm-4">Tahap:</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-secondary">{{ $requirement->stage->name ?? 'Umum' }}</span>
                        </dd>

                        <dt class="col-sm-4">Tipe Dokumen:</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-info">{{ strtoupper($requirement->document_type) }}</span>
                        </dd>

                        <dt class="col-sm-4">Status:</dt>
                        <dd class="col-sm-8">
                            @if($requirement->is_required)
                                <span class="badge bg-danger">Wajib</span>
                            @else
                                <span class="badge bg-secondary">Opsional</span>
                            @endif
                        </dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    @if($requirement->description)
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Deskripsi:</dt>
                        <dd class="col-sm-8">{{ $requirement->description }}</dd>
                    </dl>
                    @endif

                    @if($requirement->max_file_size)
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Ukuran Maks:</dt>
                        <dd class="col-sm-8">{{ $requirement->max_file_size }} MB</dd>
                    </dl>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h6 class="card-title text-primary mb-2">Total Peserta</h6>
                    <h2 class="mb-0">{{ $stats['total_participants'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h6 class="card-title text-success mb-2">Sudah Submit</h6>
                    <h2 class="mb-0 text-success">{{ $stats['submitted'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <h6 class="card-title text-danger mb-2">Belum Submit</h6>
                    <h2 class="mb-0 text-danger">{{ $stats['not_submitted'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h6 class="card-title text-info mb-2">Completion Rate</h6>
                    <h2 class="mb-0 text-info">{{ $stats['completion_rate'] }}%</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Submissions List -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Submisi Peserta</h5>
            <div>
                <button class="btn btn-sm btn-success" onclick="filterSubmissions('submitted')">
                    <i class="bi bi-check-circle"></i> Sudah Submit ({{ $stats['submitted'] }})
                </button>
                <button class="btn btn-sm btn-danger" onclick="filterSubmissions('not_submitted')">
                    <i class="bi bi-x-circle"></i> Belum Submit ({{ $stats['not_submitted'] }})
                </button>
                <button class="btn btn-sm btn-secondary" onclick="filterSubmissions('all')">
                    <i class="bi bi-list"></i> Semua
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="submissionsTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>Email</th>
                            <th>Instansi</th>
                            <th>Status</th>
                            <th>Waktu Submit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participantSubmissions as $index => $data)
                        <tr class="submission-row" data-status="{{ $data['has_submitted'] ? 'submitted' : 'not_submitted' }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $data['participant']->name }}</strong>
                            </td>
                            <td>{{ $data['participant']->email }}</td>
                            <td>{{ $data['participant']->instansi ?? '-' }}</td>
                            <td>
                                @if($data['has_submitted'])
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Sudah Submit
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Belum Submit
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($data['submitted_at'])
                                    {{ \Carbon\Carbon::parse($data['submitted_at'])->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($data['has_submitted'])
                                    <a href="{{ Storage::url($data['file_path']) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-primary"
                                       title="Lihat Dokumen">
                                        <i class="bi bi-file-earmark-text"></i> Lihat File
                                    </a>
                                    <a href="{{ Storage::url($data['file_path']) }}"
                                       download="{{ $data['file_name'] }}"
                                       class="btn btn-sm btn-success"
                                       title="Download Dokumen">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function filterSubmissions(status) {
    const rows = document.querySelectorAll('.submission-row');

    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = '';
        } else {
            if (row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
</script>
@endsection
