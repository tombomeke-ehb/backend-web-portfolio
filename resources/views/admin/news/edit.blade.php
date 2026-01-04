@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-edit"></i> {{ __('Edit News Item') }}</h1>
            <p class="page-subtitle">{{ __('Editing') }}: {{ $newsItem->title }}</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('news.show', $newsItem) }}" class="btn btn-secondary" target="_blank">
                <i class="fas fa-eye"></i> {{ __('Preview') }}
            </a>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('Back') }}
            </a>
        </div>
    </div>

    @php
        $tNl = $newsItem->translations?->firstWhere('lang', 'nl');
        $tEn = $newsItem->translations?->firstWhere('lang', 'en');
    @endphp

    <div class="account-card">
        <section class="card-section">
            <form method="POST" action="{{ route('admin.news.update', $newsItem) }}" enctype="multipart/form-data" class="card-body">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group form-group--full">
                        <label for="title_nl">{{ __('Title (NL)') }}</label>
                        <input id="title_nl" name="title_nl" type="text" value="{{ old('title_nl', $tNl->title ?? '') }}" required>
                        @error('title_nl')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="content_nl">{{ __('Content (NL)') }}</label>
                        <textarea id="content_nl" name="content_nl" rows="8" required>{{ old('content_nl', $tNl->content ?? '') }}</textarea>
                        @error('content_nl')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="title_en">{{ __('Title (EN)') }}</label>
                        <input id="title_en" name="title_en" type="text" value="{{ old('title_en', $tEn->title ?? '') }}" required>
                        @error('title_en')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="content_en">{{ __('Content (EN)') }}</label>
                        <textarea id="content_en" name="content_en" rows="8" required>{{ old('content_en', $tEn->content ?? '') }}</textarea>
                        @error('content_en')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="published_at">{{ __('Publication date') }}</label>
                        <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', optional($newsItem->published_at)->format('Y-m-d\TH:i')) }}">
                        @error('published_at')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="image">{{ __('Image') }}</label>
                        <input id="image" name="image" type="file" accept="image/*">
                        @error('image')<span class="form-error">{{ $message }}</span>@enderror

                        @if ($newsItem->image_path)
                            <div class="form-hint" style="margin-top:.75rem; gap:.75rem; font-family:inherit;">
                                <i class="far fa-image"></i>
                                <span>{{ __('Current image:') }} {{ basename($newsItem->image_path) }}</span>
                            </div>

                            <label class="checkbox-label" style="margin-top:.75rem;">
                                <input type="checkbox" name="remove_image" value="1">
                                <span>{{ __('Remove current image') }}</span>
                            </label>
                        @endif
                    </div>

                    <div class="form-group form-group--full">
                        <label for="tag_ids">
                            {{ __('Tags') }}
                            <span class="label-hint">({{ __('optional') }})</span>
                        </label>
                        @php
                            $selectedTagIds = collect(old('tag_ids', $newsItem->tags?->pluck('id')->all() ?? []))
                                ->map(fn($v) => (string)$v);
                        @endphp
                        <select id="tag_ids" name="tag_ids[]" multiple size="5" class="tag-multiselect">
                            @foreach(($tags ?? []) as $tag)
                                <option value="{{ $tag->id }}" @selected($selectedTagIds->contains((string)$tag->id))>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-hint"><i class="fas fa-info-circle"></i> {{ __('Hold Ctrl (Win) or Cmd (Mac) to select multiple.') }}</div>
                        @error('tag_ids')<span class="form-error">{{ $message }}</span>@enderror
                        @error('tag_ids.*')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
