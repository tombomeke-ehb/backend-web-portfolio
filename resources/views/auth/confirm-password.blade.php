<x-guest-layout>
    <div class="auth-form">
        <h2 class="auth-title">{{ __('Confirm Password') }}</h2>
        <p class="auth-subtitle">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" 
                       class="form-input" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password">
                @error('password')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="auth-button">
                {{ __('Confirm') }}
            </button>
        </form>
    </div>
</x-guest-layout>
