@extends('layouts.dashboard')

@section('title', 'Kelola Pendaftaran Peserta')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('admin.programs.index') }}">Program</a>
    <a class="nav-link" href="{{ route('admin.classes.index') }}">Kelas</a>
    <a class="nav-link" href="{{ route('admin.payments.index') }}">Validasi Pembayaran</a>
    <a class="nav-link active" href="{{ route('admin.registrations.index') }}">Kelola Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Kelola Pendaftaran Peserta</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Peserta Tervalidasi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal Daftar</th>
                            <th>Nama Peserta</th>
                            <th>Jabatan</th>
                            <th>Sekolah</th>
                            <th>Program</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $registration)
                        <tr>
                            <td>{{ $registration->created_at->format('d M Y') }}</td>
                            <td>
                                {{ $registration->name }}<br>
                                <small class="text-muted">{{ $registration->email }}</small><br>
                                <small class="text-muted">{{ $registration->phone }}</small>
                            </td>
                            <td>{{ $registration->position }}</td>
                            <td>{{ $registration->school_name }}</td>
                            <td>{{ $registration->program->name }}</td>
                            <td>
                                @if($registration->class)
                                    <span class="badge bg-success">{{ $registration->class->name }}</span>
                                @else
                                    <span class="badge bg-warning">Belum Ditentukan</span>
                                @endif
                            </td>
                            <td>
                                @if(!$registration->class)
                                    <button type="button" class="btn btn-sm btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#assignModal{{ $registration->id }}">
                                        <i class="bi bi-person-plus"></i> Assign ke Kelas
                                    </button>
                                @else
                                    <form action="{{ route('admin.registrations.removeFromClass', $registration) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus peserta dari kelas?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-person-dash"></i> Hapus dari Kelas
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        <!-- Assign Modal -->
                        <div class="modal fade" id="assignModal{{ $registration->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.registrations.assignToClass', $registration) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Assign Peserta ke Kelas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Peserta:</strong></label>
                                                <p>{{ $registration->name }} - {{ $registration->program->name }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <label for="class_id{{ $registration->id }}" class="form-label">
                                                    Pilih Kelas <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" 
                                                        id="class_id{{ $registration->id }}" 
                                                        name="class_id" required>
                                                    <option value="">Pilih Kelas</option>
                                                    @foreach($classes->where('program_id', $registration->program_id) as $class)
                                                        <option value="{{ $class->id }}">
                                                            {{ $class->name }} - {{ $class->program->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @if($classes->where('program_id', $registration->program_id)->count() == 0)
                                                <div class="alert alert-warning">
                                                    <i class="bi bi-exclamation-triangle"></i>
                                                    Belum ada kelas untuk program ini. 
                                                    <a href="{{ route('admin.classes.create') }}">Buat kelas baru</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary" 
                                                    @if($classes->where('program_id', $registration->program_id)->count() == 0) disabled @endif>
                                                Assign ke Kelas
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada peserta yang tervalidasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
