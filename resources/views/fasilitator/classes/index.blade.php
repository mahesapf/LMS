@extends('layouts.dashboard')

@section('title', 'Kelas Saya')

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="space-y-2">
        <h1 class="text-2xl font-semibold text-slate-900">Kelas Saya</h1>
        <p class="text-sm text-slate-600">Kelola kelas yang ditugaskan, input nilai, dan pantau progres peserta.</p>
    </div>

    @if($mappings->count() > 0)
        <!-- Classes Grid -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($mappings as $mapping)
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm h-full flex flex-col">
                <div class="mb-2">
                    <div class="flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold text-sky-700">{{ Str::limit($mapping->class->activity->name ?? 'Kelas', 25) }}</span>
                            <span class="text-[10px] text-sky-600">Kegiatan</span>
                        </div>
                    </div>
                </div>

                <h3 class="text-base font-semibold text-slate-900 mb-2 line-clamp-2">{{ $mapping->class->name }}</h3>

                @if($mapping->class->description)
                    <p class="text-xs text-slate-600 mb-3 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $mapping->class->description }}</p>
                @endif

                <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                    <div class="flex items-center gap-1.5 rounded-lg bg-slate-50 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold text-slate-800">Peserta</span>
                            <span class="text-[10px] text-slate-600">{{ $mapping->class->max_participants ?? '∞' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 rounded-lg bg-slate-50 p-2">
                        @if($mapping->class->status === 'active')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-emerald-700">Aktif</span>
                                <span class="text-[10px] text-emerald-600">Berjalan</span>
                            </div>
                        @elseif($mapping->class->status === 'completed')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-700">Selesai</span>
                                <span class="text-[10px] text-slate-600">Berakhir</span>
                            </div>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-amber-700">{{ ucfirst($mapping->class->status) }}</span>
                                <span class="text-[10px] text-amber-600">Menunggu</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-auto space-y-2">
                    <a href="{{ route('fasilitator.classes.detail', $mapping->class) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-sky-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        Detail Kelas
                    </a>
                    <a href="{{ route('fasilitator.grades', $mapping->class) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Input Nilai
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($mappings->hasPages())
        <div class="flex justify-center pt-4">
            {{ $mappings->links() }}
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-6 text-center">
            <p class="text-sm text-slate-600">Saat ini Anda belum ditugaskan ke kelas manapun. Hubungi administrator untuk mendapatkan penugasan.</p>
        </div>
    @endif
</div>
@endsection
