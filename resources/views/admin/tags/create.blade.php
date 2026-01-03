@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-plus-circle"></i> {{ __('Create Tag') }}</h1>
            <p class="page-subtitle">{{ __('Add a new tag to organize news articles') }}</p>
        </div>
        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="account-card">
        <section class="card-section">
            <form method="POST" action="{{ route('admin.tags.store') }}" class="card-body">
                @csrf

                <div class="form-grid">
                    <div class="form-group form-group--full">
                        <label for="name">{{ __('Tag Name') }}</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="{{ __('e.g. Laravel, Tutorial, Update') }}">
                        @error('name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="slug">
                            {{ __('Slug') }}
                            <span class="label-hint">({{ __('optional, auto-generated from name') }})</span>
                        </label>
                        <input id="slug" name="slug" type="text" value="{{ old('slug') }}" placeholder="{{ __('e.g. laravel, tutorial, update') }}">
                        <div class="form-hint"><i class="fas fa-info-circle"></i> {{ __('URL-friendly identifier. Leave empty to auto-generate.') }}</div>
                        @error('slug')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ __('Create Tag') }}
                    </button>
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
