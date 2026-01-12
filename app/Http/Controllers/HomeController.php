<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Activity;
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

        // Get 5 latest activities for slider
        $latestActivities = Activity::whereIn('status', ['planned', 'ongoing'])
            ->with('program')
            ->latest('created_at')
            ->take(5)
            ->get();

        // Get active activities for homepage
        $activities = Activity::whereIn('status', ['planned', 'ongoing'])
            ->with('program')
            ->orderBy('start_date')
            ->take(6)
            ->get();

        return view('home', compact('news', 'activities', 'latestActivities'));
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
