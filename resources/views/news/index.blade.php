@extends('layouts.app')

@section('title', 'Berita')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h1 class="mb-3">Berita</h1>
            <p class="text-muted">Informasi terbaru seputar program dan kegiatan penjaminan mutu</p>
        </div>
    </div>

    <!-- News Grid -->
    <div class="row">
        @forelse($news as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                @else
                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                    <span class="text-white display-6">📰</span>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($item->content), 150) }}</p>
                    <div class="mt-auto">
                        <p class="text-muted small mb-2">
                            <i class="bi bi-calendar"></i> {{ $item->published_at->format('d M Y') }}
                            @if($item->author)
                            <span class="ms-2"><i class="bi bi-person"></i> {{ $item->author }}</span>
                            @endif
                        </p>
                        <a href="{{ route('news.detail', $item->id) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <p class="mb-0">Belum ada berita yang dipublikasikan.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($news->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $news->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
