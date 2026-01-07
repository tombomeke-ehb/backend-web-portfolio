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
                @php
                    $showMaintenance = false;
                    $maintenanceMessage = null;
                    try {
                        if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                            $showMaintenance = (bool) App\Models\SiteSetting::get('maintenance_mode', false);
                            $maintenanceMessage = App\Models\SiteSetting::get('maintenance_message', 'De website is momenteel in onderhoud. Probeer het later opnieuw.');
                        }
                    } catch (\Throwable $e) {}
                @endphp
                @if($showMaintenance && !auth()->check())
                    <style>
                        .maintenance-message {
                            background: linear-gradient(90deg, #fff0f3 0%, #f8fafc 100%);
                            color: #b71c1c;
                            padding: 22px 28px 20px 28px;
                            margin-bottom: 28px;
                            border-radius: 12px;
                            text-align: center;
                            font-size: 1.13em;
                            box-shadow: 0 4px 24px 0 rgba(183,28,28,0.10);
                            border: 2px solid #ffcdd2;
                            display: flex;
                            align-items: center;
                            gap: 14px;
                            justify-content: center;
                            font-family: inherit;
                            letter-spacing: 0.01em;
                        }
                        .maintenance-message i {
                            font-size: 1.35em;
                            margin-right: 2px;
                        }
                        .admin-login-btn {
                            display: inline-block;
                            background: linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%);
                            color: #fff;
                            font-weight: 700;
                            padding: 13px 38px;
                            border-radius: 8px;
                            font-size: 1.09em;
                            box-shadow: 0 2px 12px 0 rgba(37,99,235,0.10);
                            border: none;
                            text-decoration: none;
                            transition: background 0.18s, box-shadow 0.18s, transform 0.12s;
                            margin-bottom: 10px;
                            outline: none;
                        }
                        .admin-login-btn:hover, .admin-login-btn:focus {
                            background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 100%);
                            color: #fff;
                            box-shadow: 0 4px 18px 0 rgba(37,99,235,0.16);
                            transform: translateY(-2px) scale(1.03);
                        }
                        .admin-login-btn:active {
                            background: #1e40af;
                            color: #fff;
                            transform: scale(0.98);
                        }
                    </style>
                    <div class="maintenance-message">
                        <i class="fas fa-tools"></i>
                        <span>{{ $maintenanceMessage }}</span>
                    </div>
                    @if(!request()->routeIs('login'))
                        <div style="text-align:center;margin-bottom:22px;">
                            <a href="{{ route('login') }}" class="admin-login-btn">
                                <i class="fas fa-sign-in-alt"></i> Admin login
                            </a>
                        </div>
                    @endif
                @endif
                {{-- Always show login form below maintenance message if on login page --}}
                @if(request()->routeIs('login') || request()->is('login'))
                    {{ $slot ?? '' }}
                @elseif(!$showMaintenance || auth()->check())
                    {{ $slot ?? '' }}
                @endif
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
                    } catch (\Throwable $e) {
                        \Log::error('[guest.blade.php] cookie notice retrieval failed: ' . $e->getMessage());
                        echo "<script>console.error('[guest.blade.php] Cookie notice error: " . addslashes($e->getMessage()) . "');</script>";
                    }
                @endphp
                {{ $cookieText }}
                <button onclick="this.parentElement.style.display='none'" style="margin-left:1em;">Oké</button>
            </div>
        @endif
    </body>
</html>
