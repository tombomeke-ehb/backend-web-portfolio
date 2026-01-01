@extends('layouts.app')

@section('content')
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1><span data-translate="hero_greeting">Hoi, ik ben</span> {{ $name }}</h1>
                <p class="lead" data-translate="hero_intro">Full-stack developer met passie voor gaming en open source projecten. Gespecialiseerd in PHP, JavaScript en Minecraft plugin development.</p>
                <div class="hero-actions">
                    <a href="{{ route('projects') }}" class="btn btn-primary">
                        <i class="fas fa-folder-open"></i> <span data-translate="hero_view_work">Bekijk mijn werk</span>
                    </a>
                    <a href="{{ route('cv.download') }}" class="btn btn-secondary">
                        <i class="fas fa-download"></i> <span data-translate="hero_download_cv">Download CV</span>
                    </a>
                </div>
                <div class="contact-info">
                    <a href="mailto:{{ $email }}">
                        <i class="fas fa-envelope"></i> {{ $email }}
                    </a>
                    <a href="{{ $linkedin }}" target="_blank">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                    <a href="{{ $github }}" target="_blank">
                        <i class="fab fa-github"></i> GitHub
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/profile.png') }}" alt="{{ $name }}" class="profile-img">
            </div>
        </div>
    </div>
</section>
@endsection
