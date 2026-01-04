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

        return redirect()->route('settings')->with('success', __('Settings saved.'));
    }
}
