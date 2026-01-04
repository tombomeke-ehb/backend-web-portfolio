@php
    $tNl = $project?->translations?->firstWhere('lang', 'nl');
    $tEn = $project?->translations?->firstWhere('lang', 'en');
@endphp

<div class="form-grid">
    <div class="form-group form-group--full">
        <label for="slug">{{ __('Slug') }}</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $project->slug ?? '') }}" required>
        <div class="form-hint">{{ __('Unique identifier (letters, numbers, dashes).') }}</div>
        @error('slug')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <label for="category">{{ __('Category') }}</label>
        <select id="category" name="category" required>
            @php $cat = old('category', $project->category ?? 'web'); @endphp
            @foreach(['minecraft','web','api','cli'] as $c)
                <option value="{{ $c }}" @selected($cat === $c)>{{ strtoupper($c) }}</option>
            @endforeach
        </select>
        @error('category')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <label for="status">{{ __('Status') }}</label>
        @php $st = old('status', $project->status ?? 'active'); @endphp
        <select id="status" name="status">
            @foreach(['active','completed','development'] as $s)
                <option value="{{ $s }}" @selected($st === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        @error('status')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <label for="repo_url">{{ __('GitHub URL') }}</label>
        <input id="repo_url" name="repo_url" type="url" value="{{ old('repo_url', $project->repo_url ?? '') }}">
        @error('repo_url')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <label for="demo_url">{{ __('Demo URL') }}</label>
        <input id="demo_url" name="demo_url" type="url" value="{{ old('demo_url', $project->demo_url ?? '') }}">
        @error('demo_url')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <label for="tech">{{ __('Tech stack') }}</label>
        <textarea id="tech" name="tech" rows="3" placeholder="PHP, Laravel, JS, ...">{{ old('tech', isset($project) ? implode("\n", ($project->tech ?? [])) : '') }}</textarea>
        <div class="form-hint">{{ __('One per line (or comma-separated).') }}</div>
        @error('tech')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <label for="sort_order">{{ __('Sort order') }}</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $project->sort_order ?? 0) }}">
        @error('sort_order')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <label for="image">{{ __('Screenshot') }}</label>
        <input id="image" name="image" type="file" accept="image/*">
        @error('image')<span class="form-error">{{ $message }}</span>@enderror

        @if(!empty($project?->image_path))
            <div class="form-hint" style="margin-top:.75rem; gap:.75rem; font-family:inherit;">
                <i class="far fa-image"></i>
                <span>{{ __('Current image:') }} {{ basename($project->image_path) }}</span>
            </div>

            <label class="checkbox-label" style="margin-top:.75rem;">
                <input type="checkbox" name="remove_image" value="1">
                <span>{{ __('Remove current image') }}</span>
            </label>
        @endif
    </div>

    <div class="form-group form-group--full">
        <hr style="opacity:.25; margin: .5rem 0 0;" />
    </div>

    <div class="form-group form-group--full">
        <label for="title_nl">{{ __('Title (NL)') }}</label>
        <input id="title_nl" name="title_nl" type="text" value="{{ old('title_nl', $tNl->title ?? '') }}" required>
        @error('title_nl')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <label for="description_nl">{{ __('Description (NL)') }}</label>
        <textarea id="description_nl" name="description_nl" rows="4" required>{{ old('description_nl', $tNl->description ?? '') }}</textarea>
        @error('description_nl')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <label for="long_description_nl">{{ __('Long description (NL)') }}</label>
        <textarea id="long_description_nl" name="long_description_nl" rows="4">{{ old('long_description_nl', $tNl->long_description ?? '') }}</textarea>
        @error('long_description_nl')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <label for="features_nl">{{ __('Features (NL)') }}</label>
        <textarea id="features_nl" name="features_nl" rows="5" placeholder="Feature 1\nFeature 2\n...">{{ old('features_nl', isset($tNl->features) ? implode("\n", $tNl->features) : '') }}</textarea>
        <div class="form-hint">{{ __('One feature per line.') }}</div>
        @error('features_nl')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <hr style="opacity:.25; margin: .5rem 0 0;" />
    </div>

    <div class="form-group form-group--full">
        <label for="title_en">{{ __('Title (EN)') }}</label>
        <input id="title_en" name="title_en" type="text" value="{{ old('title_en', $tEn->title ?? '') }}" required>
        @error('title_en')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <label for="description_en">{{ __('Description (EN)') }}</label>
        <textarea id="description_en" name="description_en" rows="4" required>{{ old('description_en', $tEn->description ?? '') }}</textarea>
        @error('description_en')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <label for="long_description_en">{{ __('Long description (EN)') }}</label>
        <textarea id="long_description_en" name="long_description_en" rows="4">{{ old('long_description_en', $tEn->long_description ?? '') }}</textarea>
        @error('long_description_en')<span class="form-error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group form-group--full">
        <label for="features_en">{{ __('Features (EN)') }}</label>
        <textarea id="features_en" name="features_en" rows="5" placeholder="Feature 1\nFeature 2\n...">{{ old('features_en', isset($tEn->features) ? implode("\n", $tEn->features) : '') }}</textarea>
        <div class="form-hint">{{ __('One feature per line.') }}</div>
        @error('features_en')<span class="form-error">{{ $message }}</span>@enderror
    </div>
</div>
