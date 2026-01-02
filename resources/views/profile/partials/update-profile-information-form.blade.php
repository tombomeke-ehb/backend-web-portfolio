<section>
    <header>
        <h2 class="profile-section-title">
            {{ __('Profile Information') }}
        </h2>

        <p class="profile-section-description">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" 
                   name="name" 
                   type="text" 
                   class="form-input" 
                   value="{{ old('name', $user->name) }}" 
                   required 
                   autofocus 
                   autocomplete="name">
            @error('name')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" 
                   name="email" 
                   type="email" 
                   class="form-input" 
                   value="{{ old('email', $user->email) }}" 
                   required 
                   autocomplete="username">
            @error('email')
                <div class="auth-error">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 1rem;">
                    <p class="profile-section-description">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="auth-link" style="border: none; background: none; cursor: pointer; padding: 0;">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="auth-status" style="margin-top: 0.5rem;">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="profile-actions">
            <button type="submit" class="auth-button">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p class="auth-status">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
