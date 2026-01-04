@extends('layouts.guest')

@section('content')
<section class="auth-page">
    <div class="auth-card" style="max-width: 560px;">
        <div class="auth-form" style="text-align: center;">
            <h2 class="auth-title"><i class="fas fa-tools"></i> {{ __('Maintenance') }}</h2>
            <p class="auth-subtitle">{{ __('The website is currently in maintenance mode. Please try again later.') }}</p>

            <div class="auth-links" style="justify-content: center;">
                <a href="{{ route('login') }}" class="auth-link">
                    <i class="fas fa-sign-in-alt"></i> {{ __('Admin login') }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
