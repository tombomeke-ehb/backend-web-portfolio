<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auto-create SQLite database file if using SQLite and file doesn't exist
        $this->createSqliteDatabaseIfNeeded();
    }

    /**
     * Create the SQLite database file if it doesn't exist.
     */
    protected function createSqliteDatabaseIfNeeded(): void
    {
        if (config('database.default') === 'sqlite') {
            $database = config('database.connections.sqlite.database');
            
            // Skip if using :memory: database
            if ($database === ':memory:') {
                return;
            }

            // Create the database file if it doesn't exist
            if ($database && !file_exists($database)) {
                $directory = dirname($database);
                
                // Create directory if needed
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }
                
                // Create empty database file
                touch($database);
            }
        }
    }
}
