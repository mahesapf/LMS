@extends('layouts.peserta')

@section('title', 'Detail Kelas - ' . $class->name)

@section('sidebar')
@php
    $linkBase = 'group flex items-center gap-3 rounded-xl px-3 py-2 text-[15px] font-semibold text-slate-800 hover:bg-sky-100 hover:text-sky-900 transition';
    $iconBase = 'h-5 w-5 text-slate-500 group-hover:text-sky-800';
    $activeBase = $linkBase . ' bg-sky-100 text-sky-900 shadow-sm';

    $currentRoute = Route::currentRouteName();
@endphp

<div class="space-y-3">
    <p class="px-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Menu Utama</p>
    <li>
        <a href="{{ route('peserta.dashboard') }}" class="{{ $currentRoute === 'peserta.dashboard' ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('peserta.classes') }}" class="{{ Str::startsWith($currentRoute, 'peserta.classes') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z" />
            </svg>
            Kelas & Nilai
        </a>
    </li>
    <li>
        <a href="{{ route('peserta.documents') }}" class="{{ Str::startsWith($currentRoute, 'peserta.documents') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
            </svg>
            Dokumen
        </a>
    </li>
</div>

<div class="mt-4 space-y-3">
    <p class="px-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Akun</p>
    <li>
        <a href="{{ route('peserta.profile') }}" class="{{ Str::startsWith($currentRoute, 'peserta.profile') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            Profil & Biodata
        </a>
    </li>
</div>

<!-- Kontak Person -->
<div class="mt-6 rounded-xl border border-slate-200 bg-gradient-to-br from-sky-50 to-blue-50 p-4">
    <div class="mb-3 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
        </svg>
        <h4 class="text-sm font-semibold text-slate-900">Butuh Bantuan?</h4>
    </div>
    <p class="text-xs text-slate-600 mb-3">Hubungi kami untuk pertanyaan atau dukungan teknis</p>
    <div class="space-y-2">
        <a href="mailto:support@sipm.id" class="flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-sky-100 hover:text-sky-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
            support@sipm.id
        </a>
        <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-emerald-100 hover:text-emerald-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
            WhatsApp Support
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'nilai' }" x-cloak style="[x-cloak] { display: none !important; }">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('peserta.classes') }}" class="text-sky-600 hover:text-sky-700">Kelas Saya</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        <span class="text-slate-600">{{ $class->name }}</span>
    </div>

    <!-- Header -->
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-semibold text-slate-900">{{ $class->name }}</h1>
            <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">{{ $class->identifier ?? 'ID' }}</span>
        </div>
        <p class="mt-1 text-sm text-slate-500">Kelola peserta, tugas, dan dokumen kelas.</p>
    </div>

    <!-- Summary Grid -->
    <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="grid divide-x divide-slate-200 md:grid-cols-2 lg:grid-cols-4">
            <div class="p-4">
                <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Nilai Rata-rata
                </div>
                <p class="mt-1.5 text-2xl font-bold text-slate-900">
                    @if($myGrades->count() > 0)
                        {{ number_format($myGrades->avg('final_score'), 1) }}
                    @else
                        -
                    @endif
                </p>
                @if($myGrades->count() > 0)
                <p class="mt-0.5 text-xs text-slate-500">Dari {{ $myGrades->count() }} penilaian</p>
                @else
                <p class="mt-0.5 text-xs text-slate-500">Belum ada penilaian</p>
                @endif
            </div>
            <div class="p-4">
                <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    Periode Kelas
                </div>
                <p class="mt-1.5 text-sm font-semibold text-slate-900">
                    @if($class->start_date && $class->end_date)
                        {{ $class->start_date->format('d M') }} - {{ $class->end_date->format('d M Y') }}
                    @else
                        -
                    @endif
                </p>
            </div>
            <div class="p-4">
                <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                    </svg>
                    Program
                </div>
                <p class="mt-1.5 text-sm font-semibold text-slate-900">{{ Str::limit($class->activity->program->name ?? '-', 20) }}</p>
            </div>
            <div class="p-4">
                <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    Status Kelas
                </div>
                <p class="mt-1.5">
                    @if($class->status == 'open')
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-emerald-700">Buka</span>
                                <span class="text-[10px] text-emerald-600">Aktif</span>
                            </div>
                        </div>
                    @elseif($class->status == 'closed')
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-amber-700">Tutup</span>
                                <span class="text-[10px] text-amber-600">Tidak Aktif</span>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-700">Selesai</span>
                                <span class="text-[10px] text-slate-600">Berakhir</span>
                            </div>
                        </div>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Informasi Kelas -->
    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="text-base font-semibold text-slate-900">Informasi Kelas</h2>
        <div class="mt-3 grid gap-4 md:grid-cols-2">
            <div>
                <p class="text-xs font-medium text-slate-500">Deskripsi Kelas</p>
                <p class="mt-1 text-xs text-slate-700">{{ $class->description ?: 'Tidak ada deskripsi' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Status Pendaftaran</p>
                <div class="mt-1">
                    @if($mapping->status == 'in')
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-emerald-700">Terdaftar</span>
                                <span class="text-[10px] text-emerald-600">Aktif</span>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-amber-700">Keluar</span>
                                <span class="text-[10px] text-amber-600">Tidak Aktif</span>
                            </div>
                        </div>
                    @endif
                    @if($mapping->enrolled_date)
                    <span class="ml-2 text-xs text-slate-500">sejak {{ $mapping->enrolled_date->format('d M Y') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="border-b border-slate-200">
        <nav class="-mb-px flex gap-4">
            <button @click="activeTab = 'nilai'" :class="activeTab === 'nilai' ? 'border-sky-600 text-sky-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'" class="border-b-2 px-1 py-2 text-xs font-semibold transition">
                Riwayat Penilaian
            </button>
            <button @click="activeTab = 'fasilitator'" :class="activeTab === 'fasilitator' ? 'border-sky-600 text-sky-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'" class="border-b-2 px-1 py-2 text-xs font-semibold transition">
                Fasilitator & Admin
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="grid gap-6 lg:grid-cols-5">
        <!-- Nilai Tab -->
        <div x-show="activeTab === 'nilai'" class="lg:col-span-5">
            <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                    <h2 class="text-base font-semibold text-slate-900">Riwayat Penilaian</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Detail nilai dan grade yang sudah diterima</p>
                </div>
                <div class="p-4">
                    @if($myGrades->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-200 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-600">
                                    <th class="pb-2">Nilai</th>
                                    <th class="pb-2">Grade</th>
                                    <th class="pb-2">Status</th>
                                    <th class="pb-2">Tugas</th>
                                    <th class="pb-2">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($myGrades as $grade)
                                <tr>
                                    <td class="py-3">
                                        <span class="inline-flex items-center justify-center rounded-lg bg-slate-100 px-2.5 py-1 text-base font-bold text-slate-900">
                                            {{ number_format($grade->final_score, 0) }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-sm font-semibold text-slate-700">{{ $grade->grade_letter }}</span>
                                    </td>
                                    <td class="py-3">
                                        @if($grade->status == 'lulus')
                                            <div class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-emerald-700">Lulus</span>
                                                    <span class="text-[10px] text-emerald-600">Tuntas</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-amber-700">Tidak Lulus</span>
                                                    <span class="text-[10px] text-amber-600">Belum Tuntas</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 text-xs text-slate-600">
                                        @if(!empty($grade->notes))
                                            {{ $grade->notes }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-3 text-xs text-slate-600">{{ $grade->graded_date ? $grade->graded_date->format('d M Y') : '-' }}</td>
                                </tr>
                                @if($grade->notes)
                                <tr class="bg-slate-50">
                                    <td colspan="4" class="px-3 py-2">
                                        <div class="flex gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 flex-shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-xs text-slate-600">{{ $grade->notes }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="rounded-lg border-2 border-dashed border-sky-200 bg-sky-50 p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-sky-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-sm font-medium text-sky-900">Belum ada penilaian</p>
                        <p class="mt-1 text-xs text-sky-700">Nilai akan muncul setelah fasilitator memberikan penilaian</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Fasilitator & Admin Tab -->
        <div x-show="activeTab === 'fasilitator'" class="lg:col-span-5">
            <div class="grid gap-4 md:grid-cols-2">
                <!-- Fasilitator -->
                @if($fasilitators && $fasilitators->count() > 0)
                <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                        <h2 class="text-base font-semibold text-slate-900">Fasilitator</h2>
                        <p class="mt-0.5 text-xs text-slate-500">Pengajar kelas ini</p>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-3">
                            @foreach($fasilitators as $fasilitator)
                            <li class="flex items-start gap-2.5">
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-sky-600 text-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1 pt-0.5">
                                    <p class="text-sm font-semibold text-slate-900">{{ $fasilitator->name }}</p>
                                    @if($fasilitator->institution)
                                    <p class="mt-0.5 text-xs text-slate-500">{{ $fasilitator->institution }}</p>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Admin -->
                @if($admins && $admins->count() > 0)
                <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                        <h2 class="text-base font-semibold text-slate-900">Admin</h2>
                        <p class="mt-0.5 text-xs text-slate-500">Pengelola kegiatan</p>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-3">
                            @foreach($admins as $admin)
                            <li class="flex items-start gap-2.5">
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-purple-600 text-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1 pt-0.5">
                                    <p class="text-sm font-semibold text-slate-900">{{ $admin->name }}</p>
                                    @if($admin->institution)
                                    <p class="mt-0.5 text-xs text-slate-500">{{ $admin->institution }}</p>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
