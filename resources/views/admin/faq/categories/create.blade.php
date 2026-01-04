@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="far fa-question-circle"></i> {{ __('Create FAQ Category') }}</h1>
            <p class="page-subtitle">{{ __('Add a new FAQ category') }}</p>
        </div>
        <a href="{{ route('admin.faq.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="account-card">
        <section class="card-section">
            <form method="POST" action="{{ route('admin.faq.categories.store') }}" class="card-body">
                @csrf

                <div class="form-grid">
                    <div class="form-group form-group--full">
                        <label for="name_nl">{{ __('Name (NL)') }}</label>
                        <input id="name_nl" name="name_nl" type="text" value="{{ old('name_nl') }}" required>
                        @error('name_nl')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="name_en">{{ __('Name (EN)') }}</label>
                        <input id="name_en" name="name_en" type="text" value="{{ old('name_en') }}" required>
                        @error('name_en')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input id="slug" name="slug" type="text" value="{{ old('slug') }}" placeholder="{{ __('auto from name if empty') }}">
                        @error('slug')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="sort_order">{{ __('Sort order') }}</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}">
                        @error('sort_order')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    <a href="{{ route('admin.faq.categories.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
