<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsPublicController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()->with('category', 'author');

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->latest('published_at')->paginate(9);
        $categories = NewsCategory::withCount('news')->get();

        return view('public.berita.index', compact('news', 'categories'));
    }

    public function show($slug)
    {
        $news = News::published()->with('category', 'author')->where('slug', $slug)->firstOrFail();
        $relatedNews = News::published()
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->take(3)
            ->get();

        return view('public.berita.show', compact('news', 'relatedNews'));
    }
}
