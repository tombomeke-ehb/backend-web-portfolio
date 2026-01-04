@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="far fa-question-circle"></i> {{ __('FAQ Categories') }}</h1>
            <p class="page-subtitle">{{ __('Manage FAQ categories') }}</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.faq.items.index') }}" class="btn btn-secondary">
                <i class="fas fa-question"></i> {{ __('Questions') }}
            </a>
            <a href="{{ route('admin.faq.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Create Category') }}
            </a>
        </div>
    </div>

    @if (session('status') === 'faq-category-created')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Category created.') }}</div>
    @elseif (session('status') === 'faq-category-updated')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Category updated.') }}</div>
    @elseif (session('status') === 'faq-category-deleted')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('Category deleted.') }}</div>
    @endif

    <div class="account-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th>{{ __('Sort') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td class="table-id">{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="table-username">{{ $category->slug }}</td>
                            <td class="table-id">{{ $category->sort_order }}</td>
                            <td class="table-actions">
                                <a class="btn btn-sm btn-secondary" href="{{ route('admin.faq.categories.edit', $category) }}">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.faq.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? (This will also delete its questions)')">
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

    @if ($categories->hasPages())
        <div class="pagination-wrapper">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
