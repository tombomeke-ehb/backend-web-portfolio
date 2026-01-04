@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-user-edit"></i> {{ __('Edit User') }}</h1>
            <p class="page-subtitle">{{ __('Editing user') }} #{{ $user->id }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="account-card">
        <section class="card-section">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="card-body">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
                        @error('name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="username">{{ __('Username') }}</label>
                        <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}">
                        @error('username')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin', $user->is_admin))>
                            <span>{{ __('Admin privileges') }}</span>
                        </label>
                    </div>
                </div>

                <hr class="form-divider">

                <div class="form-group">
                    <label for="password">{{ __('New Password') }} <span class="label-hint">({{ __('leave empty to keep current') }})</span></label>
                    <input id="password" name="password" type="password">
                    @error('password')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save Changes') }}</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
