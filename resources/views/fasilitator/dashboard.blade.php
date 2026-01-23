@extends('layouts.dashboard')

@section('title', 'Fasilitator Dashboard')

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="rounded-2xl bg-gradient-to-br from-sky-600 to-blue-700 px-6 py-8 text-white shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.12em] text-white/80">Fasilitator</p>
                <h1 class="mt-2 text-3xl font-semibold">Dashboard</h1>
                <p class="mt-2 text-white/80">Pantau kelas, peserta, dan progres pembelajaran secara ringkas.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('fasilitator.classes') }}" class="inline-flex items-center gap-2 rounded-lg bg-white text-[#0284c7] px-4 py-2 text-sm font-semibold shadow-sm transition hover:shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C6.228 6.228 2 10.228 2 15s4.228 8.772 10 8.772 10-4.228 10-8.772C22 10.228 17.772 6.228 12 6.253z" />
                    </svg>
                    Lihat Kelas
                </a>
                <a href="{{ route('fasilitator.profile') }}" class="inline-flex items-center gap-2 rounded-lg bg-white/20 px-4 py-2 text-sm font-semibold backdrop-blur transition hover:bg-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <!-- Total Classes -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Total Kelas</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_classes'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Kelas yang diampu saat ini</p>
        </div>

        <!-- Total Participants -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-100 text-cyan-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-9-3a1 1 0 112 0v2a1 1 0 11-2 0V7zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Total Peserta</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_participants'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Peserta aktif terdaftar</p>
        </div>

        <!-- Total Grades -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 3.062v6.757a1 1 0 01-.940 1.017 48.614 48.614 0 01-7.5 0 1 1 0 01-.94-1.017v-6.757a3.066 3.066 0 012.812-3.062zM9 12a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Nilai Terinput</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_grades'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Penilaian yang sudah diinput</p>
        </div>

        <!-- Total Documents -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 16.5a1 1 0 01-1-1V4a1 1 0 111 1h4a1 1 0 110-2H7a3 3 0 00-3 3v11.5a3 3 0 003 3h5a3 3 0 003-3v-3a1 1 0 11-2 0v3a1 1 0 01-1 1H8z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Dokumen Tugas</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_documents'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Dokumen yang terkumpul</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Aksi Cepat</h2>
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('fasilitator.classes') }}" class="group rounded-lg border border-slate-200 p-4 transition hover:border-[#0284c7]/30 hover:bg-[#0284c7]/10">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-700 group-hover:bg-sky-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
                        </svg>
                    </span>
                    <div>
                        <p class="font-medium text-slate-900">Kelas Saya</p>
                        <p class="text-xs text-slate-500">Lihat semua kelas</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('fasilitator.profile') }}" class="group rounded-lg border border-slate-200 p-4 transition hover:border-[#0284c7]/30 hover:bg-[#0284c7]/10">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-700 group-hover:bg-sky-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <div>
                        <p class="font-medium text-slate-900">Edit Profil</p>
                        <p class="text-xs text-slate-500">Update biodata</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
