<section>
    <header>
        <h2 class="profile-section-title" style="color: var(--error-color);">
            {{ __('Delete Account') }}
        </h2>

        <p class="profile-section-description">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button onclick="document.getElementById('deleteModal').style.display='flex'" 
            class="auth-button" 
            style="background: var(--error-color); max-width: 200px;">
        {{ __('Delete Account') }}
    </button>

    <!-- Modal -->
    <div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); align-items: center; justify-content: center; z-index: 1000;">
        <div class="auth-container" style="margin: 0;">
            <div class="auth-form">
                <h2 class="auth-title" style="color: var(--error-color);">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="profile-section-description">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="form-group">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               class="form-input" 
                               placeholder="{{ __('Password') }}">
                        @if ($errors->userDeletion->has('password'))
                            <div class="auth-error">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>

                    <div class="profile-actions">
                        <button type="button" 
                                onclick="document.getElementById('deleteModal').style.display='none'" 
                                class="auth-button auth-button-secondary">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" 
                                class="auth-button" 
                                style="background: var(--error-color);">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->userDeletion->isNotEmpty())
        <script>
            document.getElementById('deleteModal').style.display = 'flex';
        </script>
    @endif
</section>
