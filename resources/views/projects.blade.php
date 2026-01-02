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
                <div class="project-card"
                     data-category="{{ $project['category'] }}"
                     data-modal="{{ isset($projectModel) ? $projectModel->getModalData($project) : e(json_encode($project)) }}">

                    @if (!empty($project['image']))
                        <div class="project-image-wrapper">
                            <img src="{{ $project['image'] }}"
                                 alt="{{ $project['title'] }}"
                                 class="project-image"
                                 onerror="this.onerror=null; this.src='{{ asset('images/projects/p1.png') }}';">
                            <div class="project-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    @endif

                    <div class="project-content">
                        <h3 data-translate="project_title_{{ $project['id'] }}">{{ $project['title'] }}</h3>
                        <p data-translate="project_description_{{ $project['id'] }}">{{ $project['description'] }}</p>

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
