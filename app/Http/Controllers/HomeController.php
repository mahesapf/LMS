<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(6)
            ->get();
            
        return view('home', compact('news'));
    }

    public function news()
    {
        $news = News::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(12);
            
        return view('news.index', compact('news'));
    }

    public function newsDetail($id)
    {
        $newsItem = News::where('status', 'published')
            ->where('id', $id)
            ->firstOrFail();
            
        $relatedNews = News::where('status', 'published')
            ->where('id', '!=', $id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(3)
            ->get();
            
        return view('news.detail', compact('newsItem', 'relatedNews'));
    }
}
