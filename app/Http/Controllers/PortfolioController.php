<?php

namespace App\Http\Controllers;

use App\Mail\AdminContactReceivedMail;
use App\Models\ContactMessage;
use App\Models\GameStatsModel;
use App\Models\ProjectModel;
use App\Models\SkillModel;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PortfolioController extends Controller
{
    private ProjectModel $projectModel;
    private SkillModel $skillModel;
    private GameStatsModel $gameStatsModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        $this->skillModel = new SkillModel();
        $this->gameStatsModel = new GameStatsModel();
    }

    private function getLang(Request $request): string
    {
        // 1) Prefer localStorage-driven language (sent by the browser in a cookie, but
        // some setups can have an out-of-sync cookie). We accept an explicit query
        // param too for debugging.
        $lang = (string) ($request->query('lang')
            ?? $request->cookie('portfolio_lang')
            ?? 'nl');

        return in_array($lang, ['nl', 'en'], true) ? $lang : 'nl';
    }

    public function about()
    {
        $data = [
            'title'    => 'About',
            'name'     => 'Tom Dekoning',
            'email'    => 'tom1dekoning@gmail.com',
            'linkedin' => 'https://www.linkedin.com/in/tom-dekoning-567523352/',
            'github'   => 'https://github.com/tombomeke',
            'useTranslations' => true,
        ];

        return view('about', $data);
    }

    public function devLife(Request $request)
    {
        $lang = $this->getLang($request);
        $skills = $this->skillModel->getAllSkills();

        return view('dev-life', [
            'title'          => 'Developer Life',
            'skills'         => $skills,
            'skillModel'     => $this->skillModel,
            'education'      => $this->skillModel->getEducation($lang),
            'learning_goals' => $this->skillModel->getLearningGoals($lang),
        ]);
    }

    public function games()
    {
        $mcStats = $this->gameStatsModel->getMinecraftStats();
        $r6Stats = $this->gameStatsModel->getR6Stats();

        return view('games', [
            'title'     => 'Gaming Stats',
            'minecraft' => $mcStats,
            'r6siege'   => $r6Stats,
        ]);
    }

    public function projects(Request $request)
    {
        $lang = $this->getLang($request);

        if (!Schema::hasTable('projects')) {
            // Fallback to the old in-code project list so the page never 500s
            $projects = (new ProjectModel())->getAllProjects($lang);

            return view('projects', [
                'title' => $lang === 'en' ? 'Projects' : 'Projecten',
                'projects' => $projects,
            ]);
        }

        $projects = Project::query()
            ->with('translations')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get()
            ->map(function (Project $project) use ($lang) {
                $tNl = $project->translations->firstWhere('lang', 'nl');
                $tEn = $project->translations->firstWhere('lang', 'en');

                return [
                    'id' => $project->id,
                    // Provide both languages so the client can swap without depending on hard reload
                    'title' => [
                        'nl' => $tNl?->title ?? $project->title,
                        'en' => $tEn?->title ?? $project->title,
                    ],
                    'description' => [
                        'nl' => $tNl?->description ?? $project->description,
                        'en' => $tEn?->description ?? $project->description,
                    ],
                    'long_description' => [
                        'nl' => $tNl?->long_description ?? $project->long_description,
                        'en' => $tEn?->long_description ?? $project->long_description,
                    ],
                    'tech' => $project->tech ?? [],
                    'repo_url' => $project->repo_url,
                    'demo_url' => $project->demo_url,
                    'image' => $project->image_path ? asset('storage/' . ltrim($project->image_path, '/')) : null,
                    'category' => $project->category,
                    'status' => $project->status,
                    'features' => [
                        'nl' => $tNl?->features ?? [],
                        'en' => $tEn?->features ?? [],
                    ],
                ];
            })
            ->values()
            ->all();

        return view('projects', [
            'title' => $lang === 'en' ? 'Projects' : 'Projecten',
            'projects' => $projects,
        ]);
    }

    public function contactShow()
    {
        return view('contact', [
            'title' => 'Contact',
        ]);
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate(
            [
                'name'    => ['required', 'string', 'min:2'],
                'email'   => ['required', 'email'],
                'subject' => ['nullable', 'string', 'max:150'],
                'message' => ['required', 'string', 'min:10'],
            ],
            [
                'name.required' => __('validation.required', ['attribute' => __('Name')]),
                'name.min' => __('validation.min.string', ['attribute' => __('Name'), 'min' => 2]),
                'email.required' => __('validation.required', ['attribute' => __('Email')]),
                'email.email' => __('validation.email', ['attribute' => __('Email')]),
                'message.required' => __('validation.required', ['attribute' => __('Message')]),
                'message.min' => __('validation.min.string', ['attribute' => __('Message'), 'min' => 10]),
            ]
        );

        $messageModel = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        // Send to admin inbox address (configurable)
        $adminEmail = config('mail.admin_address')
            ?? config('mail.from.address')
            ?? 'admin@ehb.be';

        Mail::to($adminEmail)->send(new AdminContactReceivedMail($messageModel));

        return redirect()->route('contact')->with('success', __('validation.contact_success'));
    }

    public function downloadCv(): StreamedResponse
    {
        $path = public_path('cv/cv.pdf');
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->streamDownload(function () use ($path) {
            readfile($path);
        }, 'CV_Tom_Dekoning.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function wip(string $page = null)
    {
        $pageLabel = $this->getPageLabel($page);

        return view('wip', [
            'title'     => 'Work in progress',
            'pageLabel' => $pageLabel,
            'pageKey'   => $page,
        ]);
    }

    private function getPageLabel(?string $page): string
    {
        $labels = [
            'home'     => 'About',
            'about'    => 'About',
            'dev-life' => 'Developer Life',
            'games'    => 'Games',
            'projects' => 'Projecten',
            'contact'  => 'Contact',
        ];

        if ($page && isset($labels[$page])) {
            return $labels[$page];
        }

        if ($page) {
            return ucwords(str_replace(['-', '_'], ' ', $page));
        }

        return 'Pagina';
    }
}
