<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\NewsComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsCommentManagementController extends Controller
{
    public function index(): View
    {
        $comments = NewsComment::query()
            ->with(['newsItem', 'user'])
            ->orderByDesc('created_at')
            ->paginate(25);

        return view('admin.news-comments.index', compact('comments'));
    }

    public function approve(NewsComment $comment): RedirectResponse
    {
        $comment->forceFill([
            'is_approved' => true,
            'approved_at' => now(),
        ])->save();

        ActivityLog::log('approved', "Approved comment by {$comment->user?->name} on: {$comment->newsItem?->title}", $comment);

        return redirect()->route('admin.news-comments.index')->with('status', 'comment-approved');
    }

    public function destroy(NewsComment $comment): RedirectResponse
    {
        $userName = $comment->user?->name ?? 'Guest';
        $newsTitle = $comment->newsItem?->title ?? 'Unknown';

        $comment->delete();

        ActivityLog::log('deleted', "Deleted comment by {$userName} on: {$newsTitle}");

        return redirect()->route('admin.news-comments.index')->with('status', 'comment-deleted');
    }
}
