@extends('layouts.app')

@section('content')
<section class="account-page">
    <div class="container">
        <div class="page-header">
            <div class="page-header-content">
                <h1><i class="far fa-newspaper"></i> {{ __('Latest News') }}</h1>
                <p class="page-subtitle">{{ __('Updates, announcements and progress posts') }}</p>                @if (!empty($tagSlug))
                    <div class="active-filter">
                        <span class="active-filter-label">{{ __('Filtered by') }}:</span>
                        <span class="tag-chip"><i class="fas fa-tag"></i> {{ $tagSlug }}</span>
                        <a href="{{ route('news.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-times"></i> {{ __('Clear') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="news-grid">
            @forelse ($newsItems as $item)
                <article class="news-card">
                    <a class="news-card-link" href="{{ route('news.show', $item) }}">
                        <div class="news-card-media">
                            @if ($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}">
                            @else
                                <div class="news-card-placeholder">
                                    <i class="far fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="news-card-body">
                            <h2 class="news-card-title">{{ $item->title }}</h2>
                            <p class="news-card-meta">
                                <i class="far fa-calendar"></i>
                                {{ optional($item->published_at)->format('d/m/Y') ?? $item->created_at->format('d/m/Y') }}
                            </p>                            @if (($item->tags ?? collect())->isNotEmpty())
                                <div class="news-card-tags">
                                    @foreach($item->tags as $tag)
                                        <span class="tag-chip tag-chip--small">#{{ $tag->slug }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <p class="news-card-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 140) }}</p>
                            <span class="news-card-cta">{{ __('Read more') }} <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </a>
                </article>
            @empty
                <div class="account-card">
                    <div class="card-body">
                        <p class="text-muted" style="margin:0;">{{ __('No news yet.') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($newsItems->hasPages())
            <div class="pagination-wrapper">
                {{ $newsItems->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
