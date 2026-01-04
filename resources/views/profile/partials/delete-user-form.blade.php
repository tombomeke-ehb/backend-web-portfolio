<section class="card-section">
    <header class="card-header">
        <h2><i class="fas fa-exclamation-triangle"></i> {{ __('Delete Account') }}</h2>
        <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
    </header>

    <div class="card-body">
        <button onclick="document.getElementById('deleteModal').style.display='flex'" class="btn btn-danger">
            <i class="fas fa-trash-alt"></i> {{ __('Delete Account') }}
        </button>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal-overlay" style="display: none;">
        <div class="modal-container">
            <div class="modal-header modal-header--danger">
                <h3><i class="fas fa-exclamation-circle"></i> {{ __('Confirm Account Deletion') }}</h3>
            </div>
            <div class="modal-body">
                <p>{{ __('This action cannot be undone. Please enter your password to confirm you would like to permanently delete your account.') }}</p>

                <form method="post" action="{{ route('profile.destroy') }}" id="deleteForm">
                    @csrf
                    @method('delete')

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" name="password" type="password" placeholder="{{ __('Enter your password') }}">
                        @if ($errors->userDeletion->has('password'))
                            <span class="form-error">{{ $errors->userDeletion->first('password') }}</span>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('deleteModal').style.display='none'" class="btn btn-secondary">
                    <i class="fas fa-times"></i> {{ __('Cancel') }}
                </button>
                <button type="submit" form="deleteForm" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> {{ __('Delete Forever') }}
                </button>
            </div>
        </div>
    </div>

    @if ($errors->userDeletion->isNotEmpty())
        <script>document.getElementById('deleteModal').style.display = 'flex';</script>
    @endif
</section>
