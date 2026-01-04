@extends('layouts.app')

@section('content')
<section class="account-page">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-cog"></i> {{ __('Settings') }}</h1>
            <p class="page-subtitle">{{ __('Manage your application preferences') }}</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="account-card">
            <section class="card-section">
                <header class="card-header">
                    <h2><i class="fas fa-sliders-h"></i> {{ __('Preferences') }}</h2>
                    <p>{{ __('Configure your app-wide settings here.') }}</p>
                </header>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="preferred_language">{{ __('Preferred language') }}</label>
                                <select id="preferred_language" name="preferred_language" class="form-control">
                                    <option value="nl" {{ ($user->preferred_language ?? 'nl') === 'nl' ? 'selected' : '' }}>Nederlands (NL)</option>
                                    <option value="en" {{ ($user->preferred_language ?? 'nl') === 'en' ? 'selected' : '' }}>English (EN)</option>
                                </select>
                                @error('preferred_language')
                                    <p class="text-danger" style="margin-top:.35rem;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="timezone">{{ __('Timezone') }}</label>
                                <input type="text" id="timezone" name="timezone" value="{{ old('timezone', $user->timezone) }}" placeholder="Europe/Brussels">
                                @error('timezone')
                                    <p class="text-danger" style="margin-top:.35rem;">{{ $message }}</p>
                                @enderror
                                <p class="text-muted" style="margin-top:.5rem;">{{ __('Example: Europe/Brussels') }}</p>
                            </div>

                            <div class="form-group form-group--full" style="display:flex; gap:1rem; flex-wrap:wrap;">
                                <label style="display:flex; align-items:center; gap:.6rem; text-transform:none; letter-spacing:0; font-weight:600;">
                                    <input type="checkbox" name="public_profile" value="1" {{ ($user->public_profile ?? true) ? 'checked' : '' }}>
                                    <span>{{ __('Public profile visible') }}</span>
                                </label>

                                <label style="display:flex; align-items:center; gap:.6rem; text-transform:none; letter-spacing:0; font-weight:600;">
                                    <input type="checkbox" name="email_notifications" value="1" {{ ($user->email_notifications ?? true) ? 'checked' : '' }}>
                                    <span>{{ __('Email notifications') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-actions" style="border-top: none; padding-top: 0;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Save Settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <div class="account-card">
            <section class="card-section">
                <header class="card-header">
                    <h2><i class="fas fa-tools"></i> {{ __('Skills') }}</h2>
                    <p>{{ __('Manage your public skills so others can see what you can do.') }}</p>
                </header>
                <div class="card-body">
                    <div class="settings-grid" style="margin-bottom:1rem;">
                        @forelse($user->skills()->orderByDesc('level')->orderBy('name')->get() as $skill)
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-label" style="display:flex; align-items:center; gap:.5rem;">
                                        <span>{{ $skill->name }}</span>
                                        <span class="badge badge--level">Lvl {{ $skill->level }}/5</span>
                                        @if($skill->category)
                                            <span class="badge" style="margin-left:auto;">{{ $skill->category }}</span>
                                        @endif
                                    </div>
                                    @if($skill->notes)
                                        <p class="setting-description">{{ $skill->notes }}</p>
                                    @endif
                                    <p class="text-muted" style="margin:.25rem 0 0;">{{ $skill->is_public ? __('Public') : __('Private') }}</p>
                                </div>

                                <div class="setting-input" style="display:flex; flex-direction:column; align-items:flex-end; gap:.5rem;">
                                    <form method="POST" action="{{ route('settings.skills.destroy', $skill) }}" onsubmit="return confirm('Delete this skill?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary" style="padding:.5rem .75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state" style="grid-column: 1 / -1;">
                                <i class="fas fa-tools"></i>
                                <p>{{ __('No skills yet.') }}</p>
                                <p class="text-muted">{{ __('Add a few skills so collaborators know what you can do.') }}</p>
                            </div>
                        @endforelse
                    </div>

                    <form method="POST" action="{{ route('settings.skills.store') }}">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="skill_name">{{ __('Skill name') }}</label>
                                <input id="skill_name" name="name" type="text" value="{{ old('name') }}" placeholder="Laravel">
                            </div>

                            <div class="form-group">
                                <label for="skill_level">{{ __('Level') }}</label>
                                <select id="skill_level" name="level">
                                    @for($i=1; $i<=5; $i++)
                                        <option value="{{ $i }}" {{ (int)old('level', 3) === $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="skill_category">{{ __('Category') }}</label>
                                <input id="skill_category" name="category" type="text" value="{{ old('category') }}" placeholder="backend / frontend / devops">
                            </div>

                            <div class="form-group">
                                <label for="skill_notes">{{ __('Notes') }}</label>
                                <input id="skill_notes" name="notes" type="text" value="{{ old('notes') }}" placeholder="e.g. APIs, auth, testing">
                            </div>

                            <div class="form-group form-group--full" style="display:flex; align-items:center; gap:.6rem;">
                                <input id="skill_is_public" type="checkbox" name="is_public" value="1" {{ old('is_public', '1') ? 'checked' : '' }}>
                                <label for="skill_is_public" class="checkbox-inline">{{ __('Show on public profile') }}</label>
                            </div>
                        </div>

                        <div class="form-actions" style="border-top: none; padding-top: 0;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add Skill') }}
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
