<section>
    <header>
        <h2 class="profile-section-title">
            {{ __('Update Password') }}
        </h2>

        <p class="profile-section-description">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" 
                   name="current_password" 
                   type="password" 
                   class="form-input" 
                   autocomplete="current-password">
            @if ($errors->updatePassword->has('current_password'))
                <div class="auth-error">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input id="update_password_password" 
                   name="password" 
                   type="password" 
                   class="form-input" 
                   autocomplete="new-password">
            @if ($errors->updatePassword->has('password'))
                <div class="auth-error">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" 
                   name="password_confirmation" 
                   type="password" 
                   class="form-input" 
                   autocomplete="new-password">
            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="auth-error">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="profile-actions">
            <button type="submit" class="auth-button">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p class="auth-status">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
