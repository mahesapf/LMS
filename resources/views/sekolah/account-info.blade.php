@extends('layouts.sekolah')

@section('title', 'Informasi Akun')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Informasi Akun</h1>
        <p class="mt-1 text-sm text-slate-500">Informasi aktivasi akun sekolah dan akun yang memprosesnya.</p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
            <h2 class="text-sm font-semibold text-slate-800">Status akun sekolah</h2>
        </div>
        <div class="p-4">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-lg border border-slate-200 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status</p>
                    <div class="mt-2">
                        @if($user->status === 'active')
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-emerald-700">Status</span>
                                    <span class="text-[10px] text-emerald-600">Aktif</span>
                                </div>
                            </div>
                        @elseif($user->status === 'inactive')
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-amber-700">Status</span>
                                    <span class="text-[10px] text-amber-600">Belum aktif</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-700">Status</span>
                                    <span class="text-[10px] text-slate-600">{{ ucfirst($user->status) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <p class="mt-2 text-sm text-slate-500">Status akun saat ini pada sistem.</p>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Disetujui</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900">
                        {{ $user->approved_at ? $user->approved_at->format('d M Y H:i') : '-' }}
                    </p>
                    <p class="mt-2 text-sm text-slate-500">Waktu persetujuan/aktivasi akun sekolah.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- List of Active Peserta Accounts -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
            <h2 class="text-sm font-semibold text-slate-800">Daftar Akun Peserta yang Sudah Aktif</h2>
            <p class="mt-1 text-xs text-slate-500">Peserta dari sekolah Anda (NPSN: {{ $user->npsn ?? '-' }}) yang sudah diaktifkan dan dapat login ke sistem</p>
        </div>
        <div class="p-4">
            @if($activePesertaAccounts->count() > 0)
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-xs text-emerald-800">
                            <strong>Total: {{ $activePesertaAccounts->count() }} akun peserta aktif</strong> dari {{ $user->nama_sekolah ?? 'sekolah Anda' }}
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600 sm:px-4">No</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600 sm:px-4">Nama & Email</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600 sm:px-4">NIK</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600 sm:px-4">Instansi</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600 sm:px-4">Diaktifkan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($activePesertaAccounts as $index => $peserta)
                            <tr class="hover:bg-slate-50">
                                <td class="whitespace-nowrap px-3 py-3 text-sm text-slate-900 sm:px-4">{{ $index + 1 }}</td>
                                <td class="px-3 py-3 text-sm sm:px-4">
                                    <div class="font-semibold text-slate-900">{{ $peserta->name }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $peserta->email }}</div>
                                    @if($peserta->position || $peserta->position_type)
                                        <div class="mt-1 flex items-center gap-1">
                                            <svg class="h-3 w-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-[10px] font-semibold text-teal-700">{{ $peserta->position ?? $peserta->position_type }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-sm text-slate-600 sm:px-4">
                                    <div>{{ $peserta->nik ?? '-' }}</div>
                                    @if($peserta->no_hp || $peserta->phone)
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $peserta->no_hp ?? $peserta->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-sm text-slate-600 sm:px-4">
                                    {{ $peserta->instansi ?? $peserta->institution ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-sm text-slate-600 sm:px-4">
                                    {{ $peserta->approved_at ? $peserta->approved_at->format('d M Y') : ($peserta->created_at ? $peserta->created_at->format('d M Y') : '-') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-600">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="mt-2 font-medium text-slate-700">Belum ada peserta aktif</p>
                    <p class="mt-1 text-xs">Belum ada peserta dari sekolah Anda yang mengaktifkan akun di sistem.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
