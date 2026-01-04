<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class ProjectMigrationHealthController extends Controller
{
    /**
     * If projects table is missing on the active DB connection, run the projects migration.
     * Useful when deploying to a remote DB where migrations were not applied yet.
     */
    public function ensure(): RedirectResponse
    {
        if (!Schema::hasTable('projects')) {
            Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_01_03_000100_create_projects_tables.php',
                '--force' => true,
            ]);

            // Optional: seed a baseline so the page is not empty
            Artisan::call('db:seed', ['--class' => 'ProjectSeeder', '--force' => true]);
        }

        return back()->with('status', 'projects-migration-ensured');
    }
}
