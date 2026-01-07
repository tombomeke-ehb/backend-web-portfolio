<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        // If migrations haven't run yet (or DB just switched), don't hard-crash.
        if (!Schema::hasTable('site_settings')) {
            \Log::info('[MAINTENANCE DEBUG] No site_settings table, skipping maintenance check', [
                'route' => $request->route()?->getName(),
                'path' => $request->path(),
                'method' => $request->method(),
            ]);
            return $next($request);
        }

        $maintenance = SiteSetting::get('maintenance_mode', false);
        $isAdmin = $request->user()?->is_admin;

        if ($maintenance) {
            // Allow POST /login (and optionally /logout, /password, etc.) by path/method
            if (
                ($request->is('login') && ($request->isMethod('get') || $request->isMethod('post'))) ||
                ($request->is('logout') && $request->isMethod('post')) ||
                ($request->is('password/*')) ||
                ($request->is('verification/*'))
            ) {
                \Log::info('[MAINTENANCE DEBUG] Allowed path/method during maintenance', [
                    'route' => $request->route()?->getName(),
                    'path' => $request->path(),
                    'method' => $request->method(),
                ]);
                return $next($request);
            }
            // Als user is ingelogd maar geen admin, direct uitloggen en maintenance tonen
            if ($request->user() && !$isAdmin) {
                \Log::info('[MAINTENANCE DEBUG] Non-admin user blocked during maintenance', [
                    'user_id' => $request->user()?->id,
                    'route' => $request->route()?->getName(),
                    'path' => $request->path(),
                    'method' => $request->method(),
                ]);
                auth()->logout();
                return response()->view('maintenance', [], 503);
            }
            // Niet-ingelogde gebruikers krijgen maintenance behalve op login/logout/password
            if (!$request->user()) {
                \Log::info('[MAINTENANCE DEBUG] Guest blocked during maintenance', [
                    'route' => $request->route()?->getName(),
                    'path' => $request->path(),
                    'method' => $request->method(),
                ]);
                return response()->view('maintenance', [], 503);
            }
        }
        \Log::info('[MAINTENANCE DEBUG] Request allowed (no maintenance or admin)', [
            'user_id' => $request->user()?->id,
            'is_admin' => $isAdmin,
            'route' => $request->route()?->getName(),
            'path' => $request->path(),
            'method' => $request->method(),
        ]);
        return $next($request);
    }
}
