<x-guest-layout>
    <div class="auth-form">
        <h2 class="auth-title">{{ __('Verify Email') }}</h2>
        <p class="auth-subtitle">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="auth-status">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="auth-button">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <div class="auth-divider">
            <span class="auth-divider-text">{{ __('or') }}</span>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="auth-button auth-button-secondary">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
