<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    public function show(User $user): View
    {
        $user->load([
            'skills' => function ($q) {
                $q->where('is_public', true)->orderByDesc('level')->orderBy('name');
            },
        ]);

        return view('profiles.show', [
            'user' => $user,
            'isOwnProfile' => Auth::check() && Auth::id() === $user->id,
        ]);
    }
}
