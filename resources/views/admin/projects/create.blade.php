@extends('layouts.admin')

@section('admin-content')
<div class="admin-content-page admin-content-page--narrow">
    <div class="page-header">
        <div class="page-header-content">
            <h1><i class="fas fa-plus-circle"></i> {{ __('Create Project') }}</h1>
            <p class="page-subtitle">{{ __('Add a new portfolio project (NL + EN)') }}</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="account-card">
        <section class="card-section">
            <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="card-body">
                @csrf
                @php($project = null)
                @include('admin.projects._form', ['project' => $project])

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
