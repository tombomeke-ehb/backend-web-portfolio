@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-question"></i> {{ __('FAQ Questions') }}</h1>
            <p class="page-subtitle">{{ __('Manage FAQ questions and answers') }}</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.faq.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-folder"></i> {{ __('Categories') }}
            </a>
            <a href="{{ route('admin.faq.items.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Create Question') }}
            </a>
        </div>
    </div>

    @if (session('status') === 'faq-item-created')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Question created.') }}</div>
    @elseif (session('status') === 'faq-item-updated')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Question updated.') }}</div>
    @elseif (session('status') === 'faq-item-deleted')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Question deleted.') }}</div>
    @endif

    <div class="account-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Question') }}</th>
                        <th>{{ __('Sort') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="table-id">{{ $item->id }}</td>
                            <td>{{ $item->category?->name ?? '—' }}</td>
                            <td>{{ $item->question }}</td>
                            <td class="table-id">{{ $item->sort_order }}</td>
                            <td class="table-actions">
                                <a class="btn btn-sm btn-secondary" href="{{ route('admin.faq.items.edit', $item) }}">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.faq.items.destroy', $item) }}" onsubmit="return confirm('Delete this question?')">
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

    @if ($items->hasPages())
        <div class="pagination-wrapper">{{ $items->links() }}</div>
    @endif
</div>
@endsection
