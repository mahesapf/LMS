@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-4 py-12 space-y-12">
        <!-- Hero -->
        <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                    Untuk Peserta Pelatihan
                </div>
                <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">Ikuti Pelatihan & Tingkatkan Kompetensi</h1>
                <p class="text-base text-slate-600">Temukan kegiatan pelatihan, daftar dengan mudah, pantau jadwal, unggah bukti bayar, dan dapatkan sertifikat Anda.</p>
                <div class="flex flex-wrap gap-3 pt-2">
                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                            Masuk untuk daftar
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                            Ke dashboard
                        </a>
                    @endguest
                    <a href="#fitur" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lihat fitur</a>
                </div>
                <div class="flex flex-wrap gap-4 pt-4 text-sm text-slate-600">
                    <div class="flex items-center gap-2">
                        <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                        Jadwal pelatihan & kehadiran
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-block h-2 w-2 rounded-full bg-sky-500"></span>
                        Notifikasi pendaftaran & pembayaran
                    </div>
                </div>
            </div>
            <div class="space-y-3 text-center flex flex-col items-center">
                <h2 class="text-xl font-semibold text-slate-900">Peta sebaran guru binaan</h2>
                <div class="flex items-center justify-center w-full">
                    <img src="{{ asset('storage/peta-sebaran-guru-binaan.svg') }}" alt="Peta sebaran guru binaan" class="w-full max-w-xl h-auto">
                </div>
            </div>
        </div>

        <!-- Latest Activities Slider -->
        @if(isset($latestActivities) && $latestActivities->count() > 0)
        <div id="fitur" class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-slate-900">5 Kegiatan Terbaru</h2>
                <a href="{{ route('activities.index') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Lihat semua →</a>
            </div>
            <div class="relative" x-data="{ currentSlide: 0, totalSlides: {{ $latestActivities->count() }} }">
                <div class="overflow-hidden rounded-xl">
                    <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentSlide * 100}%)`">
                        @foreach($latestActivities as $activity)
                        <div class="w-full flex-shrink-0 px-2">
                            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">{{ $activity->program->name }}</span>
                                            @if($activity->registration_fee > 0)
                                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Berbayar</span>
                                            @else
                                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Gratis</span>
                                            @endif
                                        </div>
                                        <h3 class="text-lg font-semibold text-slate-900 mb-3">{{ $activity->name }}</h3>
                                        <p class="text-sm text-slate-700 mb-4">{{ Str::limit($activity->description, 150) }}</p>
                                        <div class="grid grid-cols-2 gap-3 text-xs text-slate-600 mb-4">
                                            <div class="rounded-lg bg-slate-50 p-3">
                                                <p class="font-semibold text-slate-800">Mulai</p>
                                                <p class="text-slate-600">{{ $activity->start_date->format('d M Y') }}</p>
                                            </div>
                                            <div class="rounded-lg bg-slate-50 p-3">
                                                <p class="font-semibold text-slate-800">Selesai</p>
                                                <p class="text-slate-600">{{ $activity->end_date->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        @if($activity->financing_type)
                                        <p class="text-xs text-slate-500 mb-4">Pembiayaan: {{ $activity->financing_type }} @if($activity->apbn_type) - {{ $activity->apbn_type }}@endif</p>
                                        @endif
                                        <a href="{{ route('activities.show', $activity) }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                                            Lihat detail & daftar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Navigation Buttons -->
                <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 rounded-full bg-white border border-slate-200 p-2 shadow-lg hover:bg-slate-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 rounded-full bg-white border border-slate-200 p-2 shadow-lg hover:bg-slate-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <!-- Dots Indicator -->
                <div class="mt-4 flex justify-center gap-2">
                    <template x-for="(slide, index) in totalSlides" :key="index">
                        <button @click="currentSlide = index" class="h-2 w-2 rounded-full transition-all" :class="currentSlide === index ? 'bg-sky-600 w-8' : 'bg-slate-300'" :aria-label="`Go to slide ${index + 1}`"></button>
                    </template>
                </div>
            </div>
        </div>
        @endif

        <!-- Activities -->
        @if(isset($activities) && $activities->count() > 0)
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-slate-900">Kegiatan pelatihan tersedia</h2>
                @auth
                        <a href="{{ route('activities.index') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Cari jadwal lain →</a>
                @endauth
            </div>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($activities as $activity)
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $activity->name }}</p>
                            <p class="text-xs text-slate-500">{{ $activity->program->name }}</p>
                        </div>
                        @if($activity->registration_fee > 0)
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Berbayar</span>
                        @else
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Gratis</span>
                        @endif
                    </div>
                    <p class="mt-3 text-sm text-slate-700">{{ Str::limit($activity->description, 100) }}</p>
                    <div class="mt-4 grid grid-cols-2 gap-3 text-xs text-slate-600">
                        <div class="rounded-lg bg-slate-50 p-3">
                            <p class="font-semibold text-slate-800">Mulai</p>
                            <p class="text-slate-600">{{ $activity->start_date->format('d M Y') }}</p>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-3">
                            <p class="font-semibold text-slate-800">Selesai</p>
                            <p class="text-slate-600">{{ $activity->end_date->format('d M Y') }}</p>
                        </div>
                    </div>
                    @if($activity->financing_type)
                    <p class="mt-3 text-xs text-slate-500">Pembiayaan: {{ $activity->financing_type }} @if($activity->apbn_type) - {{ $activity->apbn_type }}@endif</p>
                    @endif
                    <div class="mt-4">
                        <a href="{{ route('activities.show', $activity) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                            Lihat detail & daftar
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- News -->
        @if(isset($news) && $news->count() > 0)
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-slate-900">Berita terbaru</h2>
                <a href="{{ route('news') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Lihat semua →</a>
            </div>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($news as $item)
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-40 w-full object-cover">
                    @endif
                    <div class="space-y-3 p-4">
                        <div class="text-xs font-semibold text-slate-500">{{ $item->published_at->format('d M Y') }}</div>
                        <h3 class="text-base font-semibold text-slate-900">{{ $item->title }}</h3>
                        <p class="text-sm text-slate-600">{{ Str::limit(strip_tags($item->content), 110) }}</p>
                        <a href="{{ route('news.detail', $item->id) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-sky-700 hover:text-sky-800">Baca selengkapnya →</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
