@extends('layouts.peserta')

@section('title', 'Kelas & Nilai Saya')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelas & Nilai Saya</h1>
            <p class="mt-1 text-sm text-slate-600">Daftar kelas yang Anda ikuti dan nilai yang diperoleh</p>
        </div>
    </div>

    @if(session('success'))
    <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if($mappings->count() > 0)
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($mappings as $mapping)
        @php
            $classGrades = $grades->get($mapping->class_id, collect());
            $averageScore = $classGrades->count() > 0 ? $classGrades->avg('final_score') : null;
        @endphp
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md h-full flex flex-col">
            <!-- Badges -->
            <div class="flex items-center gap-2 mb-3 flex-wrap">
                <div class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-sky-700">{{ Str::limit($mapping->class->activity->name ?? 'Kegiatan', 20) }}</span>
                        <span class="text-[10px] text-sky-600">Kegiatan</span>
                    </div>
                </div>
                @if($mapping->class->status == 'open')
                <div class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-emerald-700">Buka</span>
                        <span class="text-[10px] text-emerald-600">Aktif</span>
                    </div>
                </div>
                @elseif($mapping->class->status == 'closed')
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
            </div>

            <!-- Title -->
            <h3 class="text-lg font-semibold text-slate-900 mb-3">{{ Str::limit($mapping->class->name, 60) }}</h3>

            <!-- Description -->
            @if($mapping->class->description)
            <p class="text-sm text-slate-700 mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                {{ $mapping->class->description }}
            </p>
            @else
            <p class="text-sm text-slate-500 mb-4 italic">Tidak ada deskripsi</p>
            @endif

            <!-- Info Grid -->
            <div class="grid grid-cols-2 gap-3 text-xs mb-4">
                <div class="flex items-center gap-1.5 rounded-lg bg-slate-50 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-slate-800">Terdaftar</span>
                        <span class="text-[10px] text-slate-600">{{ $mapping->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 rounded-lg bg-slate-50 p-3">
                    @if($averageScore)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-slate-800">Nilai</span>
                        <span class="text-[10px] text-emerald-600 font-semibold">{{ number_format($averageScore, 2) }}</span>
                    </div>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm0 3a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm0 3a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-slate-800">Nilai</span>
                        <span class="text-[10px] text-slate-500">Belum ada</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Button -->
            <div class="mt-auto">
                <a href="{{ route('peserta.classes.detail', $mapping->class) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#0284c7] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0369a1]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                    Lihat detail
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @if($mappings->hasPages())
    <div class="flex justify-center">
        {{ $mappings->links() }}
    </div>
    @endif

    @else
    <div class="rounded-xl border border-slate-200 bg-white p-12 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <h3 class="mt-4 text-lg font-semibold text-slate-900">Belum Ada Kelas</h3>
        <p class="mt-2 text-sm text-slate-600">Anda belum terdaftar di kelas manapun.</p>
    </div>
    @endif
</div>
@endsection
