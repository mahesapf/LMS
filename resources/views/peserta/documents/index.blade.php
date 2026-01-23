@extends('layouts.peserta')

@section('title', 'Dokumen Saya')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('peserta.documents') }}" class="text-sky-600 hover:text-sky-700">Dokumen Kelas</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        <span class="text-slate-600">{{ is_object($myClasses) ? $myClasses->class->class_name : 'Dokumen' }}</span>
    </div>

    <!-- Header -->
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-semibold text-slate-900">{{ is_object($myClasses) ? $myClasses->class->class_name : 'Dokumen Saya' }}</h1>
            @if(is_object($myClasses))
                <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">{{ $myClasses->class->code ?? 'CLS-' . $myClasses->class->id }}</span>
            @endif
        </div>
        <p class="mt-1 text-sm text-slate-500">Kelola dan upload dokumen tugas untuk kelas ini.</p>
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

    @if(session('error'))
    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    @if($myClasses)
        @php
            $mapping = $myClasses;
        @endphp

        @php
            $stages = $mapping->class->stages ?? collect();
        @endphp

        @if($stages->count() > 0)
        <div class="space-y-4">
            @foreach($stages as $stage)
            @php
                $totalDocs = $stage->documentRequirements->count();
                $uploadedDocs = $stage->documentRequirements->filter(function($req) {
                    return $req->documents->where('uploaded_by', Auth::id())->count() > 0;
                })->count();
            @endphp
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                <details class="group" {{ $loop->first ? 'open' : '' }}>
                    <summary class="flex cursor-pointer items-center justify-between px-6 py-4 font-medium text-slate-900 hover:bg-slate-50">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 transition group-open:rotate-90" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-base font-semibold">{{ $stage->name }}</span>
                            @if($stage->status == 'ongoing')
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-sky-700">Berlangsung</span>
                                    <span class="text-[10px] text-sky-600">Sedang Aktif</span>
                                </div>
                            </div>
                            @elseif($stage->status == 'completed')
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-700">Selesai</span>
                                    <span class="text-[10px] text-slate-600">Sudah Berakhir</span>
                                </div>
                            </div>
                            @else
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-amber-700">{{ ucfirst(str_replace('_', ' ', $stage->status)) }}</span>
                                    <span class="text-[10px] text-amber-600">Status</span>
                                </div>
                            </div>
                            @endif
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-purple-700">{{ $uploadedDocs }}/{{ $totalDocs }}</span>
                                    <span class="text-[10px] text-purple-600">Progress Dokumen</span>
                                </div>
                            </div>
                        </div>
                    </summary>

                    <div class="border-t border-slate-200 px-6 py-4">
                            @if($stage->description)
                            <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                                <div class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $stage->description }}</span>
                                </div>
                            </div>
                            @endif

                            @if($stage->start_date || $stage->end_date)
                            <p class="mb-4 text-sm text-slate-600">
                                @if($stage->start_date)
                                <span class="inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    Mulai: {{ $stage->start_date->format('d M Y') }}
                                </span>
                                @endif
                                @if($stage->end_date)
                                | Selesai: {{ $stage->end_date->format('d M Y') }}
                                @endif
                            </p>
                            @endif

                            @if($stage->documentRequirements->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead class="border-b border-slate-200 bg-slate-50">
                                        <tr class="text-[11px] font-semibold uppercase tracking-wider text-slate-600">
                                            <th class="px-4 py-3 font-semibold">No</th>
                                            <th class="px-4 py-3 font-semibold">Nama Dokumen</th>
                                            <th class="px-4 py-3 font-semibold">Keterangan</th>
                                            <th class="px-4 py-3 font-semibold">Status</th>
                                            <th class="px-4 py-3 font-semibold">File</th>
                                            <th class="px-4 py-3 font-semibold">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @foreach($stage->documentRequirements as $req)
                                        @php
                                            $uploaded = $req->documents->where('uploaded_by', Auth::id())->first();
                                        @endphp
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3">
                                                <div class="font-semibold text-slate-900">{{ $req->document_name }}</div>
                                                @if($req->is_required)
                                                <div class="mt-1 flex items-center gap-1.5">
                                                    <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-semibold text-rose-700 leading-tight">Wajib</span>
                                                        <span class="text-[10px] text-rose-600 leading-tight">Harus Upload</span>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-slate-600">
                                                    {{ $req->description ?? '-' }}
                                                    @if($req->document_type)
                                                    <div class="mt-1 flex items-center gap-1.5">
                                                        <svg class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                        <div class="flex flex-col">
                                                            <span class="text-xs font-semibold text-sky-700 leading-tight">{{ strtoupper($req->document_type) }}</span>
                                                            <span class="text-[10px] text-sky-600 leading-tight">Format File</span>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="mt-1 text-xs text-slate-500">Max: {{ number_format($req->max_file_size / 1024, 1) }} MB</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($uploaded)
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-semibold text-emerald-700">Sudah Upload</span>
                                                        <span class="text-[10px] text-emerald-600">Tersimpan</span>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-semibold text-amber-700">Belum Upload</span>
                                                        <span class="text-[10px] text-amber-600">Menunggu</span>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($uploaded)
                                                <div class="text-slate-600">
                                                    <div>{{ Str::limit(basename($uploaded->file_path), 30) }}</div>
                                                    <div class="text-xs text-slate-500">
                                                        {{ $uploaded->created_at->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                                @else
                                                <span class="text-slate-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($uploaded)
                                                <div class="relative" x-data="{ open: false }">
                                                    <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center gap-1 rounded-md border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                    </button>
                                                    <div x-show="open" x-transition class="absolute right-0 z-40 mt-2 w-44 rounded-lg border border-slate-200 bg-white py-1 shadow-lg">
                                                        <a href="{{ Storage::url($uploaded->file_path) }}" target="_blank" class="flex items-center gap-2.5 px-3 py-2 text-sm hover:bg-slate-50">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            <span class="text-slate-700">Lihat File</span>
                                                        </a>
                                                        <button type="button" onclick="openModal{{ $req->id }}()" class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm hover:bg-slate-50">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                            </svg>
                                                            <span class="text-slate-700">Ganti File</span>
                                                        </button>
                                                        <form action="{{ route('peserta.documents.destroy', $uploaded) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm hover:bg-slate-50" onclick="return confirm('Yakin ingin menghapus?')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                <span class="text-red-500">Hapus</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @else
                                                <button type="button" onclick="openModal{{ $req->id }}()" class="inline-flex items-center justify-center gap-1 rounded-lg bg-sky-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-sky-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z" />
                                                        <path d="M9 13h2v5a1 1 0 11-2 0v-5z" />
                                                    </svg>
                                                    Upload
                                                </button>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Upload Modal -->
                                        <div id="modal{{ $req->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/70">
                                            <div class="mx-4 w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200">
                                                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                                                    <div>
                                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Formulir Upload</p>
                                                        <h3 class="text-lg font-semibold text-slate-900">{{ $req->document_name }}</h3>
                                                    </div>
                                                    <button type="button" onclick="closeModal{{ $req->id }}()" class="rounded-md p-2 text-slate-500 hover:bg-slate-100">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <form action="{{ route('peserta.documents.upload') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="document_requirement_id" value="{{ $req->id }}">
                                                    <input type="hidden" name="class_id" value="{{ $mapping->class->id }}">

                                                    <div class="space-y-6 px-6 py-6">
                                                        @if($req->description)
                                                        <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3">
                                                            <div class="flex gap-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                                </svg>
                                                                <div class="text-sm text-blue-800">
                                                                    <p class="font-semibold">Informasi</p>
                                                                    <p>{{ $req->description }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        <div class="rounded-xl border border-[#0284c7]/20 bg-[#0284c7]/5 p-4">
                                                            <div>
                                                                <label class="block text-sm font-medium text-slate-700">
                                                                    Pilih File <span class="text-red-600">*</span>
                                                                </label>
                                                                <input type="file" name="file" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200" required
                                                                       @if($req->document_type) accept=".{{ str_replace(',', ',.', $req->document_type) }}" @endif>
                                                                <p class="mt-1 text-xs text-slate-500">
                                                                    @if($req->document_type)
                                                                    Tipe: {{ strtoupper($req->document_type) }} |
                                                                    @endif
                                                                    Maks: {{ number_format($req->max_file_size / 1024, 1) }} MB
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-slate-700">Catatan (Opsional)</label>
                                                            <textarea name="notes" rows="3" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                                                        </div>

                                                        @if($uploaded)
                                                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3">
                                                            <div class="flex gap-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                                </svg>
                                                                <div class="text-sm text-amber-800">
                                                                    <p class="font-semibold">Perhatian</p>
                                                                    <p>File yang sudah ada akan diganti dengan file baru.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>

                                                    <div class="flex items-center gap-3 border-t border-slate-200 px-6 py-4 bg-slate-50">
                                                        <button type="button" onclick="closeModal{{ $req->id }}()" class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="flex-1 rounded-lg bg-[#0284c7] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0369a1]">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z" />
                                                                <path d="M9 13h2v5a1 1 0 11-2 0v-5z" />
                                                            </svg>
                                                            Upload
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <script>
                                            function openModal{{ $req->id }}() {
                                                document.getElementById('modal{{ $req->id }}').classList.remove('hidden');
                                                document.getElementById('modal{{ $req->id }}').classList.add('flex');
                                            }
                                            function closeModal{{ $req->id }}() {
                                                document.getElementById('modal{{ $req->id }}').classList.add('hidden');
                                                document.getElementById('modal{{ $req->id }}').classList.remove('flex');
                                            }
                                        </script>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                                <div class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Belum ada dokumen requirement untuk tahap ini.</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </details>
                </div>
                @endforeach
            </div>
            @else
            <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-slate-900">Belum Ada Tahap</h3>
                <p class="mt-2 text-sm text-slate-600">Belum ada tahap yang dibuat untuk kelas ini.</p>
            </div>
            @endif
    @else
    <div class="rounded-xl border border-slate-200 bg-white p-12 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-4 text-lg font-semibold text-slate-900">Akses Ditolak</h3>
        <p class="mt-2 text-sm text-slate-600">Anda tidak terdaftar di kelas ini atau sesi sudah berakhir. Silakan kembali ke halaman dokumen.</p>
    </div>
    @endif
</div>
@endsection
