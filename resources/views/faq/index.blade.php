@extends('layouts.app')

@section('content')
<section class="faq-page">
    <div class="container">
        <div class="faq-hero">
            <div class="faq-hero-icon">
                <i class="far fa-question-circle"></i>
            </div>
            <h1>{{ __('Frequently Asked Questions') }}</h1>
            <p>{{ __('Find answers to common questions about our services and policies') }}</p>
        </div>

        {{-- Category quick links --}}
        @if($categories->count() > 1)
            <div class="faq-categories-nav">
                @foreach ($categories as $cat)
                    <a href="#{{ $cat->slug }}" class="faq-category-link">
                        <i class="fas fa-folder"></i>
                        {{ $cat->name }}
                        <span class="faq-category-count">{{ $cat->items->count() }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="faq-content">
            @forelse ($categories as $category)
                <div class="faq-section" id="{{ $category->slug }}">
                    <div class="faq-section-header">
                        <h2>
                            <i class="fas fa-folder-open"></i>
                            {{ $category->name }}
                        </h2>
                        <span class="faq-section-count">{{ $category->items->count() }} {{ __('questions') }}</span>
                    </div>

                    @if ($category->items->isEmpty())
                        <div class="faq-empty">
                            <i class="far fa-folder-open"></i>
                            <p>{{ __('No questions in this category yet.') }}</p>
                        </div>
                    @else
                        <div class="faq-list">
                            @foreach ($category->items as $item)
                                <details class="faq-item">
                                    <summary class="faq-question">
                                        <div class="faq-question-icon">
                                            <i class="fas fa-question"></i>
                                        </div>
                                        <span class="faq-question-text">{{ $item->question }}</span>
                                        <i class="fas fa-chevron-down faq-chevron"></i>
                                    </summary>
                                    <div class="faq-answer">
                                        <div class="faq-answer-content">{!! nl2br(e($item->answer)) !!}</div>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="faq-empty faq-empty--large">
                    <i class="far fa-question-circle"></i>
                    <h3>{{ __('No FAQs yet') }}</h3>
                    <p>{{ __('Check back later for frequently asked questions.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
