@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-comments"></i> {{ __('News Comments') }}</h1>
            <p class="page-subtitle">{{ __('Moderate and manage comments on news articles') }}</p>
        </div>
    </div>

    @if (session('status') === 'comment-approved')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Comment has been approved.') }}</div>
    @elseif (session('status') === 'comment-deleted')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Comment has been deleted.') }}</div>
    @endif

    <div class="account-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px">ID</th>
                        <th style="width:200px">{{ __('News Article') }}</th>
                        <th style="width:160px">{{ __('Author') }}</th>
                        <th>{{ __('Comment') }}</th>
                        <th style="width:130px">{{ __('Date') }}</th>
                        <th style="width:100px">{{ __('Status') }}</th>
                        <th style="width:140px">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $c)
                        @php $deleteConfirm = __('Delete this comment?'); @endphp
                        <tr class="{{ $c->is_approved ? 'comment-approved-row' : 'comment-pending-row' }}">
                            <td class="table-id">{{ $c->id }}</td>
                            <td>
                                <div class="table-news-link">
                                    <a href="{{ route('news.show', $c->newsItem) }}" target="_blank" rel="noopener">
                                        {{ \Illuminate\Support\Str::limit($c->newsItem->title, 35) }}
                                    </a>
                                    <small>#{{ $c->newsItem->id }}</small>
                                </div>
                            </td>
                            <td>
                                @php
                                    $label = $c->user?->username ?? $c->user?->name ?? __('Guest');
                                @endphp

                                @if($c->user?->username)
                                    <a href="{{ route('profiles.show', $c->user) }}" target="_blank" rel="noopener" class="table-user-link" title="{{ __('Open public profile') }}">
                                        <strong>{{ $label }}</strong>
                                        <i class="fas fa-external-link-alt" style="font-size:.75em; opacity:.7; margin-left:.25rem;"></i>
                                    </a>
                                @else
                                    <strong>{{ $label }}</strong>
                                @endif
                            </td>
                            <td>
                                <div class="comment-preview">{{ \Illuminate\Support\Str::limit($c->body, 120) }}</div>
                            </td>
                            <td class="table-date">{{ $c->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($c->is_approved)
                                    <span class="moderation-badge moderation-badge--approved">{{ __('Approved') }}</span>
                                @else
                                    <span class="moderation-badge moderation-badge--pending">{{ __('Pending') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="quick-actions">
                                    @if(!$c->is_approved)
                                        <form method="POST" action="{{ route('admin.news-comments.approve', $c) }}">
                                            @csrf
                                            <button class="quick-action-btn quick-action-btn--approve" type="submit" title="{{ __('Approve') }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.news-comments.destroy', $c) }}" onsubmit="return confirm('{{ addslashes($deleteConfirm) }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="quick-action-btn quick-action-btn--delete" type="submit" title="{{ __('Delete') }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state empty-state--inbox">
                                    <i class="far fa-comments"></i>
                                    <p>{{ __('No comments yet') }}</p>
                                    <span class="empty-hint">{{ __('Comments on news articles will appear here for moderation') }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($comments->hasPages())
        <div class="pagination-wrapper">{{ $comments->links() }}</div>
    @endif
</div>
@endsection
