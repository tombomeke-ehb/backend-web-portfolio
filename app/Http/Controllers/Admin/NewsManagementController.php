<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\NewsItem;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewsManagementController extends Controller
{
    public function index(): View
    {
        $newsItems = NewsItem::query()
            ->with('translations')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.news.index', compact('newsItems'));
    }

    public function create(): View
    {
        $tags = Tag::query()->orderBy('name')->get();

        return view('admin.news.create', compact('tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_nl' => ['required', 'string', 'max:255'],
            'content_nl' => ['required', 'string'],
            'title_en' => ['required', 'string', 'max:255'],
            'content_en' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:4096'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        $publishedAt = !empty($validated['published_at']) ? $validated['published_at'] : now();

        $newsItem = NewsItem::create([
            'published_at' => $publishedAt,
            'image_path' => $imagePath,
        ]);

        $newsItem->translations()->createMany([
            ['lang' => 'nl', 'title' => $validated['title_nl'], 'content' => $validated['content_nl']],
            ['lang' => 'en', 'title' => $validated['title_en'], 'content' => $validated['content_en']],
        ]);

        $newsItem->tags()->sync($validated['tag_ids'] ?? []);

        ActivityLog::log('created', "Created news article: {$newsItem->title}", $newsItem);

        return redirect()->route('admin.news.index')->with('status', 'news-created');
    }

    public function edit(NewsItem $newsItem): View
    {
        $tags = Tag::query()->orderBy('name')->get();
        $newsItem->load(['tags', 'translations']);

        return view('admin.news.edit', compact('newsItem', 'tags'));
    }

    public function update(Request $request, NewsItem $newsItem): RedirectResponse
    {
        $validated = $request->validate([
            'title_nl' => ['required', 'string', 'max:255'],
            'content_nl' => ['required', 'string'],
            'title_en' => ['required', 'string', 'max:255'],
            'content_en' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
        ]);

        $newsItem->loadMissing('translations');

        if (($validated['remove_image'] ?? false) && $newsItem->image_path) {
            Storage::disk('public')->delete($newsItem->image_path);
            $newsItem->image_path = null;
        }

        if ($request->hasFile('image')) {
            if ($newsItem->image_path) {
                Storage::disk('public')->delete($newsItem->image_path);
            }
            $newsItem->image_path = $request->file('image')->store('news', 'public');
        }

        $newsItem->published_at = !empty($validated['published_at']) ? $validated['published_at'] : $newsItem->published_at;
        $newsItem->save();

        foreach (['nl', 'en'] as $lang) {
            $newsItem->translations()->updateOrCreate(
                ['lang' => $lang],
                [
                    'title' => $validated["title_{$lang}"],
                    'content' => $validated["content_{$lang}"],
                ]
            );
        }

        $newsItem->tags()->sync($validated['tag_ids'] ?? []);

        ActivityLog::log('updated', "Updated news article: {$newsItem->title}", $newsItem);

        return redirect()->route('admin.news.index')->with('status', 'news-updated');
    }

    public function destroy(NewsItem $newsItem): RedirectResponse
    {
        $title = $newsItem->title;

        if ($newsItem->image_path) {
            Storage::disk('public')->delete($newsItem->image_path);
        }

        $newsItem->delete();

        ActivityLog::log('deleted', "Deleted news article: {$title}");

        return redirect()->route('admin.news.index')->with('status', 'news-deleted');
    }
}
