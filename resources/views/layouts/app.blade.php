<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- LAAD ALLEEN JE EIGEN CSS -->
        <link rel="stylesheet" href="{{ asset('css/base.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        @if (request()->routeIs('dev-life') || request()->routeIs('projects'))
            <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        @endif

        <!-- FontAwesome voor iconen -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Custom JS -->
        <script src="{{ asset('js/language.js') }}" defer></script>

        @if (request()->routeIs('dev-life') || request()->routeIs('projects'))
            <script src="{{ asset('js/modal.js') }}" defer></script>
        @endif

        <script src="{{ asset('js/script.js') }}" defer></script>
        <script>
            window.portfolioTranslations = @json(config('translations'));
        </script>
    </head>
    <body>
        <div style="min-height: 100vh; display: flex; flex-direction: column;">
            @if (Request::route()->getName() !== 'home')
                <nav class="navbar">
                    <div class="nav-container">
                        <div class="nav-logo">
                            <a href="{{ route('home') }}">Portfolio</a>
                        </div>
                        <ul class="nav-menu">
                            @if (auth()->check())
                                <li><a class="nav-link @if (request()->routeIs('about')) active @endif" href="{{ route('about') }}">About</a></li>
                                <li><a class="nav-link @if (request()->routeIs('projects')) active @endif" href="{{ route('projects') }}">Projecten</a></li>
                                <li><a class="nav-link @if (request()->routeIs('dev-life')) active @endif" href="{{ route('dev-life') }}">Dev Life</a></li>
                                <li><a class="nav-link @if (request()->routeIs('games')) active @endif" href="{{ route('games') }}">Games</a></li>
                                <li><a class="nav-link @if (request()->routeIs('contact')) active @endif" href="{{ route('contact') }}">Contact</a></li>
                                <li>
                                    <button id="lang-toggle" class="lang-toggle nav-link" aria-label="Switch language"></button>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                </li>
                            @endif
                        </ul>
                        @if (auth()->check())
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    </div>
                </nav>
            @endif

            <!-- Page Content -->
            <main style="flex: 1;">
                @yield('content')
            </main>
            <footer>
                <div class="container">
                    <p>&copy; {{ date('Y') }} Tom Dekoning. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
