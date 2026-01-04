<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    /**
     * Log an activity for a model
     */
    protected function logActivity(string $action, string $description, ?Model $model = null, ?array $properties = null): void
    {
        ActivityLog::log($action, $description, $model, $properties);
    }

    /**
     * Log a create action
     */
    protected function logCreated(Model $model, ?string $description = null): void
    {
        $modelName = class_basename($model);
        $description = $description ?? "Created {$modelName}";

        $this->logActivity('created', $description, $model);
    }

    /**
     * Log an update action
     */
    protected function logUpdated(Model $model, ?string $description = null, ?array $changes = null): void
    {
        $modelName = class_basename($model);
        $description = $description ?? "Updated {$modelName}";

        $this->logActivity('updated', $description, $model, $changes);
    }

    /**
     * Log a delete action
     */
    protected function logDeleted(Model $model, ?string $description = null): void
    {
        $modelName = class_basename($model);
        $description = $description ?? "Deleted {$modelName}";

        $this->logActivity('deleted', $description, $model);
    }
}
