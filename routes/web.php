
<?php
// Registration route override for toggle
Route::get('/register', function () {
    if (!\App\Models\SiteSetting::get('registration_enabled', true)) {
        return view('auth.registration-disabled');
    }
    return app(\App\Http\Controllers\Auth\RegisteredUserController::class)->create();
})->name('register');

Route::post('/register', function (\Illuminate\Http\Request $request) {
    if (!\App\Models\SiteSetting::get('registration_enabled', true)) {
        return redirect()->route('register')->with('error', __('Registration is currently disabled by the site administrator.'));
    }
    return app(\App\Http\Controllers\Auth\RegisteredUserController::class)->store($request);
});

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\NewsManagementController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\FaqItemController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\TagManagementController;
use App\Http\Controllers\Admin\NewsCommentManagementController;
use App\Http\Controllers\Admin\ProjectManagementController;
use App\Http\Controllers\Admin\ProjectMigrationHealthController;
use App\Http\Controllers\Admin\SiteSettingsDiagnosticsController;
use App\Http\Controllers\UserSkillController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('about');
    }

    return view('home');
})->name('home');

// Public profile pages (visible for guests)
Route::get('/u/{user:username}', function ($username) {
    if (!\App\Models\SiteSetting::get('public_profiles_enabled', true)) {
        return view('profiles.disabled');
    }
    $user = \App\Models\User::where('username', $username)->firstOrFail();
    return app(\App\Http\Controllers\PublicProfileController::class)->show($user);
})->where('user', '[A-Za-z0-9_\-\.]+')->name('profiles.show');

// Public news pages (visible for guests)
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{newsItem}', [NewsController::class, 'show'])->name('news.show');

// Public FAQ page (visible for guests)
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Public contact page (required: visitors can submit)
Route::get('/contact', [PortfolioController::class, 'contactShow'])->name('contact');
Route::post('/contact', [PortfolioController::class, 'contactSubmit'])->name('contact.submit');

// All portfolio pages except home locked behind auth + verified
Route::middleware(['auth', 'verified'])->group(function () {
    // Settings (separate from Profile)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Language switch endpoint (AJAX)
    Route::post('/language/switch', [SettingsController::class, 'switchLanguage'])->name('language.switch');

    // Portfolio pages via controller
    Route::get('/about', [PortfolioController::class, 'about'])->name('about');
    Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
    Route::get('/dev-life', [PortfolioController::class, 'devLife'])->name('dev-life');

    // Games currently shows WIP
    Route::get('/games', [PortfolioController::class, 'wip'])->defaults('page', 'games')->name('games');

    Route::get('/cv-download', [PortfolioController::class, 'downloadCv'])->name('cv.download');

    // Profile edit/update/destroy
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Comments on news: authenticated users can post
    Route::post('/news/{newsItem}/comments', [NewsCommentController::class, 'store'])
        ->name('news.comments.store');

    // User skills (stored in DB, shown on public profile)
    Route::post('/settings/skills', [UserSkillController::class, 'store'])->name('settings.skills.store');
    Route::put('/settings/skills/{skill}', [UserSkillController::class, 'update'])->name('settings.skills.update');
    Route::delete('/settings/skills/{skill}', [UserSkillController::class, 'destroy'])->name('settings.skills.destroy');

    // Admin-only user management
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin')
        ->group(function () {
            // Admin Dashboard
            Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

            Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
            Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');

            // Admin news management
            Route::get('/news', [NewsManagementController::class, 'index'])->name('news.index');
            Route::get('/news/create', [NewsManagementController::class, 'create'])->name('news.create');
            Route::post('/news', [NewsManagementController::class, 'store'])->name('news.store');
            Route::get('/news/{newsItem}/edit', [NewsManagementController::class, 'edit'])->name('news.edit');
            Route::put('/news/{newsItem}', [NewsManagementController::class, 'update'])->name('news.update');
            Route::delete('/news/{newsItem}', [NewsManagementController::class, 'destroy'])->name('news.destroy');

            Route::prefix('faq')->name('faq.')->group(function () {
                // Categories
                Route::get('/categories', [FaqCategoryController::class, 'index'])->name('categories.index');
                Route::get('/categories/create', [FaqCategoryController::class, 'create'])->name('categories.create');
                Route::post('/categories', [FaqCategoryController::class, 'store'])->name('categories.store');
                Route::get('/categories/{category}/edit', [FaqCategoryController::class, 'edit'])->name('categories.edit');
                Route::put('/categories/{category}', [FaqCategoryController::class, 'update'])->name('categories.update');
                Route::delete('/categories/{category}', [FaqCategoryController::class, 'destroy'])->name('categories.destroy');

                // Items
                Route::get('/items', [FaqItemController::class, 'index'])->name('items.index');
                Route::get('/items/create', [FaqItemController::class, 'create'])->name('items.create');
                Route::post('/items', [FaqItemController::class, 'store'])->name('items.store');
                Route::get('/items/{item}/edit', [FaqItemController::class, 'edit'])->name('items.edit');
                Route::put('/items/{item}', [FaqItemController::class, 'update'])->name('items.update');
                Route::delete('/items/{item}', [FaqItemController::class, 'destroy'])->name('items.destroy');
            });

            // Admin: contact form inbox
            Route::get('/contact', [ContactMessageController::class, 'index'])->name('contact.index');
            Route::get('/contact/{message}', [ContactMessageController::class, 'show'])->name('contact.show');
            Route::post('/contact/{message}/reply', [ContactMessageController::class, 'reply'])->name('contact.reply');
            Route::post('/contact/{message}/unread', [ContactMessageController::class, 'markUnread'])->name('contact.markUnread');

            // Admin: tags management (many-to-many for news)
            Route::get('/tags', [TagManagementController::class, 'index'])->name('tags.index');
            Route::get('/tags/create', [TagManagementController::class, 'create'])->name('tags.create');
            Route::post('/tags', [TagManagementController::class, 'store'])->name('tags.store');
            Route::get('/tags/{tag}/edit', [TagManagementController::class, 'edit'])->name('tags.edit');
            Route::put('/tags/{tag}', [TagManagementController::class, 'update'])->name('tags.update');
            Route::delete('/tags/{tag}', [TagManagementController::class, 'destroy'])->name('tags.destroy');

            // Admin: comment moderation
            Route::get('/news-comments', [NewsCommentManagementController::class, 'index'])->name('news-comments.index');
            Route::post('/news-comments/{comment}/approve', [NewsCommentManagementController::class, 'approve'])->name('news-comments.approve');
            Route::delete('/news-comments/{comment}', [NewsCommentManagementController::class, 'destroy'])->name('news-comments.destroy');

            // Admin: activity logs
            Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
            Route::post('/activity-logs/clear', [ActivityLogController::class, 'clear'])->name('activity-logs.clear');
            Route::delete('/activity-logs/{activityLog}', [ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');

            // Admin: site settings
            Route::get('/settings', [SiteSettingsController::class, 'index'])->name('settings.index');
            Route::put('/settings', [SiteSettingsController::class, 'update'])->name('settings.update');
            Route::get('/settings/diagnostics', SiteSettingsDiagnosticsController::class)->name('settings.diagnostics');

            // Admin projects management
            Route::get('/projects', [ProjectManagementController::class, 'index'])->name('projects.index');
            Route::get('/projects/create', [ProjectManagementController::class, 'create'])->name('projects.create');
            Route::post('/projects', [ProjectManagementController::class, 'store'])->name('projects.store');
            Route::get('/projects/{project}/edit', [ProjectManagementController::class, 'edit'])->name('projects.edit');
            Route::put('/projects/{project}', [ProjectManagementController::class, 'update'])->name('projects.update');
            Route::delete('/projects/{project}', [ProjectManagementController::class, 'destroy'])->name('projects.destroy');

            Route::post('/projects/ensure-migration', [ProjectMigrationHealthController::class, 'ensure'])
                ->name('projects.ensure-migration');
        });
});

require __DIR__.'/auth.php';
