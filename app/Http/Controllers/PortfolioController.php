<?php

namespace App\Http\Controllers;

use App\Models\GameStatsModel;
use App\Models\ProjectModel;
use App\Models\SkillModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function about()
    {
        $data = [
            'title'    => 'About',
            'name'     => 'Tom Dekoning',
            'email'    => 'tom1dekoning@gmail.com',
            'linkedin' => 'https://www.linkedin.com/in/tom-dekoning-567523352/',
            'github'   => 'https://github.com/tombomeke',
        ];

        return view('about', $data);
    }

    public function devLife()
    {
        $skills = $this->skillModel->getAllSkills();

        return view('dev-life', [
            'title'       => 'Developer Life',
            'skills'      => $skills,
            'skillModel'  => $this->skillModel,
            'education'   => $this->skillModel->getEducation('nl'),
            'learning_goals' => $this->skillModel->getLearningGoals('nl'),
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

    public function projects()
    {
        return view('projects', [
            'title'       => 'Projecten',
            'projects'    => $this->projectModel->getAllProjects(),
            'projectModel'=> $this->projectModel,
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
        $validated = $request->validate([
            'name'    => ['required', 'string', 'min:2'],
            'email'   => ['required', 'email'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        // NOTE: configure mail in .env before this will actually send
        Mail::raw(
            "Naam: {$validated['name']}\nE-mail: {$validated['email']}\n\nBericht:\n{$validated['message']}",
            function ($mail) use ($validated) {
                $mail->to('jouw@email.com')
                     ->subject('Portfolio Contact: '.$validated['name'])
                     ->replyTo($validated['email']);
            }
        );

        return redirect()->route('contact.show')->with('success', 'Bericht succesvol verzonden! Ik neem zo snel mogelijk contact met je op.');
    }

    public function downloadCv(): StreamedResponse
    {
        $path = storage_path('app/public/CV_JouwNaam.pdf');
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->streamDownload(function () use ($path) {
            readfile($path);
        }, 'CV_JouwNaam.pdf', [
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
