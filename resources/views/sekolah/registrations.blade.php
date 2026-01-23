@extends('layouts.sekolah')

@section('title', 'Pendaftaran Saya')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Pendaftaran Saya</h1>
            <p class="mt-1 text-sm text-slate-500">Pantau status pendaftaran dan pembayaran sekolah Anda.</p>
        </div>
        <a href="{{ route('sekolah.activities.index') }}" class="inline-flex items-center rounded-lg bg-[#0284c7] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0369a1]">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Daftar Kegiatan Baru
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
            <h2 class="text-sm font-semibold text-slate-800">Daftar Pendaftaran</h2>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">#</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Program</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Kegiatan</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Peserta</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Pembayaran</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($registrations as $index => $registration)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $registrations->firstItem() + $index }}</td>
                                <td class="px-4 py-2 text-sm text-slate-900">{{ $registration->activity->name ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->activity->program->name ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">
                                    @if($registration->activity)
                                        {{ \Carbon\Carbon::parse($registration->activity->start_date)->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($registration->activity->end_date)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-700">
                                    {{ $registration->jumlah_peserta > 0 ? $registration->jumlah_peserta : ($registration->jumlah_kepala_sekolah + $registration->jumlah_guru) }}
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    @if($registration->status == 'pending')
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-amber-700">Menunggu</span>
                                                <span class="text-[10px] text-amber-600">Pending</span>
                                            </div>
                                        </div>
                                    @elseif($registration->status == 'approved' || $registration->status == 'validated')
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-emerald-700">Tervalidasi</span>
                                                <span class="text-[10px] text-emerald-600">Disetujui</span>
                                            </div>
                                        </div>
                                    @elseif($registration->status == 'rejected')
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.293 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-rose-700">Ditolak</span>
                                                <span class="text-[10px] text-rose-600">Tidak Disetujui</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-amber-700">{{ ucfirst($registration->status) }}</span>
                                                <span class="text-[10px] text-amber-600">Status</span>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    @php
                                        // Jika pendaftaran sudah tervalidasi, pembayaran otomatis dianggap lunas
                                        $isValidated = in_array($registration->status, ['validated', 'approved']);
                                    @endphp

                                    @if($isValidated && $registration->activity && $registration->calculateTotalPayment() > 0)
                                        {{-- Jika tervalidasi dan berbayar, otomatis lunas --}}
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-emerald-700">Lunas</span>
                                                <span class="text-[10px] text-emerald-600">Sudah Dibayar</span>
                                            </div>
                                        </div>
                                    @elseif($registration->payment)
                                        @if($registration->payment->status == 'pending')
                                            <div class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-amber-700">Verifikasi</span>
                                                    <span class="text-[10px] text-amber-600">Menunggu</span>
                                                </div>
                                            </div>
                                        @elseif($registration->payment->status == 'approved')
                                            <div class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-emerald-700">Lunas</span>
                                                    <span class="text-[10px] text-emerald-600">Sudah Dibayar</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.293 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-rose-700">Ditolak</span>
                                                    <span class="text-[10px] text-rose-600">Tidak Disetujui</span>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        @if($registration->activity && $registration->calculateTotalPayment() > 0)
                                            <a href="{{ route('payment.create', $registration) }}" class="flex items-center gap-1.5 hover:opacity-80 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-sky-700">Bayar Sekarang</span>
                                                    <span class="text-[10px] text-sky-600">Belum Dibayar</span>
                                                </div>
                                            </a>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-emerald-700">Gratis</span>
                                                    <span class="text-[10px] text-emerald-600">Tanpa Biaya</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center">
                                    <p class="text-sm text-slate-500">Belum ada pendaftaran kegiatan</p>
                                    <div class="mt-3">
                                        <a href="{{ route('sekolah.activities.index') }}" class="inline-flex items-center rounded-lg bg-[#0284c7] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0369a1]">
                                            Daftar Kegiatan Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($registrations->hasPages())
                <div class="mt-4">
                    {{ $registrations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
