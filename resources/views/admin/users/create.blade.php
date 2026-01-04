@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-user-plus"></i> {{ __('Create User') }}</h1>
            <p class="page-subtitle">{{ __('Add a new user to the system') }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="account-card">
        <section class="card-section">
            <form method="POST" action="{{ route('admin.users.store') }}" class="card-body">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                        @error('name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="username">{{ __('Username') }}</label>
                        <input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="e.g. john">
                        @error('username')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="email">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                        @error('email')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" name="password" type="password" required>
                        @error('password')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group form-group--full">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin'))>
                            <span>{{ __('Grant admin privileges') }}</span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('Create User') }}</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
