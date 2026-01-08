@extends('layouts.dashboard')

@section('title', 'Validasi Pembayaran')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Validasi Pembayaran</h1>
            <p class="mt-1 text-sm text-slate-500">Periksa bukti pembayaran, validasi atau tolak dengan alasan.</p>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="rounded-xl border border-amber-200 bg-white shadow-sm">
        <div class="border-b border-amber-200 bg-amber-50 px-4 py-3">
            <h2 class="text-sm font-semibold text-amber-800">Pembayaran Menunggu Validasi ({{ $payments->count() }})</h2>
        </div>
        <div class="p-4">
            @if($payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Upload</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Peserta</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Program</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Bank</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Jumlah</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tgl Bayar</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($payments as $payment)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $payment->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <div class="text-slate-900 font-semibold">{{ $payment->registration->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $payment->registration->email }}</div>
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-700">
                                    {{ $payment->registration->activity->name }}
                                    @if($payment->registration->activity->program)
                                        <div class="text-xs text-slate-500">{{ $payment->registration->activity->program->name }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $payment->bank_name }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <div class="flex justify-end">
                                        <button type="button" class="inline-flex items-center rounded-md border border-sky-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-sky-700 shadow-sm hover:bg-sky-50"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewPaymentModal{{ $payment->id }}">
                                            Lihat
                                        </button>
                                    </div>
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
                                                    <h6>Informasi Kegiatan</h6>
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <td>Kegiatan</td>
                                                            <td>: {{ $payment->registration->activity->name }}</td>
                                                        </tr>
                                                        @if($payment->registration->activity->program)
                                                        <tr>
                                                            <td>Program</td>
                                                            <td>: {{ $payment->registration->activity->program->name }}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td>Biaya</td>
                                                            <td>: Rp {{ number_format($payment->registration->activity->registration_fee, 0, ',', '.') }}</td>
                                                        </tr>
                                                    </table>

                                                    <h6 class="mt-3">Informasi Peserta</h6>
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
                                                    <a href="{{ Storage::url($payment->proof_file) }}" target="_blank">
                                                        <img src="{{ Storage::url($payment->proof_file) }}"
                                                             class="img-fluid rounded border"
                                                             alt="Bukti Pembayaran"
                                                             style="max-height: 400px; cursor: pointer;">
                                                    </a>
                                                    <p class="text-muted small mt-2">
                                                        <i class="bi bi-info-circle"></i> Klik gambar untuk melihat ukuran penuh
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('super-admin.payments.approve', $payment) }}"
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
                                        <form action="{{ route('super-admin.payments.reject', $payment) }}" method="POST">
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
                <p class="text-sm text-slate-500">Tidak ada pembayaran yang menunggu validasi.</p>
            @endif
        </div>
    </div>

    <!-- History -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
            <h2 class="text-sm font-semibold text-slate-800">Riwayat Validasi</h2>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Validasi</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Peserta</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Program</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Jumlah</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Validator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($validatedPayments as $payment)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $payment->validated_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 text-sm text-slate-900">{{ $payment->registration->name }}</td>
                            <td class="px-4 py-2 text-sm text-slate-700">
                                {{ $payment->registration->activity->name }}
                                @if($payment->registration->activity->program)
                                    <div class="text-xs text-slate-500">{{ $payment->registration->activity->program->name }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($payment->status == 'validated')
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Tervalidasi</span>
                                @else
                                    <span class="inline-flex rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-semibold text-rose-700">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $payment->validator->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada riwayat validasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $validatedPayments->links() }}</div>
        </div>
    </div>
</div>
@endsection
