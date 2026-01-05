<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SiteSetting;
use Database\Seeders\SiteSettingsSeeder;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::orderBy('group')->orderBy('id')->get()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::all();

        foreach ($settings as $setting) {
            $key = $setting->key;
            $value = $request->input($key);

            // Handle boolean checkboxes
            if ($setting->type === 'boolean') {
                $value = $request->has($key) ? '1' : '0';
            }

            if ($setting->value !== $value) {
                $old = $setting->value;
                $setting->update(['value' => $value]);

                ActivityLog::log('updated', "Updated setting: {$setting->label}", $setting, [
                    'old' => $old,
                    'new' => $value,
                ]);
            }
        }

        SiteSetting::clearCache();

        return redirect()->route('admin.settings.index')
            ->with('success', __('messages.Settings updated successfully.'));
    }
}
