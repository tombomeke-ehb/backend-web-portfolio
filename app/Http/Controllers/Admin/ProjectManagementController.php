<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectManagementController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->with('translations')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'max:120', 'alpha_dash', 'unique:projects,slug'],
            'category' => ['required', 'string', 'max:50'],
            'status' => ['nullable', 'string', 'max:50'],
            'repo_url' => ['nullable', 'url', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'tech' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],

            'title_nl' => ['required', 'string', 'max:255'],
            'description_nl' => ['required', 'string'],
            'long_description_nl' => ['nullable', 'string'],
            'features_nl' => ['nullable', 'string'],

            'title_en' => ['required', 'string', 'max:255'],
            'description_en' => ['required', 'string'],
            'long_description_en' => ['nullable', 'string'],
            'features_en' => ['nullable', 'string'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        $tech = [];
        if (!empty($validated['tech'])) {
            $tech = array_values(array_filter(array_map('trim', preg_split('/[\n,]+/', $validated['tech']))));
        }

        $project = Project::create([
            'slug' => $validated['slug'],
            'category' => $validated['category'],
            'status' => $validated['status'] ?? null,
            'repo_url' => $validated['repo_url'] ?? null,
            'demo_url' => $validated['demo_url'] ?? null,
            'image_path' => $imagePath,
            'tech' => $tech,
            'sort_order' => (int)($validated['sort_order'] ?? 0),
        ]);

        foreach (['nl', 'en'] as $lang) {
            $project->translations()->create([
                'lang' => $lang,
                'title' => $validated["title_{$lang}"],
                'description' => $validated["description_{$lang}"],
                'long_description' => $validated["long_description_{$lang}"] ?? null,
                'features' => $this->parseFeatures($validated["features_{$lang}"] ?? null),
            ]);
        }

        ActivityLog::log('created', "Created project: {$project->title}", $project);

        return redirect()->route('admin.projects.index')->with('status', 'project-created');
    }

    public function edit(Project $project): View
    {
        $project->load('translations');

        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'max:120', 'alpha_dash', 'unique:projects,slug,' . $project->id],
            'category' => ['required', 'string', 'max:50'],
            'status' => ['nullable', 'string', 'max:50'],
            'repo_url' => ['nullable', 'url', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'tech' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],

            'title_nl' => ['required', 'string', 'max:255'],
            'description_nl' => ['required', 'string'],
            'long_description_nl' => ['nullable', 'string'],
            'features_nl' => ['nullable', 'string'],

            'title_en' => ['required', 'string', 'max:255'],
            'description_en' => ['required', 'string'],
            'long_description_en' => ['nullable', 'string'],
            'features_en' => ['nullable', 'string'],
        ]);

        $project->loadMissing('translations');

        if (($validated['remove_image'] ?? false) && $project->image_path) {
            Storage::disk('public')->delete($project->image_path);
            $project->image_path = null;
        }

        if ($request->hasFile('image')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $project->image_path = $request->file('image')->store('projects', 'public');
        }

        $tech = [];
        if (!empty($validated['tech'])) {
            $tech = array_values(array_filter(array_map('trim', preg_split('/[\n,]+/', $validated['tech']))));
        }

        $project->slug = $validated['slug'];
        $project->category = $validated['category'];
        $project->status = $validated['status'] ?? null;
        $project->repo_url = $validated['repo_url'] ?? null;
        $project->demo_url = $validated['demo_url'] ?? null;
        $project->tech = $tech;
        $project->sort_order = (int)($validated['sort_order'] ?? 0);
        $project->save();

        foreach (['nl', 'en'] as $lang) {
            $project->translations()->updateOrCreate(
                ['lang' => $lang],
                [
                    'title' => $validated["title_{$lang}"],
                    'description' => $validated["description_{$lang}"],
                    'long_description' => $validated["long_description_{$lang}"] ?? null,
                    'features' => $this->parseFeatures($validated["features_{$lang}"] ?? null),
                ]
            );
        }

        ActivityLog::log('updated', "Updated project: {$project->title}", $project);

        return redirect()->route('admin.projects.index')->with('status', 'project-updated');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $title = $project->title;

        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }

        $project->delete();

        ActivityLog::log('deleted', "Deleted project: {$title}");

        return redirect()->route('admin.projects.index')->with('status', 'project-deleted');
    }

    private function parseFeatures(?string $raw): array
    {
        if ($raw === null || trim($raw) === '') {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', $raw);
        $features = array_values(array_filter(array_map('trim', $lines)));
        return $features;
    }
}
