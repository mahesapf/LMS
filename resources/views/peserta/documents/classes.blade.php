@extends('layouts.peserta')

@section('title', 'Dokumen Saya')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Dokumen Saya</h1>
            <p class="mt-2 text-slate-600">Kelola dan unggah dokumen untuk setiap kelas yang Anda ikuti</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-lg border-l-4 border-emerald-500 bg-emerald-50 p-4 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg border-l-4 border-red-500 bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <!-- Classes Grid -->
    @if($myClasses->isEmpty())
        <div class="rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-lg font-semibold text-slate-900">Tidak ada kelas</h3>
            <p class="mt-1 text-slate-600">Anda belum terdaftar di kelas manapun</p>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($myClasses as $mapping)
                @php
                    $class = $mapping->class;
                    $activity = $class->activity;
                @endphp
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md h-full flex flex-col">
                    <!-- Badges -->
                    <div class="flex items-center gap-2 mb-3 flex-wrap">
                        <span class="inline-flex rounded-full bg-[#0284c7] px-2.5 py-1 text-xs font-semibold text-white">
                            {{ $activity->activity_type ?? 'Kegiatan' }}
                        </span>
                        @if($class->status == 'open')
                        <span class="inline-flex items-center rounded-full bg-[#0284c7] px-2.5 py-1 text-xs font-semibold text-white">
                            Buka
                        </span>
                        @elseif($class->status == 'closed')
                        <span class="inline-flex items-center rounded-full bg-orange-500 px-2.5 py-1 text-xs font-semibold text-white">
                            Tutup
                        </span>
                        @else
                        <span class="inline-flex items-center rounded-full bg-slate-500 px-2.5 py-1 text-xs font-semibold text-white">
                            Selesai
                        </span>
                        @endif
                    </div>

                    <!-- Activity Name -->
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">
                        {{ Str::limit($activity->activity_name ?? '-', 50) }}
                    </p>

                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-slate-900 mb-3">{{ Str::limit($class->class_name, 60) }}</h3>

                    <!-- Description -->
                    @if($class->description)
                    <p class="text-sm text-slate-700 mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $class->description }}
                    </p>
                    @else
                    <p class="text-sm text-slate-500 mb-4 italic">Tidak ada deskripsi</p>
                    @endif

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-3 text-xs text-slate-600 mb-4">
                        <div class="rounded-lg bg-slate-50 p-3">
                            <p class="font-semibold text-slate-800 mb-1">Kegiatan</p>
                            <p class="text-slate-600">{{ Str::limit($activity->activity_name ?? '-', 20) }}</p>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-3">
                            <p class="font-semibold text-slate-800 mb-1">Kuota</p>
                            <p class="text-slate-600">{{ $class->quota }} peserta</p>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="mt-auto">
                        <a href="{{ route('peserta.documents.class', $class) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#0284c7] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0369a1]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            Lihat Dokumen
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
