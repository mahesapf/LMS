@extends('layouts.sekolah')

@section('title', 'Daftar Kegiatan')

@section('content')
<div class="space-y-6">

    @if($myRegistrations->count() > 0)
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-4 py-3">
            <h2 class="text-sm font-semibold text-slate-800">Kegiatan Saya</h2>
            <a href="{{ route('sekolah.registrations') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-700">Lihat semua</a>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200" x-data="{ openRegistrationId: {{ session('open_registration_id') ? (int) session('open_registration_id') : 'null' }} }">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Program</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Peserta</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($myRegistrations as $registration)
                        @php
                            $totalPeserta = $registration->jumlah_peserta > 0
                                ? $registration->jumlah_peserta
                                : ($registration->jumlah_kepala_sekolah + $registration->jumlah_guru);
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2 text-sm text-slate-900">{{ $registration->activity ? Str::title($registration->activity->name) : '-' }}</td>
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->activity->program->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-slate-700">
                                {{ $registration->jumlah_peserta > 0 ? $registration->jumlah_peserta : ($registration->jumlah_kepala_sekolah + $registration->jumlah_guru) }} orang
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->activity->start_date->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($registration->status == 'pending')
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-amber-700">Pending</span>
                                            <span class="text-[10px] text-amber-600">Menunggu</span>
                                        </div>
                                    </div>
                                @elseif($registration->status == 'payment_pending')
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-amber-700">Menunggu Pembayaran</span>
                                            <span class="text-[10px] text-amber-600">Belum Bayar</span>
                                        </div>
                                    </div>
                                @elseif($registration->status == 'payment_uploaded')
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-blue-700">Menunggu Validasi</span>
                                            <span class="text-[10px] text-blue-600">Sedang Diproses</span>
                                        </div>
                                    </div>
                                @elseif($registration->status == 'validated')
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-emerald-700">Tervalidasi</span>
                                            <span class="text-[10px] text-emerald-600">Disetujui</span>
                                        </div>
                                    </div>
                                @elseif($registration->status == 'rejected')
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.293 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-rose-700">Ditolak</span>
                                            <span class="text-[10px] text-rose-600">Tidak Disetujui</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-slate-700">{{ ucfirst($registration->status) }}</span>
                                            <span class="text-[10px] text-slate-600">Status</span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right text-sm">
                                @if($registration->status == 'payment_pending' && !$registration->payment)
                                    <a href="{{ route('payment.create', $registration) }}" class="inline-flex items-center rounded-lg bg-[#0284c7] px-3 py-2 text-xs font-semibold text-white hover:bg-[#0369a1]">
                                        Upload Pembayaran
                                    </a>
                                @else
                                    <button @click="openRegistrationId = openRegistrationId === {{ $registration->id }} ? null : {{ $registration->id }}"
                                            class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                        Detail
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <tr x-show="openRegistrationId === {{ $registration->id }}" x-transition class="bg-white">
                            <td colspan="6" class="px-4 py-4">
                                <div class="space-y-4">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Detail Pendaftaran</p>
                                            <p class="text-xs text-slate-500">Terdaftar {{ $registration->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <span class="inline-flex w-fit items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700">{{ $registration->status }}</span>
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Total Peserta</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $totalPeserta }} orang</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Biaya</p>
                                            @if($registration->activity && $registration->activity->registration_fee > 0)
                                                <p class="mt-1 text-sm font-semibold text-slate-900">Rp {{ number_format($registration->activity->registration_fee * $totalPeserta, 0, ',', '.') }}</p>
                                                <p class="mt-1 text-xs text-slate-500">Rp {{ number_format($registration->activity->registration_fee, 0, ',', '.') }} / peserta</p>
                                            @else
                                                <p class="mt-1 text-sm font-semibold text-slate-900">Gratis</p>
                                            @endif
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Pembayaran</p>
                                            @if($registration->payment)
                                                <p class="mt-1 text-sm font-semibold text-slate-900">Rp {{ number_format($registration->payment->amount, 0, ',', '.') }}</p>
                                                <p class="mt-1 text-xs text-slate-500">{{ \Carbon\Carbon::parse($registration->payment->payment_date)->format('d M Y') }}</p>
                                            @else
                                                <p class="mt-1 text-sm font-semibold text-slate-900">Belum ada</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-5">
                                        <div class="lg:col-span-3">
                                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                                <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Sekolah</h6>
                                                    <div class="space-y-1.5 text-sm">
                                                        <p class="font-semibold text-slate-900">{{ $registration->nama_sekolah }}</p>
                                                        <p class="text-xs text-slate-600">{{ $registration->kecamatan ? $registration->kecamatan . ', ' : '' }}{{ $registration->kab_kota }}{{ $registration->provinsi ? ', ' . $registration->provinsi : '' }}</p>
                                                        <p class="text-xs text-slate-600">KS: {{ $registration->nama_kepala_sekolah ?? '-' }}</p>
                                                    </div>
                                                </div>

                                                <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Kegiatan</h6>
                                                    <div class="space-y-1.5 text-sm">
                                                        <p class="font-semibold text-slate-900">{{ $registration->activity ? Str::title($registration->activity->name) : '-' }}</p>
                                                        <p class="text-xs text-slate-600">Program: {{ $registration->activity && $registration->activity->program ? $registration->activity->program->name : '-' }}</p>
                                                        @if($registration->activity)
                                                            <p class="text-xs text-slate-600">Tanggal: {{ $registration->activity->start_date->format('d M Y') }} - {{ $registration->activity->end_date->format('d M Y') }}</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="rounded-lg border border-slate-200 bg-white p-3 md:col-span-2">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Peserta</h6>
                                                    <div class="space-y-1 text-xs">
                                                        @if($registration->jumlah_kepala_sekolah > 0)
                                                        <p class="text-slate-700"><span class="font-semibold">KS:</span> {{ $registration->jumlah_kepala_sekolah }} orang</p>
                                                        @endif
                                                        <p class="text-slate-700"><span class="font-semibold">Guru:</span> {{ $registration->jumlah_guru }} orang</p>
                                                        @if($registration->teacherParticipants->count() > 0)
                                                        <div class="mt-2 max-h-24 overflow-y-auto rounded bg-slate-50 p-2 text-xs text-slate-600">
                                                            @foreach($registration->teacherParticipants as $teacher)
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
                                            </div>
                                        </div>

                                        <div class="lg:col-span-2">
                                            @if($registration->payment && $registration->payment->proof_file)
                                            <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Bukti Pembayaran</h6>
                                                <a href="{{ Storage::url($registration->payment->proof_file) }}" target="_blank" rel="noopener" class="block">
                                                    <img src="{{ Storage::url($registration->payment->proof_file) }}" alt="Bukti Transfer" class="w-full max-h-72 object-contain rounded border border-slate-200 bg-slate-50">
                                                </a>
                                                <p class="mt-2 text-xs text-slate-500">Klik untuk memperbesar</p>
                                            </div>
                                            @elseif($registration->status == 'payment_pending' && !$registration->payment)
                                            <div class="rounded-lg border border-amber-200 bg-amber-50 p-3">
                                                <p class="text-sm font-semibold text-amber-800 mb-1">Pembayaran belum diupload</p>
                                                <p class="text-xs text-amber-700 mb-3">Silakan upload bukti pembayaran untuk melanjutkan proses.</p>
                                                <a href="{{ route('payment.create', $registration) }}" class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700">
                                                    Upload Pembayaran
                                                </a>
                                            </div>
                                            @else
                                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-3 text-sm text-slate-600">
                                                Tidak ada bukti pembayaran.
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div>
        <h2 class="text-lg font-semibold text-slate-800">Kegiatan Tersedia untuk Pendaftaran</h2>
        <p class="mt-1 text-sm text-slate-500">Pilih kegiatan yang masih terbuka untuk pendaftaran.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($activities as $activity)
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm h-full flex flex-col">
                <div class="flex items-center gap-2 mb-2 flex-wrap">
                    <div class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                        </svg>
                        <span class="text-xs font-semibold text-sky-700">{{ Str::limit($activity->program->name ?? '-', 20) }}</span>
                    </div>
                    @if($activity->registration_fee > 0)
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-semibold text-amber-700">Berbayar</span>
                        </div>
                    @else
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-semibold text-emerald-700">Gratis</span>
                        </div>
                    @endif
                </div>

                <h3 class="text-base font-semibold text-slate-900 mb-2">{{ Str::limit(Str::title($activity->name), 60) }}</h3>

                @if($activity->description)
                    <p class="text-xs text-slate-700 mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $activity->description }}</p>
                @endif

                <div class="grid grid-cols-2 gap-2 text-xs text-slate-600 mb-3">
                    <div class="rounded-lg bg-slate-50 p-2">
                        <p class="font-semibold text-slate-800">Mulai</p>
                        <p class="text-slate-600">{{ $activity->start_date->format('d M Y') }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-2">
                        <p class="font-semibold text-slate-800">Selesai</p>
                        <p class="text-slate-600">{{ $activity->end_date->format('d M Y') }}</p>
                    </div>
                </div>

                @if($activity->batch)
                    <p class="text-xs text-slate-500 mb-2">Batch: {{ $activity->batch }}</p>
                @endif

                <div class="mt-auto">
                    <a href="{{ route('activities.register.form', $activity) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-sky-700">
                        Lihat Detail & Daftar
                    </a>
                </div>
        </div>
        @empty
        <div class="sm:col-span-2 lg:col-span-3">
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-6 text-center">
                <p class="text-sm text-slate-600">Saat ini belum ada kegiatan yang tersedia untuk pendaftaran.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
