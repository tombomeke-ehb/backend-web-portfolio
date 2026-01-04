@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-inbox"></i> {{ __('Contact messages') }}</h1>
            <p class="page-subtitle">{{ __('Inbox for the contact form') }}</p>
        </div>
    </div>

    <div class="filter-row">
        <a class="btn btn-sm btn-secondary @if($filter === '' || $filter === 'all') active @endif" href="{{ route('admin.contact.index', ['filter' => 'all']) }}">{{ __('All') }}</a>
        <a class="btn btn-sm btn-secondary @if($filter === 'unread') active @endif" href="{{ route('admin.contact.index', ['filter' => 'unread']) }}">{{ __('Unread') }}</a>
        <a class="btn btn-sm btn-secondary @if($filter === 'replied') active @endif" href="{{ route('admin.contact.index', ['filter' => 'replied']) }}">{{ __('Replied') }}</a>
    </div>

    @if (session('status') === 'contact-replied')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Reply sent.') }}</div>
    @elseif (session('status') === 'contact-marked-unread')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Marked as unread.') }}</div>
    @endif

    <div class="account-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('From') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Subject') }}</th>
                        <th>{{ __('Received') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $m)
                        <tr class="{{ $m->read_at ? '' : 'row-unread' }}">
                            <td class="table-id">{{ $m->id }}</td>
                            <td><strong>{{ $m->name }}</strong></td>
                            <td class="table-username">{{ $m->email }}</td>
                            <td class="table-subject">{{ $m->subject }}</td>
                            <td class="table-date">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($m->replied_at)
                                    <span class="moderation-badge moderation-badge--approved">{{ __('Replied') }}</span>
                                @elseif ($m->read_at)
                                    <span class="badge badge--muted">{{ __('Read') }}</span>
                                @else
                                    <span class="moderation-badge moderation-badge--pending">{{ __('New') }}</span>
                                @endif
                            </td>
                            <td class="table-actions">
                                <a class="btn btn-sm btn-secondary" href="{{ route('admin.contact.show', $m) }}">
                                    <i class="fas fa-eye"></i> {{ __('View') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state empty-state--inbox">
                                    <i class="fas fa-inbox"></i>
                                    <p>{{ __('No messages found') }}</p>
                                    <span class="empty-hint">{{ __('Contact form submissions will appear here') }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($messages->hasPages())
        <div class="pagination-wrapper">{{ $messages->links() }}</div>
    @endif
</div>
@endsection
