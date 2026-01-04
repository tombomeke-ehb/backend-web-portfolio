@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-edit"></i> {{ __('Edit Tag') }}</h1>
            <p class="page-subtitle">{{ __('Editing tag') }}: <span class="table-tag" style="font-size:0.9rem;">{{ $tag->name }}</span></p>
        </div>
        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="account-card">
        <section class="card-section">
            <form method="POST" action="{{ route('admin.tags.update', $tag) }}" class="card-body">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group form-group--full">
                        <label for="name">{{ __('Tag Name') }}</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $tag->name) }}" required>
                        @error('name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="slug">
                            {{ __('Slug') }}
                            <span class="label-hint">({{ __('optional, auto-generated from name') }})</span>
                        </label>
                        <input id="slug" name="slug" type="text" value="{{ old('slug', $tag->slug) }}">
                        <div class="form-hint"><i class="fas fa-info-circle"></i> {{ __('URL-friendly identifier. Leave empty to auto-generate.') }}</div>
                        @error('slug')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ __('Update Tag') }}
                    </button>
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
