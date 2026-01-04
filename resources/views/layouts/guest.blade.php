<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- FontAwesome voor iconen -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- EIGEN CSS -->
        <link rel="stylesheet" href="{{ asset('css/base.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <!-- Custom JS -->
        <script src="{{ asset('js/language.js') }}" defer></script>
        <script src="{{ asset('js/script.js') }}" defer></script>

        <script id="portfolio-translations" type="application/json">{!! json_encode(config('translations'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    </head>
    <body>
        <div class="auth-layout">
            <div class="auth-container">
                <div class="auth-header">
                    <div class="auth-logo">
                        <a href="/">
                            <i class="fas fa-code"></i> Portfolio
                        </a>
                    </div>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
