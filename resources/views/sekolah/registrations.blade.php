@extends('layouts.sekolah')

@section('title', 'Pendaftaran Saya')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Pendaftaran Kegiatan</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('sekolah.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pendaftaran</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Daftar Pendaftaran</h4>
                        <a href="{{ route('activities.index') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Daftar Kegiatan Baru
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kegiatan</th>
                                    <th>Program</th>
                                    <th>Tanggal Kegiatan</th>
                                    <th>Jumlah Peserta</th>
                                    <th>Status Pendaftaran</th>
                                    <th>Pembayaran</th>
                                    <th>Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $index => $registration)
                                    <tr>
                                        <td>{{ $registrations->firstItem() + $index }}</td>
                                        <td>{{ $registration->activity->name ?? '-' }}</td>
                                        <td>{{ $registration->activity->program->name ?? '-' }}</td>
                                        <td>
                                            @if($registration->activity)
                                                {{ \Carbon\Carbon::parse($registration->activity->start_date)->format('d M Y') }} - 
                                                {{ \Carbon\Carbon::parse($registration->activity->end_date)->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ $registration->jumlah_peserta > 0 ? $registration->jumlah_peserta : ($registration->jumlah_kepala_sekolah + $registration->jumlah_guru) }}
                                        </td>
                                        <td>
                                            @if($registration->status == 'pending')
                                                <span class="badge badge-warning">Menunggu</span>
                                            @elseif($registration->status == 'approved')
                                                <span class="badge badge-success">Disetujui</span>
                                            @else
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($registration->payment)
                                                @if($registration->payment->status == 'pending')
                                                    <span class="badge badge-warning">Verifikasi</span>
                                                @elseif($registration->payment->status == 'approved')
                                                    <span class="badge badge-success">Lunas</span>
                                                @else
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            @else
                                                @if($registration->activity && $registration->calculateTotalPayment() > 0)
                                                    <a href="{{ route('payment.create', $registration) }}" class="btn btn-sm btn-primary">
                                                        Bayar
                                                    </a>
                                                @else
                                                    <span class="badge badge-secondary">Gratis</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $registration->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <div class="py-4">
                                                <p class="text-muted mb-3">Belum ada pendaftaran kegiatan</p>
                                                <a href="{{ route('activities.index') }}" class="btn btn-primary">
                                                    Daftar Kegiatan Sekarang
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($registrations->hasPages())
                        <div class="mt-4">
                            {{ $registrations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
