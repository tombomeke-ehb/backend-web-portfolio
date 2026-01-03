@extends('layouts.app')

@section('content')
<section class="account-page">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-cog"></i> {{ __('Settings') }}</h1>
            <p class="page-subtitle">{{ __('Manage your application preferences') }}</p>
        </div>

        <div class="account-card">
            <section class="card-section">
                <header class="card-header">
                    <h2><i class="fas fa-sliders-h"></i> {{ __('Preferences') }}</h2>
                    <p>{{ __('Configure your app-wide settings here.') }}</p>
                </header>
                <div class="card-body">
                    <p class="text-muted">{{ __('No settings available yet. Future options will appear here.') }}</p>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
