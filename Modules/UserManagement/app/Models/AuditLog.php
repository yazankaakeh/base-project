<?php

namespace Modules\UserManagement\app\Models;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        'admin_id',
        'url',
        'method',
        'payload',
        'ip',
        'route_name',
        'crated_at',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public static function IndexFilter($logins, $request)
    {
        if (isset($request['adminId']) && $request['adminId'] != 'all') {
            $logins->where('admin_id', $request['adminId']);
        }

        if (isset($request['route_name']) && $request['route_name'] != 'all') {
            $logins->where('route_name', $request['route_name']);
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
        if (!is_null($request['user_id'])) {
            $logins->where('payload', 'like', '%"user_id":"'.$request['user_id'].'"%');
        }

        if (!is_null($request['user_id'])) {
            $logins->where('user_id', $request['user_id']);
        }

        if (!is_null($request['created_at'])) {
            $logins->whereDate('created_at', '>=', $request['created_at']);
        }

        return $logins;
    }

    public static function GetAdmins(): Collection|array
    {
        return Admin::query()->select('name', 'id')->get();
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
