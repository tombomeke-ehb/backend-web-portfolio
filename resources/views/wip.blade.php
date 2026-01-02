@extends('layouts.app')

@section('content')
<section class="wip-section">
    <div class="container">
        <div class="wip-card">
            <div class="wip-badge" data-translate="wip_page_title">
                <i class="fas fa-wrench"></i>
                {{ __('wip_page_title') }}
            </div>

            <h1 data-translate="wip_heading">{{ __('wip_heading') }}</h1>
            <p class="wip-lead" data-translate="wip_intro">
                {{ str_replace('{page}', $pageLabel ?? __('wip_default_page_name'), __('wip_intro')) }}
            </p>
            <p class="wip-note" data-translate="wip_secondary">{{ __('wip_secondary') }}</p>

            <div class="wip-meta">
                <span class="wip-chip" data-translate="wip_status_badge">{{ __('wip_status_badge') }}</span>
                <span class="wip-chip">{{ $pageLabel ?? __('wip_default_page_name') }}</span>
            </div>

            <div class="wip-actions">
                <a href="{{ route('about') }}" class="btn btn-primary" data-translate="wip_back_home">
                    <i class="fas fa-home"></i> {{ __('wip_back_home') }}
                </a>
                <a href="{{ route('projects') }}" class="btn btn-secondary" data-translate="wip_view_projects">
                    <i class="fas fa-folder-open"></i> {{ __('wip_view_projects') }}
                </a>
            </div>

            <a class="wip-contact" href="{{ route('contact') }}" data-translate="wip_contact">
                <i class="fas fa-comment-dots"></i>
                {{ __('wip_contact') }}
            </a>

            <p class="wip-feedback" data-translate="wip_feedback">{{ __('wip_feedback') }}</p>
        </div>
    </div>
</section>
@endsection
