@extends('layouts.dashboard')

@section('title', 'Super Admin Dashboard')

@section('sidebar')
    @include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="rounded-2xl bg-gradient-to-br from-sky-600 to-blue-700 px-6 py-8 text-white shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.12em] text-white/80">Super Admin</p>
                <h1 class="mt-2 text-3xl font-semibold">Dashboard utama</h1>
                <p class="mt-2 text-white/80">Pantau peran, program, dan kegiatan secara ringkas.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('super-admin.users') }}" class="inline-flex items-center gap-2 rounded-lg bg-white/20 px-4 py-2 text-sm font-semibold backdrop-blur transition hover:bg-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah pengguna
                </a>
                <a href="{{ route('super-admin.activities') }}" class="inline-flex items-center gap-2 rounded-lg bg-white text-[#0284c7] px-4 py-2 text-sm font-semibold shadow-sm transition hover:shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m-8 4h10a2 2 0 002-2V6a2 2 0 00-2-2H8l-4 4v10a2 2 0 002 2h1" />
                    </svg>
                    Kelola kegiatan
                </a>
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#0284c7]/10 text-[#0284c7]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Admin aktif</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_admins'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Pengelola utama sistem</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Fasilitator</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_fasilitators'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Pengajar & pendamping aktif</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#0284c7]/10 text-[#0284c7]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-9-3a1 1 0 112 0v2a1 1 0 11-2 0V7zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Peserta</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_participants'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Peserta aktif terdaftar</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Program</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_programs'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Program aktif & tersedia</p>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Status kegiatan</p>
                    <h2 class="mt-1 text-2xl font-semibold text-slate-900">{{ $stats['total_activities'] }} kegiatan aktif</h2>
                    <p class="mt-2 text-sm text-slate-500">Ikuti detail jadwal, pendanaan, dan progres kegiatan.</p>
                </div>
                <a href="{{ route('super-admin.activities') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0369a1]">
                    Lihat kegiatan
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Validasi pembayaran</p>
                    <div class="mt-2 flex items-center gap-2 text-slate-900">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v3H2V5zm0 5h16v5a2 2 0 01-2 2H4a2 2 0 01-2-2v-5zm3 2a1 1 0 100 2h1a1 1 0 100-2H5z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-lg font-semibold">Prioritas</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500">Pastikan semua pembayaran telah diverifikasi tepat waktu.</p>
                    <div class="mt-3">
                        <a href="{{ route('super-admin.payments.index') }}" class="text-sm font-semibold text-[#0284c7] hover:text-[#0369a1]">Kelola pembayaran →</a>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Kelola pengguna</p>
                    <div class="mt-2 flex items-center gap-2 text-slate-900">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path fill-rule="evenodd" d="M4 13a4 4 0 014-4h4a4 4 0 014 4v2H4v-2z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-lg font-semibold">Peran & status</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500">Aktifkan/suspend akun dan atur peran pengguna.</p>
                    <div class="mt-3">
                        <a href="{{ route('super-admin.users') }}" class="text-sm font-semibold text-[#0284c7] hover:text-[#0369a1]">Buka manajemen →</a>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Program & kelas</p>
                    <div class="mt-2 flex items-center gap-2 text-slate-900">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z" />
                            </svg>
                        </span>
                        <span class="text-lg font-semibold">Struktur belajar</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500">Sinkronkan program, kegiatan, dan kelas aktif.</p>
                    <div class="mt-3 flex flex-wrap gap-2 text-sm font-semibold">
                        <a href="{{ route('super-admin.programs') }}" class="text-[#0284c7] hover:text-[#0369a1]">Program →</a>
                        <span class="text-slate-300">|</span>
                        <a href="{{ route('super-admin.classes.index') }}" class="text-[#0284c7] hover:text-[#0369a1]">Kelas →</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Snapshot ringkas</p>
                    <h3 class="mt-1 text-xl font-semibold text-slate-900">Data terbaru</h3>
                </div>
                <span class="rounded-full bg-[#0284c7]/10 px-3 py-1 text-xs font-semibold text-[#0284c7]">Live</span>
            </div>
            <div class="mt-5 space-y-2.5">
                <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-50 text-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 4a2 2 0 00-2 2v6h6V4H5zM9 18h4a2 2 0 002-2V6h-2v6H9v6z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm text-slate-500">Kegiatan aktif</p>
                            <p class="font-semibold text-slate-900">{{ $stats['total_activities'] }} total</p>
                        </div>
                    </div>
                    <a href="{{ route('super-admin.activities') }}" class="text-sm font-semibold text-[#0284c7] hover:text-[#0369a1]">→</a>
                </div>
                <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 01.832.445l7 10A1 1 0 0117 14H3a1 1 0 01-.832-1.555l7-10A1 1 0 0110 2zm0 5a1 1 0 00-.832.445l-3 4A1 1 0 007 13h6a1 1 0 00.832-1.555l-3-4A1 1 0 0010 7z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm text-slate-500">Program berjalan</p>
                            <p class="font-semibold text-slate-900">{{ $stats['total_programs'] }} program</p>
                        </div>
                    </div>
                    <a href="{{ route('super-admin.programs') }}" class="text-sm font-semibold text-[#0284c7] hover:text-[#0369a1]">→</a>
                </div>
                <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-slate-700 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 3a2 2 0 00-2 2v9a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5l-2-3H4z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm text-slate-500">Pemetaan admin</p>
                            <p class="font-semibold text-slate-900">Pastikan distribusi merata</p>
                        </div>
                    </div>
                    <a href="{{ route('super-admin.admin-mappings') }}" class="text-sm font-semibold text-[#0284c7] hover:text-[#0369a1]">→</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
