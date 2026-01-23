@extends('layouts.dashboard')

@section('title', 'Laporan Kelas')

@section('sidebar')
    @if(isset($routePrefix) && $routePrefix === 'admin')
        @include('admin.partials.sidebar')
    @else
        @include('super-admin.partials.sidebar')
    @endif
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Laporan Kelas</h1>
        <p class="mt-1 text-sm text-slate-500">Daftar laporan dan dokumen yang diupload fasilitator untuk setiap kelas.</p>
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

    @if(session('error'))
        <div class="rounded-lg border border-rose-200 bg-rose-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route(($routePrefix ?? 'super-admin') . '.class-reports.index') }}">
            <div class="flex gap-3">
                <div class="flex-1">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari nama kelas atau kegiatan..."
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20"
                    >
                </div>
                <button
                    type="submit"
                    class="rounded-lg bg-[#0284c7] px-6 py-2 font-semibold text-white hover:bg-[#0369a1] focus:outline-none focus:ring-2 focus:ring-sky-500/50"
                >
                    Cari
                </button>
                @if($search)
                    <a
                        href="{{ route(($routePrefix ?? 'super-admin') . '.class-reports.index') }}"
                        class="rounded-lg border border-slate-300 px-6 py-2 font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500/50"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Classes List -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        @if($classes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Kegiatan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Program</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Fasilitator</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Jumlah Laporan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($classes as $class)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $class->name }}</div>
                                    @if($class->description)
                                        <div class="text-sm text-slate-500">{{ Str::limit($class->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900">{{ $class->activity->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900">{{ $class->activity->program->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($class->fasilitatorMappings->count() > 0)
                                        <div class="space-y-1">
                                            @foreach($class->fasilitatorMappings as $mapping)
                                                <div class="flex items-center gap-2">
                                                    <div class="h-6 w-6 flex-shrink-0 rounded-full bg-sky-100 text-center">
                                                        <span class="text-xs font-medium text-sky-700">{{ substr($mapping->fasilitator->name ?? 'F', 0, 1) }}</span>
                                                    </div>
                                                    <span class="text-sm text-slate-700">{{ $mapping->fasilitator->name ?? '-' }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-sm text-slate-400">Belum ada fasilitator</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold text-slate-900">{{ $class->documents_count }}</span>
                                        <span class="text-sm text-slate-500">dokumen</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($class->status === 'active')
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0284c7] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-[#0284c7]">Aktif</span>
                                                <span class="text-[10px] text-sky-600">Kelas berjalan</span>
                                            </div>
                                        </div>
                                    @elseif($class->status === 'completed')
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-slate-700">Selesai</span>
                                                <span class="text-[10px] text-slate-600">Kelas berakhir</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-orange-700">{{ ucfirst($class->status) }}</span>
                                                <span class="text-[10px] text-orange-600">Status lainnya</span>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a
                                        href="{{ route(($routePrefix ?? 'super-admin') . '.class-reports.show', $class) }}"
                                        class="inline-flex items-center gap-2 rounded-md border border-sky-300 bg-white px-3 py-1.5 text-xs font-semibold text-sky-700 shadow-sm hover:bg-sky-50 focus:outline-none focus:ring-2 focus:ring-sky-500/50"
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat Laporan
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
        <div class="mt-6 border-t border-slate-200 pt-4">
            {{ $classes->links() }}
        </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada kelas</h3>
                <p class="mt-1 text-sm text-slate-500">
                    @if($search)
                        Tidak ditemukan kelas dengan kata kunci "{{ $search }}"
                    @else
                        Belum ada kelas yang tersedia.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
