@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-question"></i> {{ __('Create FAQ Question') }}</h1>
            <p class="page-subtitle">{{ __('Add a new question and answer') }}</p>
        </div>
        <a href="{{ route('admin.faq.items.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="account-card">
        <section class="card-section">
            <form method="POST" action="{{ route('admin.faq.items.store') }}" class="card-body">
                @csrf

                <div class="form-grid">
                    <div class="form-group form-group--full">
                        <label for="faq_category_id">{{ __('Category') }}</label>
                        <select id="faq_category_id" name="faq_category_id" required>
                            <option value="" disabled @selected(old('faq_category_id') === null)>{{ __('Select a category') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string)old('faq_category_id') === (string)$category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('faq_category_id')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="question_nl">{{ __('Question (NL)') }}</label>
                        <input id="question_nl" name="question_nl" type="text" value="{{ old('question_nl') }}" required>
                        @error('question_nl')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="answer_nl">{{ __('Answer (NL)') }}</label>
                        <textarea id="answer_nl" name="answer_nl" rows="7" required>{{ old('answer_nl') }}</textarea>
                        @error('answer_nl')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="question_en">{{ __('Question (EN)') }}</label>
                        <input id="question_en" name="question_en" type="text" value="{{ old('question_en') }}" required>
                        @error('question_en')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="answer_en">{{ __('Answer (EN)') }}</label>
                        <textarea id="answer_en" name="answer_en" rows="7" required>{{ old('answer_en') }}</textarea>
                        @error('answer_en')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="sort_order">{{ __('Sort order') }}</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}">
                        @error('sort_order')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    <a href="{{ route('admin.faq.items.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
