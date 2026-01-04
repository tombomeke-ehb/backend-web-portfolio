@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-edit"></i> {{ __('Edit Project') }}</h1>
            <p class="page-subtitle">{{ __('Editing') }}: {{ $project->title }}</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="account-card">
        <section class="card-section">
            <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="card-body">
                @csrf
                @method('PUT')

                @include('admin.projects._form', ['project' => $project])

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
