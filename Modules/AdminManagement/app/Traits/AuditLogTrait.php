<?php

namespace Modules\AdminManagement\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\AdminManagement\Models\AuditLog;

trait AuditLogTrait
{
    /**
     * Get all audit logs for this model
     */
    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    /**
     * Create an audit log entry for this model
     */
    public function createAuditLog(array $data): AuditLog
    {
        return $this->auditLogs()->create($data);
    }

    /**
     * Get the latest audit log for this model
     */
    public function latestAuditLog(): ?AuditLog
    {
        return $this->auditLogs()->latest()->first();
    }

    /**
     * Get audit logs for a specific route
     */
    public function auditLogsForRoute(string $routeName): MorphMany
    {
        return $this->auditLogs()->where('route_name', $routeName);
    }

    /**
     * Get audit logs for a specific method
     */
    public function auditLogsForMethod(string $method): MorphMany
    {
        return $this->auditLogs()->where('method', $method);
    }

    /**
     * Get audit logs within a date range
     */
    public function auditLogsBetween(string $startDate, string $endDate): MorphMany
    {
        return $this->auditLogs()->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get audit logs count for this model
     */
    public function getAuditLogsCountAttribute(): int
    {
        return $this->auditLogs()->count();
    }

    /**
     * Check if this model has any audit logs
     */
    public function hasAuditLogs(): bool
    {
        return $this->auditLogs()->exists();
    }

    /**
     * Get audit logs with pagination
     */
    public function paginatedAuditLogs(int $perPage = 15)
    {
        return $this->auditLogs()->latest()->paginate($perPage);
    }

    /**
     * Get audit logs grouped by route name
     */
    public function auditLogsByRoute()
    {
        return $this->auditLogs()
            ->selectRaw('route_name, COUNT(*) as count, MAX(created_at) as last_activity')
            ->groupBy('route_name')
            ->orderBy('count', 'desc')
            ->get();
    }

    /**
     * Get audit logs grouped by method
     */
    public function auditLogsByMethod()
    {
        return $this->auditLogs()
            ->selectRaw('method, COUNT(*) as count, MAX(created_at) as last_activity')
            ->groupBy('method')
            ->orderBy('count', 'desc')
            ->get();
    }
}
