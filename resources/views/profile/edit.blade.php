@extends('layouts.app')

@section('content')
<section class="account-page">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-user-circle"></i> {{ __('Profile') }}</h1>
            <p class="page-subtitle">{{ __('Manage your account information and preferences') }}</p>
        </div>

        <div class="account-card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="account-card">
            @include('profile.partials.update-password-form')
        </div>

        <div class="account-card account-card--danger">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</section>
@endsection
