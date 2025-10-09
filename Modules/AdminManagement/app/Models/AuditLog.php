<?php

namespace Modules\AdminManagement\App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Doctor\Models\Doctor;

class AuditLog extends Model
{

    public $timestamps = true;
    protected $fillable = [
        'doctor_id',
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
        if (isset($request['doctor_id']) && $request['doctor_id'] != 'all') {
            $logins->where('doctor_id', $request['doctor_id']);
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
        if (!is_null($request['doctor_id'])) {
            $logins->where('payload', 'like', '%"doctor_id":"'.$request['doctor_id'].'"%');
        }

        if (!is_null($request['doctor_id'])) {
            $logins->where('doctor_id', $request['doctor_id']);
        }

        if (!is_null($request['created_at'])) {
            $logins->whereDate('created_at', '>=', $request['created_at']);
        }

        return $logins;
    }

    public static function GetDoctors(): Collection|array
    {
        return Doctor::query()->select('name', 'id')->get();
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
