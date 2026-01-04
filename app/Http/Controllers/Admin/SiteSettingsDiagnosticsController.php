<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SiteSettingsDiagnosticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $dbName = null;
        try {
            $dbName = DB::connection()->getDatabaseName();
        } catch (\Throwable $e) {
            $dbName = null;
        }

        $migration = DB::table('migrations')
            ->where('migration', '2026_01_03_000002_create_site_settings_table')
            ->first();

        $writeTest = [
            'attempted' => false,
            'inserted' => false,
            'error' => null,
        ];

        // Optional write test: only runs if table exists and is currently empty.
        if (Schema::hasTable('site_settings') && SiteSetting::count() === 0) {
            $writeTest['attempted'] = true;
            try {
                SiteSetting::create([
                    'key' => 'diagnostic_test_key',
                    'value' => '1',
                    'type' => 'string',
                    'group' => 'general',
                    'label' => 'Diagnostic Test',
                    'description' => 'Created by diagnostics endpoint',
                ]);
                $writeTest['inserted'] = true;
            } catch (\Throwable $e) {
                $writeTest['inserted'] = false;
                $writeTest['error'] = $e->getMessage();
            }
        }

        return response()->json([
            'connection' => config('database.default'),
            'database' => $dbName,
            'has_site_settings_table' => Schema::hasTable('site_settings'),
            'site_settings_count' => SiteSetting::count(),
            'migrations_row_for_site_settings' => $migration,
            'write_test' => $writeTest,
            'site_settings_sample' => SiteSetting::query()->orderBy('group')->orderBy('id')->limit(5)->get(),
        ]);
    }
}
