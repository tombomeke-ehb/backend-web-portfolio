<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqItemController extends Controller
{
    public function index(): View
    {
        $items = FaqItem::query()
            ->select('faq_items.*')
            ->join('faq_categories', 'faq_categories.id', '=', 'faq_items.faq_category_id')
            ->with(['category.translations', 'translations'])
            ->orderBy('faq_categories.sort_order')
            ->orderBy('faq_categories.slug')
            ->orderBy('faq_items.sort_order')
            ->orderBy('faq_items.id')
            ->paginate(20);

        return view('admin.faq.items.index', compact('items'));
    }

    public function create(): View
    {
        $categories = FaqCategory::query()->with('translations')->orderBy('sort_order')->orderBy('slug')->get();

        return view('admin.faq.items.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question_nl' => ['required', 'string', 'max:255'],
            'answer_nl' => ['required', 'string'],
            'question_en' => ['required', 'string', 'max:255'],
            'answer_en' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $item = FaqItem::create([
            'faq_category_id' => (int) $validated['faq_category_id'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        $item->translations()->createMany([
            ['lang' => 'nl', 'question' => $validated['question_nl'], 'answer' => $validated['answer_nl']],
            ['lang' => 'en', 'question' => $validated['question_en'], 'answer' => $validated['answer_en']],
        ]);

        return redirect()->route('admin.faq.items.index')->with('status', 'faq-item-created');
    }

    public function edit(FaqItem $item): View
    {
        $categories = FaqCategory::query()->with('translations')->orderBy('sort_order')->orderBy('slug')->get();
        $item->load('translations');

        return view('admin.faq.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, FaqItem $item): RedirectResponse
    {
        $validated = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question_nl' => ['required', 'string', 'max:255'],
            'answer_nl' => ['required', 'string'],
            'question_en' => ['required', 'string', 'max:255'],
            'answer_en' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $item->update([
            'faq_category_id' => (int) $validated['faq_category_id'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        foreach (['nl', 'en'] as $lang) {
            $item->translations()->updateOrCreate(
                ['lang' => $lang],
                [
                    'question' => $validated["question_{$lang}"],
                    'answer' => $validated["answer_{$lang}"],
                ]
            );
        }

        return redirect()->route('admin.faq.items.index')->with('status', 'faq-item-updated');
    }

    public function destroy(FaqItem $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('admin.faq.items.index')->with('status', 'faq-item-deleted');
    }
}
