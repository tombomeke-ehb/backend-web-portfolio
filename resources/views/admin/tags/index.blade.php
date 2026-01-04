@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-tags"></i> {{ __('Tags') }}</h1>
            <p class="page-subtitle">{{ __('Manage tags for news articles') }}</p>
        </div>
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('New Tag') }}
        </a>
    </div>

    @if (session('status') === 'tag-created')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Tag created successfully.') }}</div>
    @elseif (session('status') === 'tag-updated')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Tag updated successfully.') }}</div>
    @elseif (session('status') === 'tag-deleted')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Tag deleted.') }}</div>
    @endif

    <div class="account-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:60px">ID</th>
                        <th>{{ __('Tag') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th style="width:100px">{{ __('Usage') }}</th>
                        <th style="width:160px">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tags as $tag)
                        @php
                            $deleteConfirm = __('Delete this tag? It will be removed from all news articles.');
                        @endphp
                        <tr>
                            <td class="table-id">{{ $tag->id }}</td>
                            <td>
                                <span class="table-tag">{{ $tag->name }}</span>
                            </td>
                            <td class="table-username">{{ $tag->slug }}</td>
                            <td>
                                <span class="tag-usage-count">
                                    <i class="far fa-newspaper"></i>
                                    {{ $tag->news_items_count ?? $tag->newsItems()->count() }}
                                </span>
                            </td>
                            <td class="table-actions">
                                <a class="btn btn-sm btn-secondary" href="{{ route('admin.tags.edit', $tag) }}">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" onsubmit="return confirm('{{ addslashes($deleteConfirm) }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" aria-label="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state empty-state--inbox">
                                    <i class="fas fa-tags"></i>
                                    <p>{{ __('No tags created yet') }}</p>
                                    <span class="empty-hint">{{ __('Create your first tag to organize news articles') }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($tags->hasPages())
        <div class="pagination-wrapper">{{ $tags->links() }}</div>
    @endif
</div>
@endsection
