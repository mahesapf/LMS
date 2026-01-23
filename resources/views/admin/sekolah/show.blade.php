@extends('layouts.dashboard')

@section('title', 'Detail Sekolah')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Detail Sekolah</h1>
            <p class="mt-1 text-sm text-slate-500">Informasi lengkap akun sekolah.</p>
        </div>
        <a href="{{ route('admin.sekolah.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>
    <!-- Status and Actions -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Status Pendaftaran</h2>
                <div class="mt-2">
                    @if($sekolah->status == 'inactive')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-orange-500 px-3 py-1 text-sm font-semibold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            Pending
                        </span>
                    @elseif($sekolah->status == 'active')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#0284c7] px-3 py-1 text-sm font-semibold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Disetujui
                        </span>
                    @elseif($sekolah->status == 'suspended')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500 px-3 py-1 text-sm font-semibold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            Ditolak
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Sekolah</h2>
        </div>
        <div class="p-6">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Nama Sekolah</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $sekolah->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">NPSN</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $sekolah->npsn ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Provinsi</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $sekolah->province ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Kabupaten/Kota</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $sekolah->city ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Email</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $sekolah->email }}</dd>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Email Belajar.id</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $sekolah->email_belajar ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">No WhatsApp</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $sekolah->no_hp ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Tanggal Daftar</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            {{ $sekolah->created_at ? $sekolah->created_at->format('d M Y H:i') : '-' }}
                        </dd>
                    </div>
                    @if($sekolah->status == 'active')
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Status Akun</dt>
                        <dd class="mt-1 text-sm text-slate-900">Aktif</dd>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
