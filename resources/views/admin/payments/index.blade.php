@extends('layouts.dashboard')

@section('title', 'Validasi Pembayaran')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('admin.programs.index') }}">Program</a>
    <a class="nav-link" href="{{ route('admin.classes.index') }}">Kelas</a>
    <a class="nav-link active" href="{{ route('admin.payments.index') }}">Validasi Pembayaran</a>
    <a class="nav-link" href="{{ route('admin.registrations.index') }}">Kelola Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Validasi Pembayaran</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Pending Payments -->
    <div class="card mb-4">
        <div class="card-header bg-warning">
            <h5 class="mb-0">Pembayaran Menunggu Validasi ({{ $payments->count() }})</h5>
        </div>
        <div class="card-body">
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal Upload</th>
                                <th>Nama Peserta</th>
                                <th>Program</th>
                                <th>Bank</th>
                                <th>Jumlah</th>
                                <th>Tgl Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    {{ $payment->registration->name }}<br>
                                    <small class="text-muted">{{ $payment->registration->email }}</small>
                                </td>
                                <td>{{ $payment->registration->program->name }}</td>
                                <td>{{ $payment->bank_name }}</td>
                                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewPaymentModal{{ $payment->id }}">
                                        <i class="bi bi-eye"></i> Lihat
                                    </button>
                                </td>
                            </tr>

                            <!-- View Payment Modal -->
                            <div class="modal fade" id="viewPaymentModal{{ $payment->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Informasi Peserta</h6>
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <td>Nama</td>
                                                            <td>: {{ $payment->registration->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email</td>
                                                            <td>: {{ $payment->registration->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Telepon</td>
                                                            <td>: {{ $payment->registration->phone }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jabatan</td>
                                                            <td>: {{ $payment->registration->position }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sekolah</td>
                                                            <td>: {{ $payment->registration->school_name }}</td>
                                                        </tr>
                                                    </table>

                                                    <h6 class="mt-3">Informasi Pembayaran</h6>
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <td>Bank</td>
                                                            <td>: {{ $payment->bank_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumlah</td>
                                                            <td>: Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanggal</td>
                                                            <td>: {{ \Carbon\Carbon::parse($payment->payment_date)->format('d F Y') }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Bukti Pembayaran</h6>
                                                    <img src="{{ Storage::url($payment->proof_file) }}" 
                                                         class="img-fluid rounded" 
                                                         alt="Bukti Pembayaran">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.payments.validate', $payment) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bi bi-check-circle"></i> Validasi
                                                </button>
                                            </form>
                                            
                                            <button type="button" class="btn btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejectModal{{ $payment->id }}">
                                                <i class="bi bi-x-circle"></i> Tolak
                                            </button>
                                            
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $payment->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tolak Pembayaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="rejection_reason{{ $payment->id }}" class="form-label">
                                                        Alasan Penolakan <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea class="form-control" 
                                                              id="rejection_reason{{ $payment->id }}" 
                                                              name="rejection_reason" 
                                                              rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
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
                <p class="text-muted mb-0">Tidak ada pembayaran yang menunggu validasi.</p>
            @endif
        </div>
    </div>

    <!-- History -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Riwayat Validasi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal Validasi</th>
                            <th>Nama Peserta</th>
                            <th>Program</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Validator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($validatedPayments as $payment)
                        <tr>
                            <td>{{ $payment->validated_at->format('d M Y H:i') }}</td>
                            <td>{{ $payment->registration->name }}</td>
                            <td>{{ $payment->registration->program->name }}</td>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($payment->status == 'validated')
                                    <span class="badge bg-success">Tervalidasi</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $payment->validator->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada riwayat validasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $validatedPayments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
