<x-guest-layout>
    <div class="auth-form">
        <h2 class="auth-title">{{ __('Welcome Back') }}</h2>
        <p class="auth-subtitle">{{ __('Sign in to continue to your account') }}</p>

        @if (session('status'))
            <div class="auth-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email"
                       class="form-input"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="your@email.com"
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
                       placeholder="••••••••"
                       required
                       autocomplete="current-password">
                @error('password')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-checkbox-group">
                <input id="remember_me"
                       type="checkbox"
                       class="form-checkbox"
                       name="remember">
                <label for="remember_me" class="form-checkbox-label">
                    {{ __('Keep me signed in') }}
                </label>
            </div>

            <button type="submit" class="auth-button">
                <i class="fas fa-sign-in-alt"></i> {{ __('Sign In') }}
            </button>

            <div class="auth-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link">
                        <i class="fas fa-key"></i> {{ __('Forgot password?') }}
                    </a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="auth-link">
                        <i class="fas fa-user-plus"></i> {{ __('Create account') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</x-guest-layout>
