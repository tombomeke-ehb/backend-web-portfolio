@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="far fa-newspaper"></i> {{ __('News Management') }}</h1>
            <p class="page-subtitle">{{ __('Create, edit and publish news items') }}</p>
        </div>

        <div class="page-header-actions">
            <a href="{{ route('news.index') }}" class="btn btn-secondary" target="_blank" rel="noopener">
                <i class="fas fa-external-link-alt"></i> {{ __('View public list') }}
            </a>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Create News') }}
            </a>
        </div>
    </div>

    @if (session('status') === 'news-created')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('News item created.') }}</div>
    @elseif (session('status') === 'news-updated')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('News item updated.') }}</div>
    @elseif (session('status') === 'news-deleted')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('News item deleted.') }}</div>
    @endif

    <div class="account-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Published') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($newsItems as $item)
                        <tr>
                            <td class="table-id">{{ $item->id }}</td>
                            <td>
                                @if ($item->image_path)
                                    <img class="table-thumb" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}">
                                @else
                                    <div class="table-thumb table-thumb--empty" aria-label="No image">
                                        <i class="far fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->title }}</td>
                            <td>{{ optional($item->published_at)->format('d/m/Y H:i') ?? '—' }}</td>
                            <td class="table-actions">
                                <a class="btn btn-sm btn-secondary" href="{{ route('news.show', $item) }}" target="_blank" rel="noopener">
                                    <i class="fas fa-eye"></i> {{ __('Preview') }}
                                </a>
                                <a class="btn btn-sm btn-secondary" href="{{ route('admin.news.edit', $item) }}">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.news.destroy', $item) }}" onsubmit="return confirm('Delete this news item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" aria-label="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($newsItems->hasPages())
        <div class="pagination-wrapper">{{ $newsItems->links() }}</div>
    @endif
</div>
@endsection
