@extends('layouts.dashboard')

@section('title', 'Super Admin Dashboard')

@section('sidebar')
<li>
    <a href="{{ route('super-admin.dashboard') }}" class="active bg-white/20 hover:bg-white/30 rounded-lg text-white font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
        </svg>
        Dashboard
    </a>
</li>
<li>
    <a href="{{ route('super-admin.users') }}" class="hover:bg-white/10 rounded-lg text-blue-100 hover:text-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
        </svg>
        Manajemen Pengguna
    </a>
</li>
<li>
    <a href="{{ route('super-admin.programs') }}" class="hover:bg-white/10 rounded-lg text-blue-100 hover:text-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
        </svg>
        Program
    </a>
</li>
<li>
    <a href="{{ route('super-admin.activities') }}" class="hover:bg-white/10 rounded-lg text-blue-100 hover:text-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
        </svg>
        Kegiatan
    </a>
</li>
<li>
    <a href="{{ route('super-admin.classes.index') }}" class="hover:bg-white/10 rounded-lg text-blue-100 hover:text-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
        </svg>
        Kelas
    </a>
</li>
<li>
    <a href="{{ route('super-admin.payments.index') }}" class="hover:bg-white/10 rounded-lg text-blue-100 hover:text-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
        </svg>
        Validasi Pembayaran
    </a>
</li>
<li>
    <a href="{{ route('super-admin.registrations.index') }}" class="hover:bg-white/10 rounded-lg text-blue-100 hover:text-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
        </svg>
        Kelola Pendaftaran
    </a>
</li>
<li>
    <a href="{{ route('super-admin.admin-mappings') }}" class="hover:bg-white/10 rounded-lg text-blue-100 hover:text-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
        </svg>
        Pemetaan Admin
    </a>
</li>
@endsection

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Dashboard Super Admin</h1>
    <p class="text-base-content/70 mt-2">Selamat datang di panel administrasi sistem</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat bg-base-100 shadow rounded-box">
        <div class="stat-title">Total Admin</div>
        <div class="stat-value text-primary">{{ $stats['total_admins'] }}</div>
        <div class="stat-desc">Administrator sistem</div>
    </div>

    <div class="stat bg-base-100 shadow rounded-box">
        <div class="stat-title">Total Fasilitator</div>
        <div class="stat-value text-success">{{ $stats['total_fasilitators'] }}</div>
        <div class="stat-desc">Pengajar & pembimbing</div>
    </div>

    <div class="stat bg-base-100 shadow rounded-box">
        <div class="stat-title">Total Peserta</div>
        <div class="stat-value text-info">{{ $stats['total_participants'] }}</div>
        <div class="stat-desc">Peserta aktif</div>
    </div>

    <div class="stat bg-base-100 shadow rounded-box">
        <div class="stat-title">Total Program</div>
        <div class="stat-value text-warning">{{ $stats['total_programs'] }}</div>
        <div class="stat-desc">Program tersedia</div>
    </div>
</div>

<!-- Cards Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Kegiatan</h2>
            <div class="stat bg-base-200 rounded-box">
                <div class="stat-title">Total Kegiatan</div>
                <div class="stat-value text-primary">{{ $stats['total_activities'] }}</div>
                <div class="stat-desc">Semua kegiatan dalam sistem</div>
            </div>
            <div class="card-actions justify-end mt-4">
                <a href="{{ route('super-admin.activities') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
            </div>
        </div>
    </div>

    <div class="card bg-primary text-primary-content shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Aksi Cepat</h2>
            <p class="opacity-90">Kelola sistem dengan mudah</p>
            <div class="card-actions justify-start flex-wrap gap-2 mt-4">
                <a href="{{ route('super-admin.users') }}" class="btn btn-sm btn-accent">Tambah Pengguna</a>
                <a href="{{ route('super-admin.programs') }}" class="btn btn-sm btn-accent">Buat Program</a>
                <a href="{{ route('super-admin.activities') }}" class="btn btn-sm btn-accent">Tambah Kegiatan</a>
                <a href="{{ route('super-admin.payments.index') }}" class="btn btn-sm btn-accent">Validasi Pembayaran</a>
            </div>
        </div>
    </div>
</div>
@endsection
