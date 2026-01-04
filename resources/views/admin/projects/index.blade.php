@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-folder-open"></i> {{ __('Projects') }}</h1>
            <p class="page-subtitle">{{ __('Manage portfolio projects') }}</p>
        </div>
        <div class="page-header-actions" style="display:flex; gap:.5rem; align-items:center;">
            <form method="POST" action="{{ route('admin.projects.ensure-migration') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-database"></i> {{ __('Ensure DB tables') }}
                </button>
            </form>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('New Project') }}
            </a>
        </div>
    </div>

    <div class="account-card">
        <section class="card-section">
            <div class="card-body" style="padding-top: 0;">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>{{ __('Sort') }}</th>
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Updated') }}</th>
                                <th class="text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td>{{ $project->sort_order }}</td>
                                    <td><code>{{ $project->slug }}</code></td>
                                    <td>{{ $project->category }}</td>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->status ?? '-' }}</td>
                                    <td>{{ $project->updated_at?->format('Y-m-d') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-edit"></i> {{ __('Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" style="display:inline-block" onsubmit="return confirm('Delete this project?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="opacity:.75;">{{ __('No projects yet.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 1rem;">
                    {{ $projects->links() }}
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
