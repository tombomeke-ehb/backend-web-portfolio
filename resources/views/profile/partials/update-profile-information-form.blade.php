<section class="card-section">
    <header class="card-header">
        <h2><i class="fas fa-id-card"></i> {{ __('Profile Information') }}</h2>
        <p>{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="card-body">
        @csrf
        @method('patch')

        @if ($user->profile_photo_path)
            <div class="avatar-preview">
                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile photo">
                <div class="avatar-info">
                    <span class="avatar-label">{{ __('Current photo') }}</span>
                    <span class="avatar-filename">{{ basename($user->profile_photo_path) }}</span>
                </div>
            </div>
        @endif

        <div class="form-grid">
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">{{ __('Username') }}</label>
                <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" required autocomplete="username">
                @error('username')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <span class="form-hint"><i class="fas fa-link"></i> {{ url('/u/' . ($user->username ?? '...')) }}</span>
            </div>

            <div class="form-group form-group--full">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="verification-notice">
                        <p>
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="link-button">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="form-success">{{ __('A new verification link has been sent to your email address.') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="birthday">{{ __('Birthday') }}</label>
                <input id="birthday" name="birthday" type="date" value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}">
                @error('birthday')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="profile_photo">{{ __('Profile photo') }}</label>
                <input id="profile_photo" name="profile_photo" type="file" accept="image/*">
                <div class="form-hint" style="margin-top:.35rem;">
                    <i class="fas fa-info-circle"></i>
                    {{ __('Max 2MB. Allowed: JPG, PNG, WEBP. Tip: use a square image for best results.') }}
                </div>
                @error('profile_photo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-group--full">
                <label for="about">{{ __('About me') }}</label>
                <textarea id="about" name="about" rows="4">{{ old('about', $user->about) }}</textarea>
                @error('about')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save changes') }}</button>
            @if (session('status') === 'profile-updated')
                <span class="form-success"><i class="fas fa-check"></i> {{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
