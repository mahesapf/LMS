@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-4 py-12 space-y-12">
        <!-- Hero -->
        <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 rounded-full bg-sky-600 px-3 py-1 text-xs font-semibold text-white">
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
                <a href="#fitur" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Lihat semua →</a>
            </div>
            <div class="overflow-hidden" x-data="{
                scrollContainer: null,
                scrollAnimation: null,
                scrollSpeed: 1,
                isPaused: false,
                autoScroll() {
                    if (!this.isPaused && this.scrollContainer) {
                        this.scrollContainer.scrollLeft += this.scrollSpeed;

                        // Reset jika sudah sampai akhir
                        if (this.scrollContainer.scrollLeft >= (this.scrollContainer.scrollWidth - this.scrollContainer.clientWidth)) {
                            this.scrollContainer.scrollLeft = 0;
                        }

                        this.scrollAnimation = requestAnimationFrame(() => this.autoScroll());
                    }
                },
                init() {
                    this.scrollContainer = this.$refs.scrollContainer;
                    this.autoScroll();
                },
                destroy() {
                    if (this.scrollAnimation) {
                        cancelAnimationFrame(this.scrollAnimation);
                    }
                }
            }">
                <div x-ref="scrollContainer"
                     @mouseenter="isPaused = true"
                     @mouseleave="isPaused = false; autoScroll()"
                     class="overflow-x-auto scrollbar-hide scroll-smooth">
                    <div class="flex gap-4 pb-4">
                        @foreach($latestActivities as $activity)
                        <div class="w-72 flex-shrink-0">
                            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm h-full flex flex-col">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-semibold text-sky-700">Program</span>
                                                <span class="text-[10px] text-sky-600">{{ Str::limit($activity->program->name, 20) }}</span>
                                            </div>
                                        </div>
                                        @if($activity->registration_fee > 0)
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-amber-700">Status</span>
                                                    <span class="text-[10px] text-amber-600">Berbayar</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-emerald-700">Status</span>
                                                    <span class="text-[10px] text-emerald-600">Gratis</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="text-base font-semibold text-slate-900 mb-2">{{ Str::limit(Str::title($activity->name), 60) }}</h3>
                                    <p class="text-xs text-slate-700 mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $activity->description }}</p>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-600 mb-3">
                                        <div class="rounded-lg bg-slate-50 p-2">
                                            <p class="font-semibold text-slate-800">Mulai</p>
                                            <p class="text-slate-600">{{ $activity->start_date->format('d M Y') }}</p>
                                        </div>
                                        <div class="rounded-lg bg-slate-50 p-2">
                                            <p class="font-semibold text-slate-800">Selesai</p>
                                            <p class="text-slate-600">{{ $activity->end_date->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    @if($activity->financing_type)
                                    <p class="text-xs text-slate-500 mb-3">Pembiayaan: {{ $activity->financing_type }} @if($activity->apbn_type) - {{ $activity->apbn_type }}@endif</p>
                                    @endif
                                </div>
                                <div class="mt-auto">
                                    <a href="{{ route('activities.show', $activity) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-sky-700">
                                        Lihat detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- Duplicate cards untuk seamless loop -->
                        @foreach($latestActivities as $activity)
                        <div class="w-72 flex-shrink-0">
                            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm h-full flex flex-col">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-semibold text-sky-700">Program</span>
                                                <span class="text-[10px] text-sky-600">{{ Str::limit($activity->program->name, 20) }}</span>
                                            </div>
                                        </div>
                                        @if($activity->registration_fee > 0)
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-amber-700">Status</span>
                                                    <span class="text-[10px] text-amber-600">Berbayar</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-semibold text-emerald-700">Status</span>
                                                    <span class="text-[10px] text-emerald-600">Gratis</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="text-base font-semibold text-slate-900 mb-2">{{ Str::limit(Str::title($activity->name), 60) }}</h3>
                                    <p class="text-xs text-slate-700 mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $activity->description }}</p>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-600 mb-3">
                                        <div class="rounded-lg bg-slate-50 p-2">
                                            <p class="font-semibold text-slate-800">Mulai</p>
                                            <p class="text-slate-600">{{ $activity->start_date->format('d M Y') }}</p>
                                        </div>
                                        <div class="rounded-lg bg-slate-50 p-2">
                                            <p class="font-semibold text-slate-800">Selesai</p>
                                            <p class="text-slate-600">{{ $activity->end_date->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    @if($activity->financing_type)
                                    <p class="text-xs text-slate-500 mb-3">Pembiayaan: {{ $activity->financing_type }} @if($activity->apbn_type) - {{ $activity->apbn_type }}@endif</p>
                                    @endif
                                </div>
                                <div class="mt-auto">
                                    <a href="{{ route('activities.show', $activity) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-sky-700">
                                        Lihat detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Video Section -->
        <div class="space-y-6">
            <div class="text-center space-y-2">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Lihat Program Pelatihan Kami</h2>
                <p class="text-slate-600 text-lg">Pelajari lebih lanjut tentang berbagai program yang tersedia</p>
            </div>
            <div class="mx-auto max-w-5xl">
                <div class="relative w-full rounded-2xl overflow-hidden shadow-2xl" style="padding-bottom: 56.25%; /* 16:9 Aspect Ratio */">
                    <iframe
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/M0vK4Phvls4?si=YohDekcPLl8iIbuT"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Activities -->
        @if(isset($activities) && $activities->count() > 0)
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-slate-900">Kegiatan pelatihan tersedia</h2>
                @auth
                        <a href="#fitur" class="text-sm font-semibold text-sky-700 hover:text-sky-800">Cari jadwal lain →</a>
                @endauth
            </div>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($activities as $activity)
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm flex flex-col h-full">
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ Str::title($activity->name) }}</p>
                                <p class="text-xs text-slate-500">{{ $activity->program->name }}</p>
                            </div>
                            @if($activity->registration_fee > 0)
                                <div class="flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-amber-700">Status</span>
                                        <span class="text-[10px] text-amber-600">Berbayar</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-emerald-700">Status</span>
                                        <span class="text-[10px] text-emerald-600">Gratis</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <p class="mt-3 text-sm text-slate-700" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $activity->description }}</p>
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
                    </div>
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

<!-- Footer -->
<footer class="border-t border-slate-200" style="background-color: #0A2540;">
    <div class="mx-auto max-w-6xl px-4 py-16">
        <div class="grid gap-12 md:grid-cols-3 lg:grid-cols-5 mb-12">
            <!-- Brand -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('storage/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Logo" class="h-12 w-12">
                    <div>
                        <span class="text-xl font-bold text-white block">{{ config('app.name', 'SIPM') }}</span>
                        <span class="text-xs text-slate-400">Kementerian Pendidikan</span>
                    </div>
                </div>
                <p class="text-sm text-slate-300 leading-relaxed max-w-sm">
                    Platform pelatihan dan pengembangan kompetensi untuk meningkatkan kualitas pendidikan Indonesia.
                </p>
                <div class="flex gap-3 pt-2">
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white hover:bg-sky-500 transition">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white hover:bg-sky-500 transition">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white hover:bg-sky-500 transition">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                    </a>
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 hover:bg-sky-600 hover:text-white transition">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-white">Navigasi</h4>
                <ul class="space-y-3 text-sm text-slate-300">
                    <li><a href="{{ route('home') }}" class="hover:text-sky-400 transition">Beranda</a></li>
                    <li><a href="{{ route('news') }}" class="hover:text-sky-400 transition">Berita</a></li>
                    <li><a href="#fitur" class="hover:text-sky-400 transition">Program</a></li>
                    <li><a href="#" class="hover:text-sky-400 transition">Tentang Kami</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-white">Bantuan</h4>
                <ul class="space-y-3 text-sm text-slate-300">
                    <li><a href="#" class="hover:text-sky-400 transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-sky-400 transition">Kontak</a></li>
                    @guest
                        <li><a href="{{ route('login') }}" class="hover:text-sky-400 transition">Login</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}" class="hover:text-sky-400 transition">Dashboard</a></li>
                    @endguest
                </ul>
            </div>

            <!-- Legal -->
            <div class="space-y-4">
                <h4 class="text-sm font-semibold text-white">Legal</h4>
                <ul class="space-y-3 text-sm text-slate-300">
                    <li><a href="#" class="hover:text-sky-400 transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-sky-400 transition">Syarat Layanan</a></li>
                    <li><a href="#" class="hover:text-sky-400 transition">Disclaimer</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom -->
        <div class="pt-8 border-t border-white/10">
            <p class="text-sm text-slate-400 text-center">
                &copy; {{ date('Y') }} {{ config('app.name', 'SIPM') }}. BBPPMPV BMTI KEMENDIKDASMEN. All rights reserved.
        </div>
    </div>
</footer>
@endsection
