@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <h1><i class="fas fa-tachometer-alt"></i> {{ __('admin.Dashboard') }}</h1>
    <p>{{ __('admin.Welcome back') }}, {{ is_array(auth()->user()->name) ? 'User' : auth()->user()->name }}!</p>
</div>

{{-- Stats Grid --}}
<div class="admin-stats">
    <div class="stat-card">
        <div class="stat-card-icon stat-card-icon--primary">
            <i class="far fa-newspaper"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-value">{{ \App\Models\NewsItem::count() }}</div>
            <div class="stat-card-label">{{ __('admin.News Articles') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon stat-card-icon--success">
            <i class="fas fa-comments"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-value">{{ \App\Models\NewsComment::where('is_approved', true)->count() }}</div>
            <div class="stat-card-label">{{ __('admin.Comments') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon stat-card-icon--warning">
            <i class="fas fa-inbox"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-value">{{ \App\Models\ContactMessage::count() }}</div>
            <div class="stat-card-label">{{ __('admin.Messages') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon stat-card-icon--danger">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-card-value">{{ \App\Models\User::count() }}</div>
            <div class="stat-card-label">{{ __('admin.Users') }}</div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="quick-actions-bar">
    <h3><i class="fas fa-bolt"></i> {{ __('admin.Quick Actions') }}</h3>
    <div class="quick-actions-grid">
        <a href="{{ route('admin.news.create') }}" class="quick-action-card">
            <div class="quick-action-icon quick-action-icon--primary">
                <i class="fas fa-plus"></i>
            </div>
            <span>{{ __('admin.New Article') }}</span>
        </a>
        <a href="{{ route('admin.users.create') }}" class="quick-action-card">
            <div class="quick-action-icon quick-action-icon--success">
                <i class="fas fa-user-plus"></i>
            </div>
            <span>{{ __('admin.Add User') }}</span>
        </a>
        <a href="{{ route('admin.faq.items.create') }}" class="quick-action-card">
            <div class="quick-action-icon quick-action-icon--warning">
                <i class="fas fa-question"></i>
            </div>
            <span>{{ __('admin.Add FAQ') }}</span>
        </a>
        <a href="{{ route('admin.tags.create') }}" class="quick-action-card">
            <div class="quick-action-icon quick-action-icon--info">
                <i class="fas fa-tag"></i>
            </div>
            <span>{{ __('admin.New Tag') }}</span>
        </a>
    </div>
</div>

{{-- Main Grid --}}
<div class="admin-grid">
    {{-- Pending Comments --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2><i class="fas fa-clock"></i> {{ __('admin.Pending Comments') }}</h2>
            <a href="{{ route('admin.news-comments.index') }}" class="btn btn-sm btn-secondary">{{ __('admin.View all') }}</a>
        </div>
        <div class="admin-card-body">
            @php $pendingCommentsList = \App\Models\NewsComment::where('is_approved', false)->with(['user', 'newsItem.translations'])->latest()->take(5)->get(); @endphp
            @forelse($pendingCommentsList as $comment)
                <div class="activity-item">
                    <div class="activity-icon activity-icon--warning">
                        <i class="fas fa-comment"></i>
                    </div>
                    <div class="activity-content">
                        <p><strong>{{ $comment->user?->username ?? $comment->user?->name ?? 'Guest' }}</strong> {{ __('admin.commented on') }} <a href="{{ route('news.show', $comment->newsItem) }}">{{ Str::limit($comment->newsItem->title, 30) }}</a></p>
                        <span class="activity-time">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-state-small">
                    <i class="fas fa-check-circle"></i>
                    <p>{{ __('admin.No pending comments') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2><i class="fas fa-envelope"></i> {{ __('admin.Recent Messages') }}</h2>
            <a href="{{ route('admin.contact.index') }}" class="btn btn-sm btn-secondary">{{ __('admin.View all') }}</a>
        </div>
        <div class="admin-card-body">
            @php $recentMessages = \App\Models\ContactMessage::latest()->take(5)->get(); @endphp
            @forelse($recentMessages as $msg)
                <div class="activity-item {{ !$msg->read_at ? 'activity-item--unread' : '' }}">
                    <div class="activity-icon {{ $msg->replied_at ? 'activity-icon--success' : (!$msg->read_at ? 'activity-icon--warning' : '') }}">
                        <i class="fas fa-envelope{{ $msg->read_at ? '-open' : '' }}"></i>
                    </div>
                    <div class="activity-content">
                        <p><strong>{{ $msg->name }}</strong>: {{ Str::limit($msg->subject ?? $msg->message, 40) }}</p>
                        <span class="activity-time">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ route('admin.contact.show', $msg) }}" class="activity-action">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @empty
                <div class="empty-state-small">
                    <i class="fas fa-inbox"></i>
                    <p>{{ __('admin.No messages yet') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Second Row Grid --}}
<div class="admin-grid" style="margin-top: 1.5rem;">
    {{-- Recent Activity --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2><i class="fas fa-history"></i> {{ __('admin.Recent Activity') }}</h2>
            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-sm btn-secondary">{{ __('admin.View all') }}</a>
        </div>
        <div class="admin-card-body">
            @php $recentLogs = \App\Models\ActivityLog::with('user')->latest()->take(6)->get(); @endphp
            @forelse($recentLogs as $log)
                <div class="activity-item">
                    <div class="activity-icon activity-icon--{{ $log->action_color }}">
                        <i class="{{ $log->action_icon }}"></i>
                    </div>
                    <div class="activity-content">
                        <p>
                            @if($log->user)
                                <strong>{{ $log->user->username ?? $log->user->name }}</strong>
                            @else
                                <strong>{{ __('admin.System') }}</strong>
                            @endif
                            {{ Str::limit($log->description, 45) }}
                        </p>
                        <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-state-small">
                    <i class="fas fa-history"></i>
                    <p>{{ __('admin.No activity yet') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Latest News --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h2><i class="far fa-newspaper"></i> {{ __('admin.Latest News') }}</h2>
            <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-secondary">{{ __('admin.View all') }}</a>
        </div>
        <div class="admin-card-body">
            @php $latestNews = \App\Models\NewsItem::with(['tags', 'translations'])->latest()->take(5)->get(); @endphp
            @forelse($latestNews as $news)
                <div class="activity-item">
                    <div class="activity-icon activity-icon--primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="activity-content">
                        <p><a href="{{ route('news.show', $news) }}"><strong>{{ Str::limit($news->title, 40) }}</strong></a></p>
                        <div class="activity-meta">
                            <span class="activity-time">{{ $news->created_at->diffForHumans() }}</span>
                            @if($news->tags->count() > 0)
                                <span class="activity-tags">
                                    @foreach($news->tags->take(2) as $tag)
                                        <span class="mini-tag">{{ $tag->name }}</span>
                                    @endforeach
                                </span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('admin.news.edit', $news) }}" class="activity-action" title="{{ __('admin.Edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            @empty
                <div class="empty-state-small">
                    <i class="far fa-newspaper"></i>
                    <p>{{ __('admin.No news articles yet') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Third Row: System Overview --}}
<div class="admin-grid admin-grid--thirds" style="margin-top: 1.5rem;">
    {{-- Popular Tags --}}
    <div class="admin-card admin-card--compact">
        <div class="admin-card-header">
            <h2><i class="fas fa-tags"></i> {{ __('admin.Popular Tags') }}</h2>
        </div>
        <div class="admin-card-body">
            @php
                $popularTags = \App\Models\Tag::withCount('newsItems')
                    ->orderByDesc('news_items_count')
                    ->take(8)
                    ->get();
            @endphp
            @if($popularTags->count() > 0)
                <div class="tag-cloud">
                    @foreach($popularTags as $tag)
                        <a href="{{ route('admin.tags.edit', $tag) }}" class="tag-cloud-item" title="{{ $tag->news_items_count }} {{ __('admin.articles') }}">
                            <span class="tag-name"># {{ $tag->name }}</span>
                            <span class="tag-count">{{ $tag->news_items_count }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state-small">
                    <i class="fas fa-tags"></i>
                    <p>{{ __('admin.No tags yet') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Recent Users --}}
    <div class="admin-card admin-card--compact">
        <div class="admin-card-header">
            <h2><i class="fas fa-user-clock"></i> {{ __('admin.Recent Users') }}</h2>
        </div>
        <div class="admin-card-body">
            @php $recentUsers = \App\Models\User::latest()->take(5)->get(); @endphp
            <div class="user-list-compact">
                @foreach($recentUsers as $user)
                    <div class="user-list-item">
                        <div class="user-avatar-small">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <div class="user-info-compact">
                            <span class="user-name">{{ $user->name }}</span>
                            <span class="user-meta">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                        @if($user->is_admin)
                            <span class="badge badge--admin badge--sm">Admin</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- System Info --}}
    <div class="admin-card admin-card--compact">
        <div class="admin-card-header">
            <h2><i class="fas fa-server"></i> {{ __('admin.System Info') }}</h2>
        </div>
        <div class="admin-card-body">
            <div class="system-info-list">
                <div class="system-info-item">
                    <span class="system-info-label"><i class="fab fa-laravel"></i> Laravel</span>
                    <span class="system-info-value">{{ app()->version() }}</span>
                </div>
                <div class="system-info-item">
                    <span class="system-info-label"><i class="fab fa-php"></i> PHP</span>
                    <span class="system-info-value">{{ phpversion() }}</span>
                </div>
                <div class="system-info-item">
                    <span class="system-info-label"><i class="fas fa-database"></i> {{ __('admin.Database') }}</span>
                    <span class="system-info-value">{{ ucfirst(config('database.default')) }}</span>
                </div>
                <div class="system-info-item">
                    <span class="system-info-label"><i class="fas fa-clock"></i> {{ __('admin.Server Time') }}</span>
                    <span class="system-info-value">{{ now()->format('H:i') }}</span>
                </div>
                <div class="system-info-item">
                    <span class="system-info-label"><i class="fas fa-hdd"></i> {{ __('admin.Storage') }}</span>
                    <span class="system-info-value">
                        @php
                            $storageUsed = 0;
                            $storagePath = storage_path('app/public');
                            if (is_dir($storagePath)) {
                                $size = 0;
                                foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($storagePath, \RecursiveDirectoryIterator::SKIP_DOTS)) as $file) {
                                    $size += $file->getSize();
                                }
                                $storageUsed = $size;
                            }
                        @endphp
                        {{ number_format($storageUsed / 1024 / 1024, 2) }} MB
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Content Stats Bar --}}
<div class="content-stats-bar" style="margin-top: 1.5rem;">
    <div class="content-stat">
        <i class="fas fa-question-circle"></i>
        <div class="content-stat-info">
            <span class="content-stat-value">{{ \App\Models\FaqCategory::count() }}</span>
            <span class="content-stat-label">{{ __('admin.FAQ Categories') }}</span>
        </div>
    </div>
    <div class="content-stat">
        <i class="fas fa-list-ul"></i>
        <div class="content-stat-info">
            <span class="content-stat-value">{{ \App\Models\FaqItem::count() }}</span>
            <span class="content-stat-label">{{ __('admin.FAQ Items') }}</span>
        </div>
    </div>
    <div class="content-stat">
        <i class="fas fa-tags"></i>
        <div class="content-stat-info">
            <span class="content-stat-value">{{ \App\Models\Tag::count() }}</span>
            <span class="content-stat-label">{{ __('admin.Tags') }}</span>
        </div>
    </div>
    <div class="content-stat">
        <i class="fas fa-eye"></i>
        <div class="content-stat-info">
            <span class="content-stat-value">{{ \App\Models\NewsComment::where('is_approved', false)->count() }}</span>
            <span class="content-stat-label">{{ __('admin.Pending Review') }}</span>
        </div>
    </div>
    <div class="content-stat">
        <i class="fas fa-envelope-open-text"></i>
        <div class="content-stat-info">
            <span class="content-stat-value">{{ \App\Models\ContactMessage::whereNull('read_at')->count() }}</span>
            <span class="content-stat-label">{{ __('admin.Unread Messages') }}</span>
        </div>
    </div>
</div>
@endsection
