@extends('layouts.app')

@section('content')
<section class="admin-page">
    <div class="admin-container">
        @include('admin.partials.sidebar')

        <main class="admin-main">
            @if(\App\Models\SiteSetting::get('maintenance_mode', false))
                <div class="admin-maintenance-banner" role="status" aria-live="polite">
                    <div class="admin-maintenance-banner__inner">
                        <div class="admin-maintenance-banner__left">
                            <strong>{{ __('admin.Maintenance Mode is ON') }}</strong>
                            <span class="admin-maintenance-banner__hint">{{ __('admin.Visitors are seeing the maintenance page (503).') }}</span>
                        </div>
                        <div class="admin-maintenance-banner__right">
                            <a class="btn btn-sm btn-outline" href="{{ route('admin.settings.index') }}">
                                {{ __('admin.Manage settings') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @yield('admin-content')
        </main>
    </div>
</section>
@endsection
