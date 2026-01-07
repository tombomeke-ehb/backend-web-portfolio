<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();
        $maintenance = false;
        $logContext = [
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'is_admin' => $user?->is_admin,
            'route' => request()->path(),
        ];
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
                $maintenance = \App\Models\SiteSetting::get('maintenance_mode', false);
            }
        } catch (\Throwable $e) {
            $logContext['maintenance_exception'] = $e->getMessage();
        }
        $logContext['maintenance'] = $maintenance;
        \Log::info('[LOGIN DEBUG] Na authenticatie', $logContext);

        if ($maintenance && $user && $user->is_admin) {
            \Log::info('[LOGIN DEBUG] Redirect naar admin dashboard', $logContext);
            return redirect()->route('admin.dashboard');
        }

        \Log::info('[LOGIN DEBUG] Redirect naar intended', $logContext);
        return redirect()->intended(route('about', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
