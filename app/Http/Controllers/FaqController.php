<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $categories = FaqCategory::query()
            ->with(['translations', 'items.translations'])
            ->orderBy('sort_order')
            ->orderBy('slug')
            ->get();

        return view('faq.index', compact('categories'));
    }
}
