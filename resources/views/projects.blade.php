{{--
  Source attribution:
  - Original portfolio page derived from https://tombomeke.com (author: Tom Dekoning).
  - Modified/adapted for this Laravel Backend Web course project.
--}}

@extends('layouts.app')

@section('content')
<section class="projects">
    <div class="container">
        <h1><i class="fas fa-folder-open"></i> <span data-translate="projects_title"></span></h1>
        <p class="section-intro" data-translate="projects_intro"></p>
        <p class="section-hint"><i class="fas fa-hand-pointer"></i> <span data-translate="projects_click_details"></span></p>

        <div class="project-filters">
            <button class="filter-btn active" data-filter="all">
                <i class="fas fa-th"></i> <span data-translate="projects_filter_all"></span>
            </button>
            <button class="filter-btn" data-filter="minecraft">
                <i class="fas fa-cube"></i> <span data-translate="projects_filter_minecraft"></span>
            </button>
            <button class="filter-btn" data-filter="web">
                <i class="fas fa-globe"></i> <span data-translate="projects_filter_web"></span>
            </button>
            <button class="filter-btn" data-filter="api">
                <i class="fas fa-code"></i> <span data-translate="projects_filter_api"></span>
            </button>
            <button class="filter-btn" data-filter="cli">
                <i class="fas fa-code"></i> <span data-translate="projects_filter_cli"></span>
            </button>
        </div>

        <div class="projects-grid">
            @foreach($projects as $project)
                @php
                    // If the project contains both languages (DB or fallback model), keep them for client-side switching
                    $titleNl = is_array($project['title'] ?? null) ? ($project['title']['nl'] ?? null) : null;
                    $titleEn = is_array($project['title'] ?? null) ? ($project['title']['en'] ?? null) : null;
                    $descNl = is_array($project['description'] ?? null) ? ($project['description']['nl'] ?? null) : null;
                    $descEn = is_array($project['description'] ?? null) ? ($project['description']['en'] ?? null) : null;

                    // Current server-rendered values (already language-specific in most cases)
                    $titleCurrent = is_string($project['title'] ?? null) ? $project['title'] : ($titleNl ?? $titleEn ?? '');
                    $descCurrent = is_string($project['description'] ?? null) ? $project['description'] : ($descNl ?? $descEn ?? '');

                    $modalPayload = $project;
                    if ($titleNl || $titleEn) {
                        $modalPayload['title'] = ['nl' => $titleNl ?? $titleCurrent, 'en' => $titleEn ?? $titleCurrent];
                    }
                    if ($descNl || $descEn) {
                        $modalPayload['description'] = ['nl' => $descNl ?? $descCurrent, 'en' => $descEn ?? $descCurrent];
                    }
                @endphp

                <div class="project-card"
                     data-category="{{ $project['category'] }}"
                     data-modal='@json($modalPayload)'
                     data-title-nl="{{ e($modalPayload['title']['nl'] ?? $titleCurrent) }}"
                     data-title-en="{{ e($modalPayload['title']['en'] ?? $titleCurrent) }}"
                     data-description-nl="{{ e($modalPayload['description']['nl'] ?? $descCurrent) }}"
                     data-description-en="{{ e($modalPayload['description']['en'] ?? $descCurrent) }}">

                    @if (!empty($project['image']))
                        <div class="project-image-wrapper">
                            <img src="{{ $project['image'] }}"
                                 alt="{{ $titleCurrent }}"
                                 class="project-image"
                                 data-fallback-src="{{ asset('images/placeholder.jpg') }}"
                                 onerror="this.src=this.dataset.fallbackSrc">
                            <div class="project-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    @endif

                    <div class="project-content">
                        <h3 class="project-title">{{ $titleCurrent }}</h3>
                        <p class="project-description">{{ $descCurrent }}</p>

                        <div class="tech-stack">
                            @foreach($project['tech'] as $tech)
                                <span class="tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>

                        <div class="project-links" onclick="event.stopPropagation()">
                            @if (!empty($project['repo_url']))
                                <a href="{{ $project['repo_url'] }}"
                                   target="_blank"
                                   class="btn btn-secondary"
                                   onclick="event.stopPropagation()">
                                    <i class="fab fa-github"></i> <span data-translate="projects_view_code"></span>
                                </a>
                            @endif

                            @if (!empty($project['demo_url']))
                                <a href="{{ $project['demo_url'] }}"
                                   target="_blank"
                                   class="btn btn-primary"
                                   onclick="event.stopPropagation()">
                                    <i class="fas fa-external-link-alt"></i> <span data-translate="projects_view_demo"></span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
