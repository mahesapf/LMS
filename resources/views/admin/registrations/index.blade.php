@extends('layouts.dashboard')

@section('title', 'Kelola Pendaftaran Peserta')

@section('sidebar')
@if(auth()->user()->role === 'super_admin')
    @include('super-admin.partials.sidebar')
@else
    <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
        <a class="nav-link" href="{{ route('admin.classes.index') }}">Kelas</a>
        <a class="nav-link active" href="{{ route('admin.registrations.index') }}">Manajemen Peserta</a>
    </nav>
@endif
@endsection

@section('content')
<div class="space-y-6" x-data="{ openDetailId: null }">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Kelola Pendaftaran Sekolah</h1>
        <p class="mt-1 text-sm text-slate-500">Lihat sekolah tervalidasi, detail peserta (guru & kepala sekolah), dan status penempatan ke kelas.</p>
    </div>

    <div class="rounded-xl border border-sky-200 bg-sky-50 p-4">
        <p class="text-sm text-slate-700">
            Untuk menambahkan peserta ke kelas, buka menu <span class="font-semibold">Kelas</span>, pilih kelas yang diinginkan, lalu klik <span class="font-semibold">Detail</span>.
        </p>
    </div>

    <!-- Filter Status -->
    <form method="GET" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex items-center gap-4">
            <label class="text-sm font-medium text-slate-700">Filter Status:</label>
            <select name="status" class="form-select rounded-lg border-slate-300" onchange="this.form.submit()">
                <option value="validated" {{ $status == 'validated' ? 'selected' : '' }}>Tervalidasi</option>
                <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
            </select>
        </div>
    </form>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3 rounded-t-xl -mx-4 -mt-4 mb-4">
            <h2 class="text-sm font-semibold text-slate-800">
                @if($status == 'validated')
                    Sekolah Tervalidasi ({{ $registrations->count() }})
                @elseif($status == 'rejected')
                    Sekolah Ditolak ({{ $registrations->count() }})
                @else
                    Semua Pendaftaran ({{ $registrations->count() }})
                @endif
            </h2>
        </div>
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
                                    <a href="{{ route($routePrefix . '.classes.show', $registration->class) }}" class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">
                                        {{ $registration->class->name }}
                                    </a>
                                @elseif($registration->status == 'rejected')
                                    <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">Ditolak</span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">Belum Ditentukan</span>
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
                            class="bg-slate-50">
                            <td colspan="7" class="px-4 py-4">
                                <div class="bg-white rounded-lg border border-slate-200 p-4">
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

                                    <h3 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                                        <svg class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Daftar Peserta dari {{ $registration->nama_sekolah }}
                                    </h3>

                                    <div class="space-y-3">
                                        <!-- Kepala Sekolah -->
                                        @if($registration->jumlah_kepala_sekolah > 0)
                                        <div class="border border-emerald-200 bg-emerald-50 rounded-lg p-3">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-600 text-white font-semibold text-sm">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </span>
                                                        <div>
                                                            <h4 class="text-sm font-semibold text-emerald-900">{{ $registration->nama_kepala_sekolah }}</h4>
                                                            <p class="text-xs text-emerald-700 font-medium">Kepala Sekolah</p>
                                                        </div>
                                                    </div>
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 ml-12">
                                                        <div>
                                                            <span class="text-xs font-medium text-emerald-700">NIK:</span>
                                                            <p class="text-sm text-emerald-900">{{ $registration->nik_kepala_sekolah ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="text-xs font-medium text-emerald-700">Email:</span>
                                                            <p class="text-sm text-emerald-900">{{ $registration->email ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="text-xs font-medium text-emerald-700">Surat Tugas:</span>
                                                            @if($registration->surat_tugas_kepala_sekolah)
                                                            <a href="{{ Storage::url($registration->surat_tugas_kepala_sekolah) }}" target="_blank"
                                                               class="inline-flex items-center text-sm text-emerald-700 hover:text-emerald-800 font-medium">
                                                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                Lihat File
                                                            </a>
                                                            @else
                                                            <p class="text-sm text-emerald-600">-</p>
                                                            @endif
                                                        </div>
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
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 ml-10">
                                                        <div>
                                                            <span class="text-xs font-medium text-slate-500">NIK:</span>
                                                            <p class="text-sm text-slate-900">{{ $teacher->nik ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="text-xs font-medium text-slate-500">Email:</span>
                                                            <p class="text-sm text-slate-900">{{ $teacher->email ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="text-xs font-medium text-slate-500">Surat Tugas:</span>
                                                            @if($teacher->surat_tugas)
                                                            <a href="{{ Storage::url($teacher->surat_tugas) }}" target="_blank"
                                                               class="inline-flex items-center text-sm text-sky-600 hover:text-sky-700">
                                                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                Lihat File
                                                            </a>
                                                            @else
                                                            <p class="text-sm text-slate-400">-</p>
                                                            @endif
                                                        </div>
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
@endsection
