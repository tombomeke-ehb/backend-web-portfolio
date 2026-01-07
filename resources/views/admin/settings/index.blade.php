@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    {{-- Debug bar verwijderd --}}
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-cog"></i> {{ __('Site Settings') }}</h1>
            <p class="page-subtitle">{{ __('Manage your website configuration') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        @forelse($settings as $group => $groupSettings)
            <div class="account-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-{{ $group === 'general' ? 'sliders-h' : ($group === 'contact' ? 'envelope' : ($group === 'social' ? 'share-alt' : ($group === 'features' ? 'toggle-on' : 'cog'))) }}"></i>
                        {{ __(ucfirst($group) . ' Settings') }}
                    </h2>
                </div>
                <div class="card-body">
                    <div class="settings-grid">
                        @foreach($groupSettings as $setting)
                            <div class="setting-item">
                                <div class="setting-info">
                                    <label for="{{ $setting->group }}_{{ $setting->key }}" class="setting-label">{{ $setting->label }}</label>
                                    @if($setting->description)
                                        <p class="setting-description">{{ $setting->description }}</p>
                                    @endif
                                </div>
                                <div class="setting-input">
                                    @if($setting->type === 'boolean')
                                        <label class="toggle-switch">
                                            <input type="checkbox"
                                                   id="{{ $setting->group }}_{{ $setting->key }}"
                                                   name="{{ $setting->key }}"
                                                   value="1"
                                                   {{ $setting->typed_value ? 'checked' : '' }}>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    @elseif($setting->type === 'text' || str_contains($setting->key, 'description'))
                                        <textarea id="{{ $setting->group }}_{{ $setting->key }}"
                                                  name="{{ $setting->key }}"
                                                  rows="3"
                                                  placeholder="{{ $setting->label }}">{{ $setting->value }}</textarea>
                                    @else
                                        <input type="{{ $setting->type === 'integer' ? 'number' : 'text' }}"
                                               id="{{ $setting->group }}_{{ $setting->key }}"
                                               name="{{ $setting->key }}"
                                               value="{{ $setting->value }}"
                                               placeholder="{{ $setting->label }}">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="account-card">
                <div class="card-body">
                    <div class="empty-state">
                        <i class="fas fa-cog"></i>
                        <p>{{ __('No settings configured yet.') }}</p>
                        <p class="text-muted">{{ __('Run the seeder to populate default settings.') }}</p>
                    </div>
                </div>
            </div>
        @endforelse

        @if($settings->count() > 0)
            <div class="form-actions" style="border-top: none; padding-top: 0;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('Save Settings') }}
                </button>
            </div>
        @endif
    </form>
</div>
@endsection
