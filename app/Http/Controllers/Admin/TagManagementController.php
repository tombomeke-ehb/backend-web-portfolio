<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TagManagementController extends Controller
{
    public function index(): View
    {
        $tags = Tag::query()
            ->orderBy('name')
            ->paginate(30);

        return view('admin.tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.tags.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:60', Rule::unique('tags', 'name')],
            'slug' => ['nullable', 'string', 'max:60', Rule::unique('tags', 'slug')],
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['name']);

        Tag::create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        ActivityLog::log('created', "Created tag: {$validated['name']}");

        return redirect()->route('admin.tags.index')->with('status', 'tag-created');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:60', Rule::unique('tags', 'name')->ignore($tag->id)],
            'slug' => ['nullable', 'string', 'max:60', Rule::unique('tags', 'slug')->ignore($tag->id)],
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['name']);

        $tag->update([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        ActivityLog::log('updated', "Updated tag: {$tag->name}", $tag);

        return redirect()->route('admin.tags.index')->with('status', 'tag-updated');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $name = $tag->name;
        $tag->delete();

        ActivityLog::log('deleted', "Deleted tag: {$name}");

        return redirect()->route('admin.tags.index')->with('status', 'tag-deleted');
    }
}
