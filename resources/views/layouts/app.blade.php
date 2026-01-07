{{--
  Source attribution:
  - Original portfolio layout derived from https://tombomeke.com (author: Tom Dekoning).
  - Modified/adapted for this Laravel Backend Web course project.
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-preferred-language="{{ auth()->check() ? (auth()->user()->preferred_language ?? '') : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        @php
            use App\Models\SiteSetting;
            $siteName = SiteSetting::get('site_name', config('app.name', 'Laravel'));
            $siteTagline = SiteSetting::get('site_tagline', '');
            $primaryColor = SiteSetting::get('brand_primary_color', '#F54927');
            $showCookieNotice = SiteSetting::get('show_cookie_notice', false);
            $github = SiteSetting::get('social_github', null);
            $linkedin = SiteSetting::get('social_linkedin', null);
            $twitter = SiteSetting::get('social_twitter', null);
            $instagram = SiteSetting::get('social_instagram', null);
            $privacy = SiteSetting::get('privacy_policy_url', null);
            $terms = SiteSetting::get('terms_url', null);
        @endphp


        <title>{{ $siteName }}</title>

        <!-- LAAD ALLEEN JE EIGEN CSS -->
        <link rel="stylesheet" href="{{ asset('css/base.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">
        <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <style>
            :root {
                --primary-brand-color: {{ $primaryColor }};
            }
        </style>

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

        <script id="portfolio-translations" type="application/json">{!! json_encode(config('translations'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
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
                            <a href="{{ $brandHref }}">{{ $siteName }}</a>
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
                                            <a class="account-item" href="{{ route('profiles.show', auth()->user()) }}">
                                                <i class="fas fa-user"></i>
                                                <span data-translate="nav_profile">Profile</span>
                                            </a>

                                            <a class="account-item" href="{{ route('profile.edit') }}">
                                                <i class="fas fa-id-badge"></i>
                                                <span data-translate="nav_profile_settings">Profile Settings</span>
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
                    <p>&copy; {{ date('Y') }} {{ $siteName }}. {{ $siteTagline }}</p>
                    <div class="footer-social">
                        @if($twitter)
                            <a href="{{ $twitter }}" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if($github)
                            <a href="{{ $github }}" target="_blank" rel="noopener" aria-label="GitHub"><i class="fab fa-github"></i></a>
                        @endif
                        @if($linkedin)
                            <a href="{{ $linkedin }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        @endif
                        @if($instagram)
                            <a href="{{ $instagram }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        @endif
                    </div>
                    <div class="footer-legal">
                        @if($privacy)
                            <a href="{{ $privacy }}" target="_blank" rel="noopener" aria-label="Privacy Policy" style="margin-right:1.5em;">Privacy Policy</a>
                        @endif
                        @if($terms)
                            <a href="{{ $terms }}" target="_blank" rel="noopener" aria-label="Terms of Service">Terms of Service</a>
                        @endif
                    </div>
                </div>
                @if($showCookieNotice)
                    <div class="cookie-notice" style="
                        position: fixed;
                        left: 50%;
                        bottom: 2.5rem;
                        transform: translateX(-50%);
                        min-width: 320px;
                        max-width: 90vw;
                        background: rgba(30,41,59,0.98);
                        color: #f8fafc;
                        border-radius: 1rem;
                        box-shadow: 0 8px 32px 0 rgba(0,0,0,0.25);
                        padding: 1.25em 2em 1.25em 1.5em;
                        display: flex;
                        align-items: center;
                        gap: 1.5em;
                        z-index: 9999;
                        font-size: 1.05rem;
                        border: 1.5px solid #334155;
                        animation: cookiefadein 0.7s cubic-bezier(.4,0,.2,1);
                    ">
                        <span style="flex:1; text-align:left;">
                            <i class="fas fa-cookie-bite" style="margin-right:.7em; color:#fbbf24;"></i>
                            {{ SiteSetting::get('cookie_notice_text', 'Deze website gebruikt cookies.') }}
                        </span>
                        <button onclick="this.closest('.cookie-notice').style.display='none'" style="
                            background: #06d6a0;
                            color: #1e293b;
                            border: none;
                            border-radius: .5em;
                            font-weight: 700;
                            padding: .5em 1.2em;
                            font-size: 1em;
                            cursor: pointer;
                            box-shadow: 0 2px 8px 0 rgba(6,214,160,0.12);
                            transition: background 0.2s;
                        " onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#06d6a0'">
                            Oké
                        </button>
                    </div>
                    <style>
                        @keyframes cookiefadein {
                            from { opacity: 0; transform: translateY(40px) scale(0.98); }
                            to { opacity: 1; transform: translateY(0) scale(1); }
                        }
                    </style>
                @endif
            </footer>
        </div>
    </body>
</html>
