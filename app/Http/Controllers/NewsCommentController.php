<?php

namespace App\Http\Controllers;

use App\Models\NewsComment;
use App\Models\NewsItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsCommentController extends Controller
{
    public function store(Request $request, NewsItem $newsItem): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        NewsComment::create([
            'news_item_id' => $newsItem->id,
            'user_id' => (int)$request->user()->id,
            'body' => $validated['body'],
            // For simplicity: auto-approve authenticated users
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return redirect()->route('news.show', $newsItem)->with('status', 'comment-posted');
    }
}
