@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-users-cog"></i> {{ __('User Management') }}</h1>
            <p class="page-subtitle">{{ __('Manage all registered users') }}</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> {{ __('Create User') }}
        </a>
    </div>

    @if (session('status') === 'user-created')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('User created successfully.') }}</div>
    @elseif (session('status') === 'user-updated')
        <div class="alert alert-success"><i class="fas fa-check"></i> {{ __('User updated successfully.') }}</div>
    @endif

    <div class="account-card">
        <div class="table-header">
            <span class="table-count">{{ $users->total() }} {{ __('users') }}</span>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Username') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td class="table-id">{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td class="table-username">{{ $u->username ?? '—' }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if ($u->is_admin)
                                    <span class="badge badge--admin"><i class="fas fa-shield-alt"></i> Admin</span>
                                @else
                                    <span class="badge badge--user">User</span>
                                @endif
                            </td>
                            <td>
                                <div class="quick-actions">
                                    @if($u->username)
                                        <a href="{{ route('profiles.show', $u) }}" class="quick-action-btn" target="_blank" rel="noopener" title="{{ __('View public profile') }}" aria-label="{{ __('View public profile') }}">
                                            <i class="fas fa-user"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.users.edit', $u) }}" class="quick-action-btn" title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($users->hasPages())
        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
