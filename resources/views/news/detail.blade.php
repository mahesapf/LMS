@extends('layouts.app')

@section('title', $newsItem->title)

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('news') }}">Berita</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($newsItem->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card mb-4">
                <div class="card-body">
                    <!-- Article Header -->
                    <h1 class="mb-3">{{ $newsItem->title }}</h1>
                    
                    <!-- Meta Information -->
                    <div class="text-muted mb-4 pb-3 border-bottom">
                        <small>
                            <i class="bi bi-calendar"></i> {{ $newsItem->published_at->format('d F Y, H:i') }}
                            @if($newsItem->author)
                            <span class="ms-3"><i class="bi bi-person"></i> {{ $newsItem->author }}</span>
                            @endif
                            @if($newsItem->category)
                            <span class="ms-3"><i class="bi bi-tag"></i> {{ $newsItem->category }}</span>
                            @endif
                        </small>
                    </div>

                    <!-- Featured Image -->
                    @if($newsItem->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $newsItem->image) }}" class="img-fluid rounded" alt="{{ $newsItem->title }}">
                    </div>
                    @endif

                    <!-- Article Content -->
                    <div class="article-content">
                        {!! $newsItem->content !!}
                    </div>

                    <!-- Article Footer -->
                    @if($newsItem->tags)
                    <div class="mt-4 pt-3 border-top">
                        <strong>Tags:</strong>
                        @foreach(explode(',', $newsItem->tags) as $tag)
                        <span class="badge bg-secondary ms-1">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </article>

            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('news') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
                </a>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related News -->
            @if($relatedNews->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Berita Terkait</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($relatedNews as $related)
                        <a href="{{ route('news.detail', $related->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ Str::limit($related->title, 60) }}</h6>
                                    <small class="text-muted">{{ $related->published_at->format('d M Y') }}</small>
                                </div>
                                @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded ms-2">
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Latest News Widget -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Berita Lainnya</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('news') }}" class="btn btn-primary w-100">
                        Lihat Semua Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.article-content img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
}

.article-content p {
    margin-bottom: 1rem;
}

.article-content h2,
.article-content h3,
.article-content h4 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.article-content ul,
.article-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}
</style>
@endpush
