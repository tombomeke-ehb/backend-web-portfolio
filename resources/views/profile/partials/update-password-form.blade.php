<section class="card-section">
    <header class="card-header">
        <h2><i class="fas fa-lock"></i> {{ __('Update Password') }}</h2>
        <p>{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="card-body">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" placeholder="••••••••">
            @if ($errors->updatePassword->has('current_password'))
                <span class="form-error">{{ $errors->updatePassword->first('current_password') }}</span>
            @endif
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="update_password_password">{{ __('New Password') }}</label>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password" placeholder="••••••••">
                @if ($errors->updatePassword->has('password'))
                    <span class="form-error">{{ $errors->updatePassword->first('password') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="••••••••">
                @if ($errors->updatePassword->has('password_confirmation'))
                    <span class="form-error">{{ $errors->updatePassword->first('password_confirmation') }}</span>
                @endif
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> {{ __('Update Password') }}</button>
            @if (session('status') === 'password-updated')
                <span class="form-success"><i class="fas fa-check"></i> {{ __('Password updated.') }}</span>
            @endif
        </div>
    </form>
</section>
