@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-history"></i> {{ __('Activity Log') }}</h1>
            <p class="page-subtitle">{{ __('Track all admin actions and system events') }}</p>
        </div>
        <div class="page-header-actions">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('clearModal').classList.add('active')">
                <i class="fas fa-trash-alt"></i> {{ __('Clear Old Logs') }}
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Filters --}}
    <div class="account-card" style="margin-bottom: 1.5rem;">
        <div class="card-body" style="padding: 1rem 1.5rem;">
            <form method="GET" class="filter-form">
                <div class="filter-row-inline">
                    <div class="filter-group">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search description...') }}" class="filter-input">
                    </div>
                    <div class="filter-group">
                        <select name="action" class="filter-input">
                            <option value="">{{ __('All Actions') }}</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-filter"></i> {{ __('Filter') }}
                    </button>
                    @if(request()->hasAny(['search', 'action', 'user_id', 'model']))
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-times"></i> {{ __('Clear') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="account-card">
        <div class="table-header">
            <span class="table-count">{{ $logs->total() }} {{ __('entries') }}</span>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 140px;">{{ __('Time') }}</th>
                        <th style="width: 100px;">{{ __('Action') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th style="width: 140px;">{{ __('User') }}</th>
                        <th style="width: 120px;">{{ __('IP') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="table-date">
                                <span title="{{ $log->created_at->format('d M Y H:i:s') }}">
                                    {{ $log->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge--{{ $log->action_color }}">
                                    <i class="{{ $log->action_icon }}"></i>
                                    {{ $log->action_label }}
                                </span>
                            </td>
                            <td>
                                {{ $log->description }}
                                @if($log->model_type)
                                    <div class="log-model-info">
                                        <small class="text-muted">
                                            {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                        </small>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($log->user)
                                    <span class="table-username">{{ $log->user->username ?? $log->user->name }}</span>
                                @else
                                    <span class="text-muted">{{ __('System') }}</span>
                                @endif
                            </td>
                            <td>
                                <code class="ip-address">{{ $log->ip_address ?? '-' }}</code>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-history"></i>
                                    <p>{{ __('No activity logs found') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrapper">
        {{ $logs->links() }}
    </div>
</div>

{{-- Clear Modal --}}
<div id="clearModal" class="modal-overlay" onclick="if(event.target === this) this.classList.remove('active')">
    <div class="modal-container">
        <div class="modal-header modal-header--danger">
            <h3><i class="fas fa-trash-alt"></i> {{ __('Clear Old Logs') }}</h3>
        </div>
        <form method="POST" action="{{ route('admin.activity-logs.clear') }}">
            @csrf
            <div class="modal-body">
                <p>{{ __('This will permanently delete activity log entries older than the specified number of days.') }}</p>
                <div class="form-group">
                    <label for="older_than">{{ __('Delete logs older than (days)') }}</label>
                    <input type="number" id="older_than" name="older_than" value="30" min="1" max="365" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('clearModal').classList.remove('active')">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> {{ __('Clear Logs') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
