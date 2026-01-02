<x-guest-layout>
    <div class="auth-form">
        <h2 class="auth-title">{{ __('Reset Password') }}</h2>
        <p class="auth-subtitle">{{ __('Enter your new password below') }}</p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" 
                       class="form-input" 
                       type="email" 
                       name="email" 
                       value="{{ old('email', $request->email) }}" 
                       required 
                       autofocus 
                       autocomplete="username">
                @error('email')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" 
                       class="form-input" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password">
                @error('password')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" 
                       class="form-input" 
                       type="password" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password">
                @error('password_confirmation')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="auth-button">
                {{ __('Reset Password') }}
            </button>
        </form>
    </div>
</x-guest-layout>
