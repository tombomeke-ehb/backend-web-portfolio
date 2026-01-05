<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(Request $request): View
    {
        return view('settings.index', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'preferred_language' => ['required', 'in:nl,en'],
            'timezone' => ['nullable', 'string', 'max:64'],
            'public_profile' => ['nullable'],
            'email_notifications' => ['nullable'],
        ]);

        $user = $request->user();
        $user->preferred_language = $data['preferred_language'];
        $user->timezone = $data['timezone'] ?? $user->timezone;
        $user->public_profile = $request->has('public_profile');
        $user->email_notifications = $request->has('email_notifications');
        $user->save();

        // Update the cookie and app locale immediately for this session
        app()->setLocale($data['preferred_language']);
        cookie()->queue('portfolio_lang', $data['preferred_language'], 525600); // 1 year

        return redirect()->route('settings')->with('success', __('Settings saved.'));
    }

    /**
     * Switch language via AJAX (updates user preference for logged-in users).
     */
    public function switchLanguage(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'language' => ['required', 'in:nl,en'],
        ]);

        $lang = $data['language'];

        // Update user preference in database (if logged in)
        if ($user = $request->user()) {
            $user->preferred_language = $lang;
            $user->save();
        }

        // Set cookie and locale
        app()->setLocale($lang);
        cookie()->queue('portfolio_lang', $lang, 525600); // 1 year

        return response()->json(['success' => true, 'language' => $lang]);
    }
}
