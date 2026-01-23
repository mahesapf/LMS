@extends('layouts.dashboard')

@section('title', 'Input Nilai - ' . $class->name)

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6" x-data="{ openId: null }">
    <!-- Header Section -->
    <div class="rounded-2xl bg-gradient-to-br from-sky-600 to-blue-700 px-6 py-8 text-white shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.12em] text-white/80">Input Nilai</p>
                <h1 class="mt-2 text-3xl font-semibold">{{ $class->name }}</h1>
                <p class="mt-2 text-white/80">{{ $class->activity->name ?? 'Tidak ada kegiatan' }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('fasilitator.classes') }}" class="inline-flex items-center gap-2 rounded-lg bg-white/20 px-4 py-2 text-sm font-semibold backdrop-blur transition hover:bg-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition class="mb-4 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900 shadow-sm">
        <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </span>
        <div class="flex-1 text-sm font-semibold">{{ session('success') }}</div>
    </div>
    @endif

    <!-- Main Content Card -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">Daftar Peserta dan Nilai</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-900">{{ $participants->count() }} Peserta</h2>
                <p class="mt-2 text-sm text-slate-500">Kelola nilai untuk semua peserta kelas ini</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Total</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $participants->filter(fn($m) => $m->participant->grades->isNotEmpty())->count() }} Dinilai</p>
                </div>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Peserta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Institusi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($participants as $mapping)
                        @php
                            $participant = $mapping->participant;
                            $grade = $participant->grades->first() ?? null;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-900">{{ $participant->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $participant->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $participant->institution ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($grade)
                                    <div class="flex flex-wrap gap-1">
                                        <span class="inline-flex items-center rounded-md bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 01.95.69h1.952c.059 0 .113.01.165.025a3.002 3.002 0 011.767 2.275l1.07 3.292a1 1 0 01-.95.69H8.952a1 1 0 01-.95-.69 3.002 3.002 0 011.767-2.275l1.07-3.292a1 1 0 01.95-.69z" />
                                            </svg>
                                            {{ number_format($grade->final_score, 2) }}
                                        </span>
                                        <span class="inline-flex items-center rounded-md bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-800">
                                            Grade: {{ $grade->grade_letter }}
                                        </span>
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $grade->status == 'lulus' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($grade->status) }}
                                        </span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 112 0v2a1 1 0 11-2 0V7zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
                                        </svg>
                                        Belum ada nilai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button type="button" @click="openId = openId === {{ $participant->id }} ? null : {{ $participant->id }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-4h-4v4z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.121 10.464a1 1 0 10-1.414 1.414l-7.071 7.071z" />
                                    </svg>
                                    Input Nilai
                                </button>
                            </td>
                        </tr>

                        <!-- Inline Grade Form -->
                        <tr x-show="openId === {{ $participant->id }}" x-transition class="bg-slate-50">
                            <td colspan="6" class="px-6 py-4">
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-6">
                                    <form action="{{ route('fasilitator.grades.store', $class) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="participant_id" value="{{ $participant->id }}">

                                        <div class="grid gap-4 md:grid-cols-3">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700">Nilai Akhir (0-100) <span class="text-red-500">*</span></label>
                                                <input type="number" name="final_score" min="0" max="100" step="0.01" value="{{ old('final_score', optional($grade)->final_score) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500 @error('final_score') border-red-300 text-red-900 focus:ring-red-500 @enderror" required>
                                                @error('final_score')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-slate-700">Tanggal Penilaian</label>
                                                <input type="date" name="graded_date" value="{{ old('graded_date', date('Y-m-d')) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500 @error('graded_date') border-red-300 text-red-900 focus:ring-red-500 @enderror">
                                                @error('graded_date')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-slate-700">Catatan</label>
                                                <input type="text" name="notes" value="{{ old('notes', optional($grade)->notes) }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm placeholder-slate-400 focus:border-blue-500 focus:ring-blue-500 @error('notes') border-red-300 text-red-900 focus:ring-red-500 @enderror" placeholder="Opsional">
                                                @error('notes')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        @if($grade)
                                        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                                            <h4 class="text-sm font-semibold text-blue-900 mb-3">Nilai yang sudah ada:</h4>
                                            <div class="grid gap-2 sm:grid-cols-2">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm text-slate-600">Nilai Akhir:</span>
                                                    <span class="font-semibold text-slate-900">{{ number_format($grade->final_score, 2) }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm text-slate-600">Grade:</span>
                                                    <span class="font-semibold text-slate-900">{{ $grade->grade_letter }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm text-slate-600">Status:</span>
                                                    <span class="font-semibold {{ $grade->status == 'lulus' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($grade->status) }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm text-slate-600">Tanggal:</span>
                                                    <span class="font-semibold text-slate-900">{{ $grade->graded_date ? $grade->graded_date->format('d/m/Y') : '-' }}</span>
                                                </div>
                                                @if($grade->notes)
                                                <div class="flex items-start gap-2 sm:col-span-2">
                                                    <span class="text-sm text-slate-600">Catatan:</span>
                                                    <span class="font-semibold text-slate-900">{{ $grade->notes }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif

                                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                                            <button type="button" @click="openId = null" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                                Batal
                                            </button>
                                            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                                Simpan Nilai
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 112 0v2a1 1 0 11-2 0V7zm1 8a1.25 1.25 0 110-2.5A1.25 1.25 0 0110 15z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <p class="text-sm font-medium text-slate-500">Belum ada peserta aktif di kelas ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="mt-6 rounded-xl border border-blue-200 bg-blue-50 p-6">
        <div class="flex items-start gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 112 0v2a1 1 0 11-2 0V7zm1 8a1.25 1.25 0 110-2.5A1.25 1.25 0 0110 15z" clip-rule="evenodd" />
                </svg>
            </span>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-blue-900 mb-2">Informasi Penting</h4>
                <ul class="mt-2 space-y-1 text-sm text-blue-800">
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>Klik tombol <strong>Input Nilai</strong> untuk menambah atau mengupdate nilai peserta</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>Jika nilai dengan jenis penilaian yang sama sudah ada, maka akan diupdate</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>Satu peserta dapat memiliki beberapa jenis nilai (Tugas, Quiz, UTS, UAS, dll)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-600 mt-0.5">•</span>
                        <span>Nilai harus dalam rentang 0-100</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
