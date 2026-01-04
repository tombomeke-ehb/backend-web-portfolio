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
            return $next($request);
        }

        // Allow admins and authenticated users to bypass if needed
        $isAdmin = $request->user()?->is_admin;

        if (!$isAdmin && SiteSetting::get('maintenance_mode', false)) {
            // Allow login/logout and password reset routes so you can still access the app
            if ($request->routeIs('login', 'logout', 'register', 'password.*', 'verification.*')) {
                return $next($request);
            }

            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
