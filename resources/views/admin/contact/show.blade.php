@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-envelope-open-text"></i> {{ __('Contact message') }} #{{ $message->id }}</h1>
            <p class="page-subtitle">{{ __('Received') }} {{ $message->created_at->diffForHumans() }}</p>
        </div>
        <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    @if (session('status') === 'contact-replied')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Reply sent successfully.') }}</div>
    @elseif (session('status') === 'contact-marked-unread')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Marked as unread.') }}</div>
    @endif

    <div class="account-card">
        <div class="card-body">
            <div class="message-meta">
                <div class="message-meta-item">
                    <span class="message-meta-label">{{ __('From') }}</span>
                    <span class="message-meta-value">{{ e($message->name) }}</span>
                </div>
                <div class="message-meta-item">
                    <span class="message-meta-label">{{ __('Email') }}</span>
                    <span class="message-meta-value">
                        <a href="mailto:{{ e($message->email) }}">{{ e($message->email) }}</a>
                    </span>
                </div>
                <div class="message-meta-item">
                    <span class="message-meta-label">{{ __('Received') }}</span>
                    <span class="message-meta-value">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            @if ($message->subject)
                <div class="message-subject">
                    <i class="fas fa-tag"></i> {{ e($message->subject) }}
                </div>
            @endif

            <div class="message-block">{{ e($message->message) }}</div>

            <div class="message-status-bar">
                <div>
                    @if ($message->replied_at)
                        <span class="moderation-badge moderation-badge--approved">
                            {{ __('Replied') }} — {{ $message->replied_at->format('d/m/Y H:i') }}
                        </span>
                    @elseif ($message->read_at)
                        <span class="badge badge--muted">
                            {{ __('Read') }} — {{ $message->read_at->format('d/m/Y H:i') }}
                        </span>
                    @else
                        <span class="moderation-badge moderation-badge--pending">{{ __('Unread') }}</span>
                    @endif
                </div>
                <div class="message-actions">
                    <form method="POST" action="{{ route('admin.contact.markUnread', $message) }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">
                            <i class="fas fa-envelope"></i> {{ __('Mark unread') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="account-card reply-card">
        <div class="card-header">
            <h2><i class="fas fa-reply"></i> {{ __('Reply') }}</h2>
        </div>
        <div class="card-body">
            @if ($message->admin_reply && $message->replied_at)
                <div class="previous-reply">
                    <div class="previous-reply-header">
                        <strong><i class="fas fa-check-circle"></i> {{ __('Previous Reply') }}</strong>
                        <time>{{ $message->replied_at->format('d/m/Y H:i') }}</time>
                    </div>
                    <div class="previous-reply-body">{{ e($message->admin_reply) }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.contact.reply', $message) }}">
                @csrf

                <div class="form-group form-group--full">
                    <label for="reply">{{ __('Your reply') }}</label>
                    <textarea id="reply" name="reply" rows="7" required placeholder="{{ __('Type your reply here...') }}">{{ old('reply') }}</textarea>
                    @error('reply')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> {{ __('Send reply') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
