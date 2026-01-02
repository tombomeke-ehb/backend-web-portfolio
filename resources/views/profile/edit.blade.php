<x-app-layout>
    <div class="container" style="padding: 3rem 1rem;">
        <h1 class="auth-title" style="text-align: left;">{{ __('Profile') }}</h1>

        <div class="profile-section">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="profile-section">
            @include('profile.partials.update-password-form')
        </div>

        <div class="profile-section">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
