@extends('layouts.dashboard')

@section('title', 'Manajemen Sekolah')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6" x-data="{ openSekolahId: null }">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Manajemen Sekolah</h1>
        <p class="mt-1 text-sm text-slate-500">Kelola akun sekolah dan status pendaftaran.</p>
    </div>
    @if(session('success'))
        <div class="rounded-lg border border-[#0284c7]/20 bg-[#0284c7]/5 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-[#0284c7]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-slate-900">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-900">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-sm font-semibold text-slate-800">
                    @if(request('status') == 'pending')
                        Sekolah Pending ({{ $sekolahs->count() }})
                    @elseif(request('status') == 'approved')
                        Sekolah Disetujui ({{ $sekolahs->count() }})
                    @elseif(request('status') == 'rejected')
                        Sekolah Ditolak ({{ $sekolahs->count() }})
                    @else
                        Semua Sekolah ({{ $sekolahs->count() }})
                    @endif
                </h2>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-2">
                    <form method="GET" action="{{ route('admin.sekolah.index') }}" class="flex flex-1 flex-col gap-2 sm:flex-row sm:items-end sm:gap-2">
                        <div class="flex-1">
                            <label class="mb-1 hidden text-xs font-medium text-slate-600">Filter Status</label>
                            <select name="status" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20" onchange="this.form.submit()">
                                <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        @if(request('status') && request('status') != 'all')
                        <a href="{{ route('admin.sekolah.index') }}"
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
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Nama Sekolah</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">NPSN</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Provinsi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Kabupaten</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sekolahs as $index => $sekolah)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $sekolahs->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $sekolah->name ?? $sekolah->nama_sekolah }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $sekolah->npsn ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $sekolah->province ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $sekolah->city ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $sekolah->email }}</td>
                            <td class="px-6 py-4">
                                @if($sekolah->status == 'inactive')
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-orange-700">Pending</span>
                                            <span class="text-[10px] text-orange-600">Menunggu persetujuan</span>
                                        </div>
                                    </div>
                                @elseif($sekolah->status == 'active')
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0284c7] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-[#0284c7]">Disetujui</span>
                                            <span class="text-[10px] text-[#0284c7]">Akun aktif</span>
                                        </div>
                                    </div>
                                @elseif($sekolah->status == 'suspended')
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-medium text-red-700">Ditolak</span>
                                            <span class="text-[10px] text-red-600">Akun ditolak</span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button type="button"
                                        @click="openSekolahId = openSekolahId === {{ $sekolah->id }} ? null : {{ $sekolah->id }}"
                                        class="inline-flex items-center rounded-md border border-sky-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-sky-700 shadow-sm hover:bg-sky-50"
                                        title="Detail" aria-label="Detail">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <tr x-show="openSekolahId === {{ $sekolah->id }}" x-transition class="bg-white border-b border-slate-200">
                            <td colspan="8" class="px-6 py-4">
                                <div class="max-w-6xl space-y-4">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Detail Sekolah</p>
                                            <p class="text-xs text-slate-500">Daftar {{ $sekolah->created_at ? $sekolah->created_at->format('d M Y H:i') : '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Nama Sekolah</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $sekolah->name }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">NPSN</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $sekolah->npsn ?? '-' }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Provinsi</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $sekolah->province ?? '-' }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Kabupaten/Kota</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $sekolah->city ?? '-' }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Email</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $sekolah->email }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Email Belajar.id</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $sekolah->email_belajar ?? '-' }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">No WhatsApp</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $sekolah->no_hp ?? '-' }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Tanggal Daftar</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $sekolah->created_at ? $sekolah->created_at->format('d M Y H:i') : '-' }}</p>
                                        </div>
                                        @if($sekolah->status == 'active')
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Status Akun</p>
                                            <p class="text-sm font-semibold text-slate-900">Aktif</p>
                                        </div>
                                        @endif
                                    </div>
                                    @if($sekolah->status == 'inactive')
                                    <div class="flex gap-2 mt-4">
                                        <form action="{{ route('admin.sekolah.reject', $sekolah->id) }}" method="POST" onsubmit="return confirm('Yakin tolak pendaftaran sekolah ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-slate-500">Belum ada data sekolah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
