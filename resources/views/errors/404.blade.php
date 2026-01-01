@extends('layouts.app')

@section('content')
<section class="error-page">
    <div class="container">
        <div class="error-content">
            <div class="error-animation"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="error-code">404</div>
            <h1 data-translate="error_404_title">Pagina niet gevonden</h1>
            <p class="error-message" data-translate="error_404_message">Sorry, de pagina die je zoekt bestaat niet of is verplaatst.</p>
            <div class="error-actions">
                <a href="{{ route('about') }}" class="btn btn-primary" data-translate="error_404_home"><i class="fas fa-home"></i> Terug naar Home</a>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary"><i class="fas fa-folder"></i> Bekijk Projecten</a>
            </div>
            <div class="error-suggestions">
                <h3 data-translate="error_404_suggestions">Misschien zoek je:</h3>
                <ul>
                    <li><a href="{{ route('devlife') }}"><i class="fas fa-code"></i> Developer Life</a></li>
                    <li><a href="{{ route('games') }}"><i class="fas fa-gamepad"></i> Gaming Stats</a></li>
                    <li><a href="{{ route('contact.show') }}" data-translate="nav_contact"><i class="fas fa-envelope"></i> Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
