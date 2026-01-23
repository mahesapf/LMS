@extends('layouts.dashboard')

@section('title', 'Kelola Pendaftaran Peserta')

@section('sidebar')
    @if($routePrefix === 'admin')
        @include('admin.partials.sidebar')
    @else
        @include('super-admin.partials.sidebar')
    @endif
@endsection

@section('content')
<div class="space-y-6" x-data="{ openDetailId: null }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Kelola Pendaftaran Sekolah</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $routePrefix === 'super-admin' ? 'Lihat sekolah tervalidasi, detail peserta (guru & kepala sekolah), dan status penempatan ke kelas.' : 'Lihat detail peserta dan status penempatan ke kelas.' }}</p>
        </div>
    </div>

    <div class="rounded-xl border border-sky-200 bg-sky-50 p-4">
        <p class="text-sm text-slate-700">
            Untuk menambahkan peserta ke kelas, buka menu <span class="font-semibold">Kelas</span>, pilih kelas yang diinginkan, lalu klik <span class="font-semibold">Detail</span>.
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-sm font-semibold text-slate-800">
                    @if($status == 'validated')
                        Sekolah Tervalidasi ({{ $registrations->count() }})
                    @elseif($status == 'rejected')
                        Sekolah Ditolak ({{ $registrations->count() }})
                    @else
                        Semua Pendaftaran ({{ $registrations->count() }})
                    @endif
                </h2>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-2">
                    <form method="GET" action="{{ route('admin.registrations.index') }}" class="flex flex-1 flex-col gap-2 sm:flex-row sm:items-end sm:gap-2">
                        <div class="flex-1">
                            <label class="mb-1 hidden text-xs font-medium text-slate-600">Filter Status</label>
                            <select name="status" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20" onchange="this.form.submit()">
                                <option value="validated" {{ $status == 'validated' ? 'selected' : '' }}>Tervalidasi</option>
                                <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                            </select>
                        </div>
                        @if($status != 'validated')
                        <a href="{{ route('admin.registrations.index') }}"
                           class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Daftar</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Sekolah</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kepala Sekolah</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Peserta</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($registrations as $registration)
                        @php
                            $totalPeserta = $registration->jumlah_peserta > 0
                                ? $registration->jumlah_peserta
                                : ($registration->jumlah_kepala_sekolah + $registration->jumlah_guru);
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-sm">
                                <div class="text-slate-900 font-semibold">{{ $registration->nama_sekolah }}</div>
                                <div class="text-xs text-slate-500">{{ $registration->alamat_sekolah }}</div>
                                <div class="text-xs text-slate-500">
                                    {{ $registration->kecamatan ? $registration->kecamatan . ', ' : '' }}{{ $registration->kab_kota }}, {{ $registration->provinsi }}
                                </div>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <div class="text-slate-900 font-semibold">{{ $registration->nama_kepala_sekolah }}</div>
                                <div class="text-xs text-slate-500">{{ $registration->nomor_telp }}</div>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <div class="text-slate-900 font-semibold">{{ $totalPeserta }} orang</div>
                                <div class="text-xs text-slate-500">KS: {{ $registration->jumlah_kepala_sekolah }}, Guru: {{ $registration->jumlah_guru }}</div>
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">
                                {{ $registration->activity->name ?? '-' }}
                                @if($registration->activity && $registration->activity->program)
                                    <div class="text-xs text-slate-500">{{ $registration->activity->program->name }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">
                                @if($registration->class)
                                    <a href="{{ route($routePrefix . '.classes.show', $registration->class) }}" 
                                       class="flex items-center gap-1.5 hover:bg-slate-50 rounded-lg p-1.5 -ml-1.5 transition-colors group max-w-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0284c7] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                            <path d="M3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-[#0284c7] group-hover:text-[#0369a1] truncate max-w-[120px]">{{ $registration->class->name }}</span>
                                            <span class="text-[10px] text-slate-500">Sudah ditempatkan</span>
                                        </div>
                                    </a>
                                @elseif($registration->status == 'rejected')
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-red-700">Ditolak</span>
                                            <span class="text-[10px] text-red-600">Tidak dapat ditempatkan</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-orange-700">Menunggu</span>
                                            <span class="text-[10px] text-orange-600">Belum ditempatkan</span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <button @click="openDetailId = openDetailId === {{ $registration->id }} ? null : {{ $registration->id }}"
                                        class="inline-flex items-center rounded-md border border-sky-300 bg-white px-3 py-1.5 text-xs font-semibold text-sky-700 shadow-sm hover:bg-sky-50">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <!-- Detail Row -->
                        <tr x-show="openDetailId === {{ $registration->id }}"
                            x-transition
                            class="bg-white border-b border-slate-200">
                            <td colspan="7" class="px-4 py-4">
                                <div class="max-w-6xl space-y-4">
                                    @if($registration->status == 'rejected')
                                    <!-- Alasan Penolakan -->
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                        <div class="flex items-start gap-3">
                                            <svg class="h-5 w-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <h4 class="text-sm font-semibold text-red-900 mb-1">Pendaftaran Ditolak</h4>
                                                @if($registration->payment && $registration->payment->rejection_reason)
                                                <p class="text-sm text-red-800">{{ $registration->payment->rejection_reason }}</p>
                                                @else
                                                <p class="text-sm text-red-800">Pembayaran tidak valid atau tidak memenuhi syarat.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Daftar Peserta</p>
                                            <p class="text-xs text-slate-500">{{ $registration->nama_sekolah }}</p>
                                        </div>
                                        @if($registration->status == 'validated')
                                            <span class="inline-flex w-fit items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Tervalidasi</span>
                                        @elseif($registration->status == 'rejected')
                                            <span class="inline-flex w-fit items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">Ditolak</span>
                                        @else
                                            <span class="inline-flex w-fit items-center rounded-full bg-orange-500 px-2.5 py-0.5 text-xs font-semibold text-white">{{ $registration->status }}</span>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-4">
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Total Peserta</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $totalPeserta }} orang</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Kepala Sekolah</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $registration->jumlah_kepala_sekolah }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Guru</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $registration->jumlah_guru }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Kelas</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $registration->class->name ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-5">
                                        <div class="lg:col-span-2">
                                            <div class="space-y-3">
                                                <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Informasi Pendaftaran</h6>
                                                    <div class="space-y-1.5 text-sm">
                                                        <p class="font-semibold text-slate-900">{{ $registration->nama_sekolah }}</p>
                                                        <p class="text-xs text-slate-600">{{ $registration->alamat_sekolah }}</p>
                                                        <p class="text-xs text-slate-600">{{ $registration->kecamatan ? $registration->kecamatan . ', ' : '' }}{{ $registration->kab_kota }}{{ $registration->provinsi ? ', ' . $registration->provinsi : '' }}</p>
                                                    </div>
                                                </div>

                                                <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Kegiatan</h6>
                                                    <div class="space-y-1.5 text-sm">
                                                        <p class="font-semibold text-slate-900">{{ $registration->activity->name ?? '-' }}</p>
                                                        @if($registration->activity && $registration->activity->program)
                                                            <p class="text-xs text-slate-600">{{ $registration->activity->program->name }}</p>
                                                        @endif
                                                        @if($registration->activity)
                                                            <p class="text-xs font-semibold text-emerald-700">Rp {{ number_format($registration->activity->registration_fee, 0, ',', '.') }}/peserta</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Pembayaran</h6>
                                                    <div class="space-y-1.5 text-sm">
                                                        @if($registration->payment)
                                                            <p class="text-xs text-slate-600">Jumlah: <span class="font-semibold text-slate-900">Rp {{ number_format($registration->payment->amount, 0, ',', '.') }}</span></p>
                                                            <p class="text-xs text-slate-600">Tanggal: <span class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($registration->payment->payment_date)->format('d M Y') }}</span></p>
                                                            <p class="text-xs text-slate-600">Status: <span class="font-semibold text-slate-900">{{ $registration->payment->status }}</span></p>
                                                        @else
                                                            <p class="text-sm text-slate-500">Belum ada data pembayaran.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="lg:col-span-3">
                                            <div class="space-y-3">
                                        <!-- Kepala Sekolah -->
                                        @if($registration->jumlah_kepala_sekolah > 0)
                                        <div class="border border-emerald-200 bg-emerald-50 rounded-lg p-3">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <h4 class="text-sm font-semibold text-emerald-900 truncate">{{ $registration->nama_kepala_sekolah }}</h4>
                                                    <p class="text-xs text-emerald-700 font-medium">Kepala Sekolah</p>

                                                    <div class="mt-2 flex flex-col gap-1 text-xs text-emerald-800 sm:flex-row sm:items-center sm:gap-3">
                                                        <p class="truncate"><span class="font-semibold">NIK:</span> {{ $registration->nik_kepala_sekolah ?? '-' }}</p>
                                                        <p class="truncate"><span class="font-semibold">Email:</span> {{ $registration->email ?? '-' }}</p>
                                                        @if($registration->surat_tugas_kepala_sekolah)
                                                        <a href="{{ Storage::url($registration->surat_tugas_kepala_sekolah) }}" target="_blank" rel="noopener"
                                                           class="inline-flex items-center text-emerald-700 hover:text-emerald-900"
                                                           title="Lihat Surat Tugas" aria-label="Lihat Surat Tugas">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Guru-guru -->
                                        @if($registration->teacherParticipants->count() > 0)
                                        @foreach($registration->teacherParticipants as $index => $teacher)
                                        <div class="border border-slate-200 rounded-lg p-3 hover:border-sky-300 transition-colors">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-sky-100 text-sky-700 font-semibold text-sm">
                                                            {{ $index + 1 }}
                                                        </span>
                                                        <div>
                                                            <h4 class="text-sm font-semibold text-slate-900">{{ $teacher->nama_lengkap }}</h4>
                                                            <p class="text-xs text-slate-500">Guru</p>
                                                        </div>
                                                    </div>
                                                    <div class="ml-10 flex flex-col gap-1 text-xs text-slate-600 sm:flex-row sm:items-center sm:gap-3">
                                                        <p class="truncate"><span class="font-semibold">NIK:</span> {{ $teacher->nik ?? '-' }}</p>
                                                        <p class="truncate"><span class="font-semibold">Email:</span> {{ $teacher->email ?? '-' }}</p>
                                                        @if($teacher->surat_tugas)
                                                        <a href="{{ Storage::url($teacher->surat_tugas) }}" target="_blank" rel="noopener"
                                                           class="inline-flex items-center text-slate-500 hover:text-slate-800"
                                                           title="Lihat Surat Tugas" aria-label="Lihat Surat Tugas">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>

                                    @if($registration->jumlah_kepala_sekolah == 0 && $registration->teacherParticipants->count() == 0)
                                    <div class="text-center py-8 text-slate-500">
                                        <svg class="h-12 w-12 mx-auto text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p class="text-sm">Belum ada data peserta yang didaftarkan</p>
                                    </div>
                                    @endif
                                            </div>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada sekolah yang tervalidasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
