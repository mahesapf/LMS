@extends('layouts.peserta')

@section('title', 'Peserta Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header Dashboard -->
    <div class="rounded-2xl bg-gradient-to-br from-sky-600 to-blue-700 px-6 py-8 text-white shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.12em] text-white/80">Peserta</p>
                <h1 class="mt-2 text-3xl font-semibold">Dashboard Saya</h1>
                <p class="mt-2 text-white/80">Pantau kegiatan, kelas, dan progres pembelajaran Anda.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('peserta.classes') }}" class="inline-flex items-center gap-2 rounded-lg bg-white text-sky-700 px-4 py-2 text-sm font-semibold shadow-sm transition hover:shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Lihat Kelas
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#0284c7]/10 text-[#0284c7]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Kelas yang Diikuti</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_classes'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Total kelas aktif saat ini</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#0284c7]/10 text-[#0284c7]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Total Nilai</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_grades'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Nilai yang telah diterima</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 text-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Dokumen</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_documents'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Dokumen yang telah diupload</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid gap-4 lg:grid-cols-3">
        <!-- Kelas & Pembelajaran -->
        <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Aktivitas Pembelajaran</p>
                    <h2 class="mt-1 text-2xl font-semibold text-slate-900">{{ $stats['total_classes'] }} Kelas Aktif</h2>
                    <p class="mt-2 text-sm text-slate-500">Ikuti kelas dan pantau perkembangan pembelajaran Anda</p>
                </div>
                <a href="{{ route('peserta.classes') }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Kelas & Materi</p>
                    <div class="mt-2 flex items-center gap-2 text-slate-900">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                            </svg>
                        </span>
                        <span class="text-lg font-semibold">Pembelajaran</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500">Akses materi dan jadwal kelas Anda</p>
                    <div class="mt-3">
                        <a href="{{ route('peserta.classes') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Buka kelas →</a>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Nilai & Penilaian</p>
                    <div class="mt-2 flex items-center gap-2 text-slate-900">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-lg font-semibold">Hasil Belajar</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500">Lihat nilai dan feedback dari fasilitator</p>
                    <div class="mt-3">
                        <a href="{{ route('peserta.classes') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Lihat nilai →</a>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Dokumen & Tugas</p>
                    <div class="mt-2 flex items-center gap-2 text-slate-900">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-lg font-semibold">Upload</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500">Kelola dokumen dan kirim tugas</p>
                    <div class="mt-3">
                        <a href="{{ route('peserta.documents') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Kelola dokumen →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Akses Cepat</p>
                    <h3 class="mt-1 text-xl font-semibold text-slate-900">Menu Utama</h3>
                </div>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">Aktif</span>
            </div>
            <div class="mt-5 space-y-2.5">
                <a href="{{ route('peserta.profile') }}" class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 transition hover:bg-slate-100">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Profil Saya</p>
                            <p class="text-xs text-slate-500">Lihat & edit profil</p>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="{{ route('peserta.classes') }}" class="flex items-center justify-between rounded-lg border border-sky-200 bg-sky-50 px-4 py-3 transition hover:bg-sky-100">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-sky-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-sky-900">Kelas & Nilai</p>
                            <p class="text-xs text-sky-600">{{ $stats['total_classes'] }} kelas aktif</p>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="{{ route('peserta.documents') }}" class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 transition hover:bg-slate-100">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Dokumen</p>
                            <p class="text-xs text-slate-500">{{ $stats['total_documents'] }} dokumen</p>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
