@extends('layouts.app')

@section('title', 'Semua Kegiatan Pelatihan')

@section('content')
<div class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-4 py-12 space-y-8">
        <!-- Header -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">Semua Kegiatan Pelatihan</h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Temukan berbagai program pelatihan yang tersedia untuk meningkatkan kompetensi Anda
            </p>
        </div>

        @if(session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Activities Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($activities as $activity)
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col h-full">
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 mb-1">{{ Str::title($activity->name) }}</h3>
                            @if($activity->program)
                                <p class="text-sm text-slate-500">
                                    <svg class="h-4 w-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $activity->program->name }}
                                </p>
                            @endif
                        </div>
                        @if($activity->registration_fee > 0)
                            <div class="flex items-center gap-1.5">
                                <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-amber-700">Berbayar</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-1.5">
                                <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-emerald-700">Gratis</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($activity->description)
                        <p class="text-sm text-slate-700 mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $activity->description }}
                        </p>
                    @endif

                    <div class="space-y-3 mb-4">
                        <div class="flex items-center text-sm text-slate-600">
                            <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium">Mulai:</span> {{ $activity->start_date->format('d M Y') }}
                        </div>
                        <div class="flex items-center text-sm text-slate-600">
                            <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium">Selesai:</span> {{ $activity->end_date->format('d M Y') }}
                        </div>
                        @if($activity->registration_fee > 0)
                        <div class="flex items-center text-sm text-slate-600">
                            <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">Biaya:</span> Rp {{ number_format($activity->registration_fee, 0, ',', '.') }}
                        </div>
                        @endif
                        @if($activity->financing_type)
                        <div class="flex items-center text-sm text-slate-600">
                            <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span class="font-medium">Pembiayaan:</span> {{ $activity->financing_type }} @if($activity->apbn_type) - {{ $activity->apbn_type }}@endif
                        </div>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <a href="{{ route('activities.show', $activity) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Lihat Detail & Daftar
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada kegiatan</h3>
                    <p class="mt-1 text-sm text-slate-500">Saat ini belum ada kegiatan pelatihan yang tersedia.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($activities->hasPages())
        <div class="flex justify-center">
            {{ $activities->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
