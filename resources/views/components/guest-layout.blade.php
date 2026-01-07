<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            use App\Models\SiteSetting;
            $siteName = 'Portfolio';
            $primaryColor = '#F54927';
            $showCookieNotice = false;
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                    $siteName = SiteSetting::get('site_name', config('app.name', 'Portfolio'));
                    $primaryColor = SiteSetting::get('primary_brand_color', '#F54927');
                                $primaryColor = SiteSetting::get('brand_primary_color', '#F54927');
                    $showCookieNotice = SiteSetting::get('cookie_notice_enabled', false);
                }
            } catch (\Throwable $e) {
                // Fallback op defaults als DB niet bereikbaar is
            }
        @endphp
        <title>{{ $siteName }}</title>

        <!-- FontAwesome voor iconen -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- EIGEN CSS -->
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
                            <i class="fas fa-code"></i> {{ $siteName }}
                        </a>
                    </div>
                </div>
                {{ $slot }}
            </div>
        </div>
        @if($showCookieNotice)
            <div class="cookie-notice" style="background: #222; color: #fff; padding: 1em; text-align: center;">
                @php
                    $cookieText = 'Deze website gebruikt cookies.';
                    try {
                        if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                            $cookieText = SiteSetting::get('cookie_notice_text', $cookieText);
                        }
                    } catch (\Throwable $e) {}
                @endphp
                {{ $cookieText }}
                <button onclick="this.parentElement.style.display='none'" style="margin-left:1em;">Oké</button>
            </div>
        @endif
    </body>
</html>
