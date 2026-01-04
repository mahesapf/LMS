@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center py-5">
                    <h1 class="display-4 mb-3">Sistem Informasi Penjaminan Mutu</h1>
                    <p class="lead">Platform terpadu untuk mengelola program dan kegiatan penjaminan mutu pendidikan</p>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg mt-3">Login</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg mt-3">Ke Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mb-5">
        <div class="col-lg-12 mb-4">
            <h2 class="text-center mb-4">Fitur Utama</h2>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="display-6 text-primary mb-3">👤</div>
                    <h5 class="card-title">Manajemen Pengguna</h5>
                    <p class="card-text">Kelola akun Super Admin, Admin, Fasilitator, dan Peserta dengan mudah</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="display-6 text-primary mb-3">📚</div>
                    <h5 class="card-title">Program & Kegiatan</h5>
                    <p class="card-text">Kelola program dan kegiatan penjaminan mutu secara terstruktur</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="display-6 text-primary mb-3">📊</div>
                    <h5 class="card-title">Penilaian</h5>
                    <p class="card-text">Input dan monitor nilai peserta secara real-time</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="display-6 text-primary mb-3">📄</div>
                    <h5 class="card-title">Dokumen</h5>
                    <p class="card-text">Upload dan kelola dokumen surat tugas dan tugas kegiatan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- News Section -->
    @if(isset($news) && $news->count() > 0)
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Berita Terbaru</h2>
                <a href="{{ route('news') }}" class="btn btn-outline-primary">Lihat Semua</a>
            </div>
        </div>
        @foreach($news as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="card-text">{{ Str::limit(strip_tags($item->content), 100) }}</p>
                    <p class="text-muted small">{{ $item->published_at->format('d M Y') }}</p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="{{ route('news.detail', $item->id) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
