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

        <!-- Account & Admin styles -->
        <link rel="stylesheet" href="{{ asset('css/account.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

        <!-- FontAwesome voor iconen -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Custom JS -->
        <script src="{{ asset('js/language.js') }}" defer></script>

        @if (request()->routeIs('dev-life') || request()->routeIs('projects'))
            <script src="{{ asset('js/modal.js') }}" defer></script>
        @endif

        <script src="{{ asset('js/script.js') }}" defer></script>

        <script>
            // Provide translations to public/js/language.js
            window.portfolioTranslations = {!! json_encode(config('translations'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
        </script>
    </head>
    <body class="{{ request()->routeIs('profile.*') || request()->routeIs('settings') ? 'account-page' : '' }}">
        <div style="min-height: 100vh; display: flex; flex-direction: column;">
            @if (Request::route()->getName() !== 'home')
                <nav class="navbar">
                    <div class="nav-container">
                        <div class="nav-logo">
                            @php
                                $brandHref = auth()->check() ? route('about') : route('home');
                            @endphp
                            <a href="{{ $brandHref }}">Portfolio</a>
                        </div>
                        <ul class="nav-menu">
                            @if (auth()->check())
                                <li><a class="nav-link @if (request()->routeIs('about')) active @endif" href="{{ route('about') }}" data-translate="nav_about">About</a></li>
                                <li><a class="nav-link @if (request()->routeIs('projects')) active @endif" href="{{ route('projects') }}" data-translate="nav_projects">Projecten</a></li>
                                <li><a class="nav-link @if (request()->routeIs('dev-life')) active @endif" href="{{ route('dev-life') }}" data-translate="nav_dev_life">Dev Life</a></li>
                                <li><a class="nav-link @if (request()->routeIs('games')) active @endif" href="{{ route('games') }}" data-translate="nav_games">Games</a></li>
                                <li><a class="nav-link @if (request()->routeIs('news.*')) active @endif" href="{{ route('news.index') }}" data-translate="nav_news">News</a></li>
                                <li><a class="nav-link @if (request()->routeIs('faq.*')) active @endif" href="{{ route('faq.index') }}" data-translate="nav_faq">FAQ</a></li>
                                <li><a class="nav-link @if (request()->routeIs('contact')) active @endif" href="{{ route('contact') }}" data-translate="nav_contact">Contact</a></li>
                                
                                <li>
                                    <button id="lang-toggle" class="lang-toggle nav-link" aria-label="Switch language"></button>
                                </li>

                                <li class="nav-account">
                                    <details class="account-dropdown">
                                        <summary class="nav-link account-trigger" aria-label="Account">
                                            <i class="fas fa-user-circle" style="margin-right:.4rem;"></i>
                                            {{ auth()->user()->username ?? auth()->user()->name }}
                                            <i class="fas fa-chevron-down" style="margin-left:.4rem; font-size:.85em;"></i>
                                        </summary>

                                        <div class="account-menu" role="menu">
                                            <a class="account-item" href="{{ route('profile.edit') }}">
                                                <i class="fas fa-id-badge"></i>
                                                <span data-translate="nav_profile">Profile</span>
                                            </a>

                                            <a class="account-item" href="{{ route('settings') }}">
                                                <i class="fas fa-cog"></i>
                                                <span data-translate="nav_settings">Settings</span>
                                            </a>

                                            @if (auth()->user()?->is_admin)
                                                <a class="account-item account-item--admin" href="{{ route('admin.dashboard') }}">
                                                    <i class="fas fa-shield-alt"></i>
                                                    <span data-translate="nav_admin">Admin Panel</span>
                                                </a>
                                            @endif

                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="account-item account-logout">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                    <span data-translate="nav_logout">Logout</span>
                                                </button>
                                            </form>
                                        </div>
                                    </details>
                                </li>
                            @endif
                        </ul>
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
