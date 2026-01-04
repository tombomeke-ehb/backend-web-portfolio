<x-guest-layout>
    <div class="auth-form">
        <h2 class="auth-title">{{ __('Forgot Password') }}</h2>
        <p class="auth-subtitle">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>

        @if (session('status'))
            <div class="auth-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email"
                       class="form-input"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus>
                @error('email')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="auth-button">
                {{ __('Email Password Reset Link') }}
            </button>

            <div class="auth-links">
                <a href="{{ route('login') }}" class="auth-link">
                    {{ __('Back to login') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
