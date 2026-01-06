<x-guest-layout>
    <div class="auth-form">
        <h2 class="auth-title">{{ __('Create Account') }}</h2>
        <p class="auth-subtitle">{{ __('Join us and start building amazing things') }}</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">{{ __('Full Name') }}</label>
                <input id="name"
                       class="form-input @error('name') error @enderror"
                       type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="John Doe"
                       required
                       autofocus
                       autocomplete="name">
                @error('name')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email"
                       class="form-input @error('email') error @enderror"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="your@email.com"
                       required
                       autocomplete="username">
                @error('email')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password"
                       class="form-input @error('password') error @enderror"
                       type="password"
                       name="password"
                       placeholder="••••••••"
                       required
                       autocomplete="new-password">
                @error('password')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation"
                       class="form-input @error('password_confirmation') error @enderror"
                       type="password"
                       name="password_confirmation"
                       placeholder="••••••••"
                       required
                       autocomplete="new-password">
                @error('password_confirmation')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="auth-button">
                <i class="fas fa-user-plus"></i> {{ __('Create Account') }}
            </button>

            <div class="auth-links">
                <a href="{{ route('login') }}" class="auth-link">
                    <i class="fas fa-sign-in-alt"></i> {{ __('Already have an account?') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
