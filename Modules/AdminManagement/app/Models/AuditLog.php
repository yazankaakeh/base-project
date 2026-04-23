<?php

namespace Modules\AdminManagement\Models;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\AdminManagement\Models\Admin;

class AuditLog extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'url',
        'method',
        'payload',
        'ip',
        'route_name',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public static function IndexFilter($logins, $request)
    {
        if (isset($request['auditable_type']) && $request['auditable_type'] != 'all') {
            $logins->where('auditable_type', $request['auditable_type']);
        }

        if (isset($request['auditable_id']) && $request['auditable_id'] != 'all') {
            $logins->where('auditable_id', $request['auditable_id']);
        }

        if (isset($request['route_name']) && $request['route_name'] != 'all') {
            $logins->where('route_name', $request['route_name']);
        }

        if (isset($request['method']) && $request['method'] != 'all') {
            $logins->where('method', $request['method']);
        }

        if ((isset($request['start_date']) && $request['start_date'] != 'undefined') && (isset($request['end_date']) && $request['end_date'] != 'undefined')) {
            $request['start_date'] = str_replace('/', '-', $request['start_date']);
            $request['end_date'] = str_replace('/', '-', $request['end_date']);

            $request['start_date'] = DateTime::createFromFormat('m-d-Y', $request['start_date']);
            $request['start_date'] = $request['start_date']->format('Y-m-d');

            $request['end_date'] = DateTime::createFromFormat('m-d-Y', $request['end_date']);
            $request['end_date'] = $request['end_date']->format('Y-m-d');

            $logins->whereBetween('created_at', [$request['start_date'], $request['end_date']]);
        }

        return $logins;
    }

    public static function filter($logins, $request)
    {
        if (!is_null($request['auditable_type'] ?? null)) {
            $logins->where('auditable_type', $request['auditable_type']);
        }

        if (!is_null($request['auditable_id'] ?? null)) {
            $logins->where('auditable_id', $request['auditable_id']);
        }

        if (!is_null($request['created_at'] ?? null)) {
            $logins->whereDate('created_at', '>=', $request['created_at']);
        }

        return $logins;
    }

    public static function GetAuditableTypes(): array
    {
        return [
            Admin::class => 'Admin',
        ];
    }

    public static function GetAuditableModels(): Collection|array
    {
        return Admin::query()->select('name', 'id')->get();
    }

    /**
     * Get the auditable model (polymorphic relationship).
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Admin that triggered this audit entry (when auditable_type is the Admin model).
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'auditable_id')->where('auditable_type', Admin::class);
    }
}
