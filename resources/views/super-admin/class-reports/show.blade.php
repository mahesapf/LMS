@extends('layouts.dashboard')

@section('title', 'Detail Laporan Kelas - ' . $class->name)

@section('sidebar')
    @if(isset($routePrefix) && $routePrefix === 'admin')
        @include('admin.partials.sidebar')
    @else
        @include('super-admin.partials.sidebar')
    @endif
@endsection

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'fasilitator' }">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm">
        <a href="{{ route(($routePrefix ?? 'super-admin') . '.class-reports.index') }}" class="text-sky-600 hover:text-sky-700">Laporan Kelas</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        <span class="text-slate-600">{{ $class->name }}</span>
    </div>

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">{{ $class->name }}</h1>
        <p class="mt-1 text-sm text-slate-500">Daftar laporan dan dokumen yang diupload oleh fasilitator.</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Class Info Summary -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="grid divide-x divide-slate-200 md:grid-cols-2 lg:grid-cols-4">
            <!-- Kegiatan -->
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-xs font-medium text-slate-500">Kegiatan</p>
                </div>
                <p class="text-sm font-semibold text-slate-900">{{ $class->activity->name ?? '-' }}</p>
            </div>

            <!-- Program -->
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                    </svg>
                    <p class="text-xs font-medium text-slate-500">Program</p>
                </div>
                <p class="text-sm font-semibold text-slate-900">{{ $class->activity->program->name ?? '-' }}</p>
            </div>

            <!-- Total Documents -->
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-xs font-medium text-slate-500">Total Laporan</p>
                </div>
                <p class="text-sm font-semibold text-slate-900">{{ $documents->total() }} Dokumen</p>
            </div>

            <!-- Total Peserta -->
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    <p class="text-xs font-medium text-slate-500">Total Peserta</p>
                </div>
                <p class="text-sm font-semibold text-slate-900">{{ $grades->total() }} Orang</p>
            </div>
        </div>
    </div>

    <!-- Class Description -->
    @if($class->description)
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-slate-900">Deskripsi Kelas</h3>
            <p class="mt-2 text-sm text-slate-600">{{ $class->description }}</p>
        </div>
    @endif

    <!-- Fasilitator List -->
    @if($class->fasilitatorMappings->count() > 0)
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-slate-900">Fasilitator Kelas</h3>
            <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($class->fasilitatorMappings as $mapping)
                    <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-sky-100">
                            <span class="text-sm font-semibold text-sky-700">{{ substr($mapping->fasilitator->name ?? 'F', 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $mapping->fasilitator->name ?? '-' }}</p>
                            <p class="text-xs text-slate-500">{{ $mapping->fasilitator->email ?? '-' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <div class="flex gap-4">
                <button
                    @click="activeTab = 'fasilitator'"
                    :class="activeTab === 'fasilitator' ? 'border-sky-600 text-sky-600' : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300'"
                    class="border-b-2 px-1 py-2 text-sm font-semibold transition"
                >
                    Dokumen Fasilitator
                </button>
                <button
                    @click="activeTab = 'nilai'"
                    :class="activeTab === 'nilai' ? 'border-sky-600 text-sky-600' : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300'"
                    class="border-b-2 px-1 py-2 text-sm font-semibold transition"
                >
                    Laporan Nilai
                </button>
                <button
                    @click="activeTab = 'tugas'"
                    :class="activeTab === 'tugas' ? 'border-sky-600 text-sky-600' : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300'"
                    class="border-b-2 px-1 py-2 text-sm font-semibold transition"
                >
                    Pengumpulan Tugas
                </button>
            </div>
        </div>

        <!-- Tab Content: Dokumen Fasilitator -->
        <div x-show="activeTab === 'fasilitator'" class="min-h-[400px]">
        <div class="border-b border-slate-200 px-6 py-4">
            <h3 class="text-lg font-semibold text-slate-900">Dokumen Laporan</h3>
            <p class="mt-1 text-sm text-slate-500">Daftar semua dokumen yang diupload oleh fasilitator.</p>
        </div>

        @if($documents->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Judul Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Diupload Oleh</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Tanggal Upload</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Ukuran File</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($documents as $document)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900">{{ $document->title ?? $document->file_name }}</p>
                                            @if($document->description)
                                                <p class="text-sm text-slate-500">{{ Str::limit($document->description, 60) }}</p>
                                            @endif
                                            @if($document->requirement)
                                                <div class="mt-1 inline-flex items-center gap-1.5 rounded-lg border border-sky-200 bg-sky-50 px-2 py-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                    </svg>
                                                    <div class="flex flex-col">
                                                        <span class="text-xs font-semibold leading-tight text-sky-700">{{ $document->requirement->name }}</span>
                                                        <span class="text-[10px] leading-tight text-sky-600">Requirement</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2 py-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex flex-col">
                                            <span class="text-xs font-semibold leading-tight text-slate-700">{{ strtoupper(pathinfo($document->file_name, PATHINFO_EXTENSION)) }}</span>
                                            <span class="text-[10px] leading-tight text-slate-600">File Type</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($document->uploader)
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">{{ $document->uploader->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $document->uploader->email }}</p>
                                        </div>
                                    @else
                                        <span class="text-sm text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900">{{ $document->uploaded_date ? $document->uploaded_date->format('d M Y') : '-' }}</div>
                                    <div class="text-xs text-slate-500">{{ $document->created_at ? $document->created_at->format('H:i') : '' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600">
                                        @if($document->file_size)
                                            @if($document->file_size < 1024)
                                                {{ $document->file_size }} B
                                            @elseif($document->file_size < 1048576)
                                                {{ round($document->file_size / 1024, 2) }} KB
                                            @else
                                                {{ round($document->file_size / 1048576, 2) }} MB
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($document->file_path)
                                        <a
                                            href="{{ route(($routePrefix ?? 'super-admin') . '.class-reports.download', $document) }}"
                                            class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white hover:bg-[#0369a1] focus:outline-none focus:ring-2 focus:ring-sky-500/50"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            Download
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400">File tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
        <div class="mt-6 border-t border-slate-200 pt-4">
            {{ $documents->links() }}
        </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada dokumen</h3>
                <p class="mt-1 text-sm text-slate-500">Fasilitator belum mengupload dokumen laporan untuk kelas ini.</p>
            </div>
        @endif
        </div>

        <!-- Tab Content: Laporan Nilai -->
        <div x-show="activeTab === 'nilai'" x-cloak class="min-h-[400px]">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Laporan Nilai Peserta</h3>
                <p class="mt-1 text-sm text-slate-500">Daftar nilai peserta yang telah dinilai oleh fasilitator.</p>
            </div>

            @if($grades->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-slate-200 bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Nama Peserta</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Email</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-600">Nilai Akhir</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-600">Grade</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Dinilai Oleh</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($grades as $index => $grade)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm text-slate-900">{{ $grades->firstItem() + $index }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">{{ $grade->participant->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600">{{ $grade->participant->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-lg font-bold text-slate-900">{{ number_format($grade->final_score, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex items-center gap-1.5 rounded-lg border border-sky-200 bg-sky-50 px-2 py-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-semibold leading-tight text-sky-700">{{ $grade->grade_letter }}</span>
                                                <span class="text-[10px] leading-tight text-sky-600">Grade</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900">{{ $grade->fasilitator->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600">{{ $grade->graded_date ? $grade->graded_date->format('d M Y') : '-' }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6 border-t border-slate-200 pt-4">
                    {{ $grades->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada nilai</h3>
                    <p class="mt-1 text-sm text-slate-500">Fasilitator belum memberikan nilai untuk peserta kelas ini.</p>
                </div>
            @endif
        </div>

        <!-- Tab Content: Pengumpulan Tugas -->
        <div x-show="activeTab === 'tugas'" x-cloak class="min-h-[400px]">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Laporan Pengumpulan Tugas</h3>
                <p class="mt-1 text-sm text-slate-500">Daftar tugas yang telah dikumpulkan oleh peserta.</p>
            </div>

            @if($assignments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-slate-200 bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Judul Tugas</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Peserta</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Tipe File</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Tanggal Upload</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Ukuran</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($assignments as $assignment)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-900">{{ $assignment->title ?? $assignment->file_name }}</p>
                                                @if($assignment->description)
                                                    <p class="text-sm text-slate-500">{{ Str::limit($assignment->description, 60) }}</p>
                                                @endif
                                                @if($assignment->requirement)
                                                    <div class="mt-1 inline-flex items-center gap-1.5 rounded-lg border border-purple-200 bg-purple-50 px-2 py-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                        </svg>
                                                        <div class="flex flex-col">
                                                            <span class="text-xs font-semibold leading-tight text-purple-700">{{ $assignment->requirement->name }}</span>
                                                            <span class="text-[10px] leading-tight text-purple-600">Assignment</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($assignment->uploader)
                                            <div>
                                                <p class="text-sm font-medium text-slate-900">{{ $assignment->uploader->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $assignment->uploader->email }}</p>
                                            </div>
                                        @else
                                            <span class="text-sm text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2 py-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-semibold leading-tight text-slate-700">{{ strtoupper(pathinfo($assignment->file_name, PATHINFO_EXTENSION)) }}</span>
                                                <span class="text-[10px] leading-tight text-slate-600">File Type</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-900">{{ $assignment->uploaded_date ? $assignment->uploaded_date->format('d M Y') : '-' }}</div>
                                        <div class="text-xs text-slate-500">{{ $assignment->created_at ? $assignment->created_at->format('H:i') : '' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-slate-600">
                                            @if($assignment->file_size)
                                                @if($assignment->file_size < 1024)
                                                    {{ $assignment->file_size }} B
                                                @elseif($assignment->file_size < 1048576)
                                                    {{ round($assignment->file_size / 1024, 2) }} KB
                                                @else
                                                    {{ round($assignment->file_size / 1048576, 2) }} MB
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($assignment->file_path)
                                            <a
                                                href="{{ route(($routePrefix ?? 'super-admin') . '.class-reports.download', $assignment) }}"
                                                class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white hover:bg-[#0369a1] focus:outline-none focus:ring-2 focus:ring-sky-500/50"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                Download
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400">File tidak tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6 border-t border-slate-200 pt-4">
                    {{ $assignments->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada tugas</h3>
                    <p class="mt-1 text-sm text-slate-500">Peserta belum mengumpulkan tugas untuk kelas ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
