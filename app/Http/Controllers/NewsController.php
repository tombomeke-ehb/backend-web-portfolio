<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $tagSlug = $request->string('tag')->toString();

        $newsItems = NewsItem::query()
            ->with(['translations', 'tags'])
            ->when($tagSlug !== '', function ($q) use ($tagSlug) {
                $q->whereHas('tags', fn ($t) => $t->where('slug', $tagSlug));
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('news.index', compact('newsItems', 'tagSlug'));
    }

    public function show(NewsItem $newsItem): View
    {
        $newsItem->load([
            'translations',
            'tags',
            'comments' => fn ($q) => $q->where('is_approved', true)->with('user')->orderByDesc('created_at'),
        ]);

        $commentsEnabled = \App\Models\SiteSetting::get('comments_enabled', true);

        return view('news.show', compact('newsItem', 'commentsEnabled'));
    }
}
