@extends('layouts.app')

@section('title', $activity->name)

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kegiatan
        </a>
    </div>

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

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="card-title mb-3">{{ $activity->name }}</h1>
                    
                    @if($activity->program)
                        <p class="text-muted">
                            <i class="bi bi-folder"></i> Program: <strong>{{ $activity->program->name }}</strong>
                        </p>
                    @endif

                    @if($activity->description)
                        <div class="mb-4">
                            <h5>Deskripsi</h5>
                            <p>{{ $activity->description }}</p>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informasi Kegiatan</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Tanggal Mulai</th>
                                    <td>{{ $activity->start_date->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>{{ $activity->end_date->format('d F Y') }}</td>
                                </tr>
                                @if($activity->batch)
                                <tr>
                                    <th>Batch</th>
                                    <td>{{ $activity->batch }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($activity->status == 'planned')
                                            <span class="badge bg-info">Direncanakan</span>
                                        @elseif($activity->status == 'ongoing')
                                            <span class="badge bg-success">Berlangsung</span>
                                        @elseif($activity->status == 'completed')
                                            <span class="badge bg-secondary">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Informasi Pembiayaan</h5>
                            <table class="table table-sm">
                                @if($activity->financing_type)
                                <tr>
                                    <th width="40%">Jenis Pembiayaan</th>
                                    <td>{{ $activity->financing_type }}</td>
                                </tr>
                                @endif
                                @if($activity->apbn_type)
                                <tr>
                                    <th>Tipe APBN</th>
                                    <td>{{ $activity->apbn_type }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Biaya Pendaftaran</th>
                                    <td>
                                        @if($activity->registration_fee > 0)
                                            <strong class="text-primary">Rp {{ number_format($activity->registration_fee, 0, ',', '.') }}</strong>
                                        @else
                                            <span class="text-success">Gratis</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pendaftaran</h5>
                </div>
                <div class="card-body">
                    @if($existingRegistration)
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle"></i> Anda sudah terdaftar pada kegiatan ini
                        </div>
                        
                        <h6>Status Pendaftaran:</h6>
                        @if($existingRegistration->status == 'payment_pending')
                            <span class="badge bg-warning mb-3">Menunggu Pembayaran</span>
                            <p>Silakan upload bukti pembayaran untuk melanjutkan.</p>
                            <a href="{{ route('payment.create', $existingRegistration) }}" class="btn btn-primary w-100">
                                Upload Pembayaran
                            </a>
                        @elseif($existingRegistration->status == 'payment_uploaded')
                            <span class="badge bg-info mb-3">Menunggu Validasi</span>
                            <p>Bukti pembayaran Anda sedang divalidasi oleh admin.</p>
                        @elseif($existingRegistration->status == 'validated')
                            <span class="badge bg-success mb-3">Tervalidasi</span>
                            <p>Pendaftaran Anda telah divalidasi. Anda adalah peserta kegiatan ini.</p>
                        @elseif($existingRegistration->status == 'rejected')
                            <span class="badge bg-danger mb-3">Ditolak</span>
                            <p>Pembayaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        @endif
                    @else
                        <p class="mb-3">Silakan isi formulir pendaftaran untuk mengikuti kegiatan ini.</p>
                        
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#registerModal">
                            <i class="bi bi-pencil-square"></i> Daftar Sekarang
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('activities.register', $activity) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Formulir Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select name="position" class="form-select @error('position') is-invalid @enderror" required>
                            <option value="">Pilih Jabatan</option>
                            <option value="Kepala Sekolah" {{ old('position') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                            <option value="Guru" {{ old('position') == 'Guru' ? 'selected' : '' }}>Guru</option>
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                        <input type="text" name="school_name" class="form-control @error('school_name') is-invalid @enderror" 
                               value="{{ old('school_name') }}" required>
                        @error('school_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($activity->registration_fee > 0)
                    <div class="alert alert-info">
                        <strong>Biaya Pendaftaran:</strong> Rp {{ number_format($activity->registration_fee, 0, ',', '.') }}
                        <br>
                        <small>Anda akan diarahkan ke halaman pembayaran setelah mendaftar.</small>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
