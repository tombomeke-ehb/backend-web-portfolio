<?php

namespace App\Http\Controllers;

use App\Models\NewsComment;
use App\Models\NewsItem;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsCommentController extends Controller
{
    public function store(Request $request, NewsItem $newsItem): RedirectResponse
    {
        // Check if comments are enabled
        if (!\App\Models\SiteSetting::get('comments_enabled', true)) {
            return redirect()->route('news.show', $newsItem)->with('status', 'comments-disabled');
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        $requireApproval = SiteSetting::get('comments_require_approval', true);
        $isApproved = !$requireApproval;

        NewsComment::create([
            'news_item_id' => $newsItem->id,
            'user_id' => (int)$request->user()->id,
            'body' => $validated['body'],
            'is_approved' => $isApproved,
            'approved_at' => $isApproved ? now() : null,
        ]);

        return redirect()->route('news.show', $newsItem)->with('status', 'comment-posted');
    }
}
