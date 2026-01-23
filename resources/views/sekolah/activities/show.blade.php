@extends('layouts.sekolah')

@section('title', 'Detail Pendaftaran - ' . $activity->name)

@section('content')
<div class="space-y-6">
    @php
        $totalPeserta = $existingRegistration->jumlah_peserta > 0
            ? $existingRegistration->jumlah_peserta
            : ($existingRegistration->jumlah_kepala_sekolah + $existingRegistration->jumlah_guru);

        $statusColors = [
            'pending' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-200', 'text' => 'text-orange-800', 'badge' => 'bg-orange-500'],
            'payment_pending' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-200', 'text' => 'text-orange-800', 'badge' => 'bg-orange-500'],
            'payment_uploaded' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-200', 'text' => 'text-orange-800', 'badge' => 'bg-orange-500'],
            'validated' => ['bg' => 'bg-[#0284c7]/10', 'border' => 'border-[#0284c7]/20', 'text' => 'text-[#0284c7]', 'badge' => 'bg-[#0284c7]'],
            'rejected' => ['bg' => 'bg-rose-50', 'border' => 'border-rose-200', 'text' => 'text-rose-800', 'badge' => 'bg-rose-100'],
        ];

        $statusLabels = [
            'pending' => 'Pending',
            'payment_pending' => 'Menunggu Pembayaran',
            'payment_uploaded' => 'Menunggu Validasi',
            'validated' => 'Tervalidasi',
            'rejected' => 'Ditolak',
        ];

        $currentStatus = $existingRegistration->status ?? 'pending';
        $colors = $statusColors[$currentStatus] ?? $statusColors['pending'];
        $statusLabel = $statusLabels[$currentStatus] ?? ucfirst($currentStatus);
    @endphp

    <div class="space-y-2">
        <a href="{{ route('sekolah.activities.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Detail Pendaftaran</h1>
                <p class="mt-1 text-sm text-slate-500">Terdaftar pada {{ $existingRegistration->created_at->format('d M Y H:i') }}</p>
            </div>
            <span class="inline-flex w-fit items-center rounded-full {{ $colors['badge'] }} {{ $colors['text'] }} px-2.5 py-0.5 text-xs font-semibold">
                {{ $statusLabel }}
            </span>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-lg border border-slate-200 bg-white p-3">
            <p class="text-xs font-medium text-slate-500">Total Peserta</p>
            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $totalPeserta }} orang</p>
            <p class="mt-1 text-xs text-slate-500">KS: {{ $existingRegistration->jumlah_kepala_sekolah }} • Guru: {{ $existingRegistration->jumlah_guru }}</p>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-3">
            <p class="text-xs font-medium text-slate-500">Biaya</p>
            @if($activity->registration_fee > 0)
                <p class="mt-1 text-sm font-semibold text-slate-900">Rp {{ number_format($activity->registration_fee * $totalPeserta, 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-slate-500">Rp {{ number_format($activity->registration_fee, 0, ',', '.') }} / peserta</p>
            @else
                <p class="mt-1 text-sm font-semibold text-slate-900">Gratis</p>
                <p class="mt-1 text-xs text-slate-500">Tidak ada biaya pendaftaran</p>
            @endif
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-3">
            <p class="text-xs font-medium text-slate-500">Pembayaran</p>
            @if($existingRegistration->payment)
                <p class="mt-1 text-sm font-semibold text-slate-900">Rp {{ number_format($existingRegistration->payment->amount, 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ \Carbon\Carbon::parse($existingRegistration->payment->payment_date)->format('d M Y') }}</p>
            @else
                <p class="mt-1 text-sm font-semibold text-slate-900">Belum ada</p>
                <p class="mt-1 text-xs text-slate-500">Silakan upload bukti jika berbayar</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-5">
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                <div class="rounded-lg border border-slate-200 bg-white p-4">
                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Sekolah</h6>
                    <div class="space-y-1.5 text-sm">
                        <p class="font-semibold text-slate-900">{{ $existingRegistration->nama_sekolah }}</p>
                        <p class="text-xs text-slate-600">
                            {{ $existingRegistration->kecamatan ? $existingRegistration->kecamatan . ', ' : '' }}{{ $existingRegistration->kab_kota }}{{ $existingRegistration->provinsi ? ', ' . $existingRegistration->provinsi : '' }}
                        </p>
                        <p class="text-xs text-slate-600">KS: {{ $existingRegistration->nama_kepala_sekolah ?? '-' }}</p>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-4">
                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Kegiatan</h6>
                    <div class="space-y-1.5 text-sm">
                        <p class="font-semibold text-slate-900">{{ $activity->name }}</p>
                        <p class="text-xs text-slate-600">Program: {{ $activity->program->name ?? '-' }}</p>
                        <p class="text-xs text-slate-600">Tanggal: {{ $activity->start_date->format('d M Y') }} - {{ $activity->end_date->format('d M Y') }}</p>
                        @if($activity->registration_fee > 0)
                            <p class="text-xs font-semibold text-emerald-700">Rp {{ number_format($activity->registration_fee, 0, ',', '.') }}/peserta</p>
                        @else
                            <p class="text-xs font-semibold text-slate-700">Gratis</p>
                        @endif
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-4 md:col-span-2">
                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Peserta</h6>
                    <div class="space-y-1 text-xs">
                        @if($existingRegistration->jumlah_kepala_sekolah > 0)
                            <p class="text-slate-700"><span class="font-semibold">KS:</span> {{ $existingRegistration->jumlah_kepala_sekolah }} orang</p>
                        @endif
                        <p class="text-slate-700"><span class="font-semibold">Guru:</span> {{ $existingRegistration->jumlah_guru }} orang</p>
                        @if($existingRegistration->teacherParticipants->count() > 0)
                            <div class="mt-2 max-h-40 overflow-y-auto rounded bg-slate-50 p-2 text-xs text-slate-600">
                                @foreach($existingRegistration->teacherParticipants as $teacher)
                                <div class="flex items-center justify-between gap-2">
                                    <p class="truncate">• {{ $teacher->nama_lengkap }}</p>
                                    @if(!empty($teacher->surat_tugas))
                                    <a href="{{ Storage::url($teacher->surat_tugas) }}" target="_blank" rel="noopener"
                                       class="shrink-0 inline-flex items-center text-slate-500 hover:text-slate-800"
                                       title="Lihat Surat Tugas" aria-label="Lihat Surat Tugas">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                @if($activity->description)
                <div class="rounded-lg border border-slate-200 bg-white p-4 md:col-span-2">
                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Deskripsi</h6>
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $activity->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <!-- Payment Info -->
            @if($existingRegistration->payment)
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-3">Informasi Pembayaran</h6>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-xs text-slate-600">Jumlah Transfer</span>
                        <span class="font-semibold text-slate-900">Rp {{ number_format($existingRegistration->payment->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-xs text-slate-600">Tanggal Transfer</span>
                        <span class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($existingRegistration->payment->payment_date)->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-xs text-slate-600">Status</span>
                        @if($existingRegistration->payment->status == 'pending')
                            <span class="inline-flex rounded-full bg-orange-500 px-2.5 py-0.5 text-xs font-semibold text-white">Menunggu Validasi</span>
                        @elseif($existingRegistration->payment->status == 'validated')
                            <span class="inline-flex rounded-full bg-[#0284c7] px-2.5 py-0.5 text-xs font-semibold text-white">Tervalidasi</span>
                        @elseif($existingRegistration->payment->status == 'rejected')
                            <span class="inline-flex rounded-full bg-red-500 px-2.5 py-0.5 text-xs font-semibold text-white">Ditolak</span>
                        @endif
                    </div>

                    @if($existingRegistration->payment->validated_at)
                    <div class="pt-2 text-xs text-slate-600">
                        <p>Divalidasi pada {{ $existingRegistration->payment->validated_at->format('d M Y H:i') }}</p>
                    </div>
                    @endif

                    @if($existingRegistration->payment->proof_file)
                    <div class="pt-2">
                        <p class="text-xs font-medium text-slate-500 mb-2">Bukti Transfer</p>
                        <a href="{{ Storage::url($existingRegistration->payment->proof_file) }}" target="_blank" rel="noopener" class="block">
                            <img src="{{ Storage::url($existingRegistration->payment->proof_file) }}"
                                 alt="Bukti Transfer"
                                 class="w-full max-h-64 object-contain rounded-lg border border-slate-200 bg-slate-50 hover:border-sky-300 transition">
                        </a>
                        <p class="mt-2 text-xs text-slate-500">Klik untuk memperbesar</p>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-5">
                <div class="flex items-start gap-3">
                    <svg class="h-5 w-5 text-amber-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-orange-800 mb-1">Pembayaran Belum Dilakukan</p>
                        <p class="text-xs text-orange-700 mb-3">Silakan upload bukti pembayaran untuk melanjutkan proses validasi.</p>
                        <a href="{{ route('payment.create', $existingRegistration) }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700 transition">
                            Upload Pembayaran
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
