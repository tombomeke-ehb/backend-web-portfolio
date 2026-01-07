@extends('layouts.app')

@section('content')
<section class="account-page">
    <div class="container container--narrow">
        <div class="page-header">
            <div class="page-header-content">
                <h1><i class="far fa-newspaper"></i> {{ $newsItem->title }}</h1>
                <p class="page-subtitle">
                    <i class="far fa-calendar"></i>
                    {{ optional($newsItem->published_at)->format('d/m/Y H:i') ?? $newsItem->created_at->format('d/m/Y H:i') }}
                </p>                @if (($newsItem->tags ?? collect())->isNotEmpty())
                    <div class="tag-list" style="margin-top:.65rem;">
                        @foreach($newsItem->tags as $tag)
                            <a class="tag-chip" href="{{ route('news.index', ['tag' => $tag->slug]) }}">
                                <i class="fas fa-tag"></i> {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <a href="{{ route('news.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('Back') }}
            </a>
        </div>

        <div class="account-card">
            @if ($newsItem->image_path)
                <div class="news-hero">
                    <img src="{{ asset('storage/' . $newsItem->image_path) }}" alt="{{ $newsItem->title }}">
                </div>
            @endif

            <div class="card-body">
                <div class="news-content">{!! nl2br(e($newsItem->content)) !!}</div>
            </div>
        </div>

        @if (!isset($commentsEnabled) || $commentsEnabled)
        <div class="account-card comments-section">
            <div class="card-header">
                <h2><i class="fas fa-comments"></i> {{ __('Comments') }} @if(($newsItem->comments ?? collect())->count() > 0)<span class="comment-count">({{ $newsItem->comments->count() }})</span>@endif</h2>
            </div>
            <div class="card-body">
                @if (session('status') === 'comment-posted')
                    <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Comment posted.') }}</div>
                @endif
                @auth
                    <form method="POST" action="{{ route('news.comments.store', $newsItem) }}" class="comment-form">
                        @csrf
                        <div class="form-group form-group--full">
                            <label for="body">{{ __('Leave a comment') }}</label>
                            <textarea id="body" name="body" rows="4" required minlength="2" maxlength="2000" placeholder="{{ __('Share your thoughts...') }}">{{ old('body') }}</textarea>
                            @error('body')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> {{ __('Post Comment') }}
                        </button>
                    </form>
                    <hr class="section-divider">
                @else
                    <div class="login-prompt">
                        <i class="fas fa-lock"></i>
                        <p>{{ __('Please') }} <a href="{{ route('login') }}">{{ __('log in') }}</a> {{ __('to post a comment.') }}</p>
                    </div>
                @endauth

                @php
                    $approvedComments = ($newsItem->comments ?? collect())->where('is_approved', true);
                @endphp

                @if ($approvedComments->isEmpty())
                    <div class="empty-state">
                        <i class="far fa-comment-dots"></i>
                        <p>{{ __('No comments yet. Be the first!') }}</p>
                    </div>
                @else
                    <div class="comment-list">
                        @foreach($approvedComments as $c)
                            <div class="comment-item">
                                <div class="comment-header">
                                    <span class="comment-author">
                                        <i class="fas fa-user-circle"></i>
                                        @php
                                            $authorLabel = $c->user?->username ?? $c->user?->name ?? 'User';
                                        @endphp

                                        @if($c->user?->username)
                                            <a class="comment-author-link" href="{{ route('profiles.show', $c->user) }}" title="{{ __('View profile') }}">
                                                {{ $authorLabel }}
                                            </a>
                                        @else
                                            <span class="comment-author-name">{{ $authorLabel }}</span>
                                        @endif
                                    </span>
                                    <span class="comment-date">{{ $c->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="comment-body">{{ e($c->body) }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @else
        <div class="account-card comments-section">
            <div class="card-header">
                <h2><i class="fas fa-comments"></i> {{ __('Comments') }}</h2>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-0"><i class="fas fa-info-circle"></i> {{ __('Comments are currently disabled by the site administrator.') }}</div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
