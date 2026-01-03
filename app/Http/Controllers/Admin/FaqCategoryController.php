<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FaqCategoryController extends Controller
{
    public function index(): View
    {
        $categories = FaqCategory::query()
            ->with('translations')
            ->orderBy('sort_order')
            ->orderBy('slug')
            ->paginate(20);

        return view('admin.faq.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.faq.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_nl' => ['required', 'string', 'max:120'],
            'name_en' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('faq_categories', 'slug')],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['name_en']);

        $category = FaqCategory::create([
            'slug' => $slug,
            'sort_order' => (int)($validated['sort_order'] ?? 0),
        ]);

        $category->translations()->createMany([
            ['lang' => 'nl', 'name' => $validated['name_nl']],
            ['lang' => 'en', 'name' => $validated['name_en']],
        ]);

        return redirect()->route('admin.faq.categories.index')->with('status', 'faq-category-created');
    }

    public function edit(FaqCategory $category): View
    {
        $category->load('translations');

        return view('admin.faq.categories.edit', compact('category'));
    }

    public function update(Request $request, FaqCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name_nl' => ['required', 'string', 'max:120'],
            'name_en' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('faq_categories', 'slug')->ignore($category->id)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['name_en']);

        $category->update([
            'slug' => $slug,
            'sort_order' => (int)($validated['sort_order'] ?? 0),
        ]);

        foreach (['nl', 'en'] as $lang) {
            $category->translations()->updateOrCreate(
                ['lang' => $lang],
                ['name' => $validated["name_{$lang}"]]
            );
        }

        return redirect()->route('admin.faq.categories.index')->with('status', 'faq-category-updated');
    }

    public function destroy(FaqCategory $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.faq.categories.index')->with('status', 'faq-category-deleted');
    }
}
