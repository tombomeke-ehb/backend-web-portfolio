<x-guest-layout>
    <div class="auth-form">
        <h2 class="auth-title">{{ __('Create Account') }}</h2>
        <p class="auth-subtitle">{{ __('Join us and start building amazing things') }}</p>

        @if(session('error'))
            <div class="auth-error mb-3">{{ session('error') }}</div>
        @endif
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
                       class="form-input"
                       type="password"
                       name="password"
                       placeholder="••••••••"
                       required
                       autocomplete="new-password">
                <div id="password-requirements" class="password-requirements">
                    <div class="requirement" id="req-length">
                        <span class="requirement-icon"></span>
                        <span class="requirement-text">At least 8 characters</span>
                    </div>
                    <div class="requirement" id="req-uppercase">
                        <span class="requirement-icon"></span>
                        <span class="requirement-text">One uppercase letter (A-Z)</span>
                    </div>
                    <div class="requirement" id="req-number">
                        <span class="requirement-icon"></span>
                        <span class="requirement-text">One number (0-9)</span>
                    </div>
                    <div class="requirement" id="req-special">
                        <span class="requirement-icon"></span>
                        <span class="requirement-text">One special character (!@#$%^&*)</span>
                    </div>
                </div>
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
                       placeholder="••••••••"
                       required
                       autocomplete="new-password">
                <div id="password-match" class="password-match"></div>
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

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const requirementsDiv = document.getElementById('password-requirements');
    const matchDiv = document.getElementById('password-match');

    const requirements = {
        length: { regex: /.{8,}/, id: 'req-length' },
        uppercase: { regex: /[A-Z]/, id: 'req-uppercase' },
        number: { regex: /[0-9]/, id: 'req-number' },
        special: { regex: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/, id: 'req-special' }
    };

    function validatePassword(password) {
        const results = {};
        let allMet = true;

        for (const [key, req] of Object.entries(requirements)) {
            const isMet = req.regex.test(password);
            results[key] = isMet;
            const element = document.getElementById(req.id);

            if (isMet) {
                element.classList.add('met');
                element.classList.remove('unmet');
            } else {
                element.classList.add('unmet');
                element.classList.remove('met');
            }

            if (!isMet) allMet = false;
        }

        return allMet;
    }

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;

        if (confirm.length === 0) {
            matchDiv.classList.remove('show');
            return;
        }

        matchDiv.classList.add('show');
        if (password === confirm) {
            matchDiv.textContent = '✓ Passwords match';
            matchDiv.classList.add('success');
            matchDiv.classList.remove('error');
        } else {
            matchDiv.textContent = '✕ Passwords do not match';
            matchDiv.classList.remove('success');
            matchDiv.classList.add('error');
        }
    }

    function updatePasswordInput() {
        passwordInput.classList.remove('error', 'valid');
        if (passwordInput.value.length > 0) {
            requirementsDiv.classList.add('show');
            const isValid = validatePassword(passwordInput.value);
            if (isValid) {
                passwordInput.classList.add('valid');
            } else {
                passwordInput.classList.add('error');
            }
        } else {
            requirementsDiv.classList.remove('show');
        }
        checkPasswordMatch();
    }
    passwordInput.addEventListener('input', updatePasswordInput);
    confirmInput.addEventListener('input', checkPasswordMatch);
});
</script>
</x-guest-layout>
