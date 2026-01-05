<?php

namespace App\Http\Controllers;

use App\Models\UserSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserSkillController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'category' => ['nullable', 'string', 'max:40'],
            'level' => ['required', 'integer', 'min:1', 'max:5'],
            'notes' => ['nullable', 'string', 'max:500'],
            'is_public' => ['nullable'],
        ]);

        $request->user()->skills()->create([
            'name' => $data['name'],
            'category' => $data['category'] ?? null,
            'level' => $data['level'],
            'notes' => $data['notes'] ?? null,
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()->route('settings')->with('success', __('messages.Skill added.'));
    }

    public function update(Request $request, UserSkill $skill): RedirectResponse
    {
        abort_unless($skill->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'category' => ['nullable', 'string', 'max:40'],
            'level' => ['required', 'integer', 'min:1', 'max:5'],
            'notes' => ['nullable', 'string', 'max:500'],
            'is_public' => ['nullable'],
        ]);

        $skill->update([
            'name' => $data['name'],
            'category' => $data['category'] ?? null,
            'level' => $data['level'],
            'notes' => $data['notes'] ?? null,
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()->route('settings')->with('success', __('messages.Skill updated.'));
    }

    public function destroy(Request $request, UserSkill $skill): RedirectResponse
    {
        abort_unless($skill->user_id === $request->user()->id, 403);

        $skill->delete();

        return redirect()->route('settings')->with('success', __('messages.Skill removed.'));
    }
}
