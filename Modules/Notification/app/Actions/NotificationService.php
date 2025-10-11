<?php

namespace Modules\Notification\App\Actions;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\AdminManagement\app\Models\Admin;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Models\Patient;

class NotificationService
{
    public static function index(User|Patient|Doctor|Admin $user)
    {
        return $user
            ->notifications()
            ->select('*', DB::raw("DATE_FORMAT(created_at, '%d %M %Y') AS date"))
            ->where(function ($query) {
                $query
                    ->where('created_at', '>', now()->subDays(30))
                    ->orWhere('read', '=', '0');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('date')
            ->map(function ($notifications, $date) {
                return [
                    'date' => $date === Carbon::now()->format('d F Y') ? __(
                        'rest-api::app.notifications.today',
                    ) : $date,
                    'data' => NotificationResource::collection($notifications),
                ];
            })
            ->values();
    }

    public static function update(Patient|User|Admin|Doctor $user, int $id): void
    {
        $notification = $user->notifications()->where('id', $id)->firstOrFail();
        $notification->update(['read' => true]);
    }
}
