<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('about');
    }
    return view('home');
})->name('home');

// Alle pagina's behalve home alleen voor ingelogde gebruikers
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/projects', function () {
        // Mock data zodat de pagina niet crasht
        $projects = [
            [
                'id' => 1,
                'title' => 'Voorbeeld Project',
                'description' => 'Dit is een voorbeeldproject.',
                'category' => 'web',
                'image' => asset('images/projects/voorbeeld.png'),
                'tech' => ['Laravel', 'PHP', 'MySQL'],
            ],
            // Voeg meer projecten toe indien gewenst
        ];
        return view('projects', compact('projects'));
    })->name('projects');

    Route::get('/dev-life', function () {
        $skillModel = new \App\Models\SkillModel();
        $skills = $skillModel->getAllSkills();
        $education = [
            ['title' => 'Bachelor Toegepaste Informatica', 'school' => 'Erasmushogeschool Brussel', 'year' => '2023-2026'],
            ['title' => 'Secundair Onderwijs', 'school' => 'GO! Atheneum', 'year' => '2017-2023'],
        ];
        $learning_goals = [
            ['title' => 'Laravel verder uitdiepen'],
            ['title' => 'Vue.js projecten bouwen'],
            ['title' => 'DevOps basics leren'],
        ];
        return view('dev-life', compact('skills', 'education', 'learning_goals', 'skillModel'));
    })->name('dev-life');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    Route::post('/contact', function (Request $request) {
        // Hier kun je validatie en mail functionaliteit toevoegen
        // Voor nu gewoon een dummy response
        return back()->with('success', 'Bedankt voor je bericht!');
    })->name('contact.submit');

    Route::get('/cv-download', function () {
        // Zet hier het pad naar je CV-bestand (bijvoorbeeld in public/cv/cv.pdf)
        $cvPath = public_path('cv/cv.pdf');
        if (file_exists($cvPath)) {
            return response()->download($cvPath, 'Tom_Dekoning_CV.pdf');
        }
        abort(404, 'CV niet gevonden');
    })->name('cv.download');

    Route::get('/about', function () {
        return view('about', [
            'name' => 'Tom Dekoning',
            'email' => 'tom1dekoning@gmail.com',
            'linkedin' => 'https://www.linkedin.com/in/tom-dekoning-567523352/',
            'github' => 'https://github.com/tombomeke',
            // Add a flag to indicate translation keys should be used in the view
            'useTranslations' => true,
        ]);
    })->name('about');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
