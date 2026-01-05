<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by model type
        if ($request->filled('model')) {
            $query->where('model_type', 'like', "%{$request->model}%");
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', "%{$request->search}%");
        }

        $logs = $query->paginate(25)->withQueryString();

        // Get unique actions for filter
        $actions = ActivityLog::distinct()->pluck('action');

        return view('admin.activity-logs.index', compact('logs', 'actions'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', __('messages.Activity log entry deleted.'));
    }

    public function clear(Request $request)
    {
        $request->validate([
            'older_than' => 'required|integer|min:1',
        ]);

        $days = $request->older_than;
        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();

        ActivityLog::log('deleted', "Cleared {$deleted} activity logs older than {$days} days");

        return redirect()->route('admin.activity-logs.index')
            ->with('success', __('messages.:count activity log entries cleared.', ['count' => $deleted]));
    }
}
