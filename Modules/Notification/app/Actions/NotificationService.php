<?php

namespace Modules\Notification\App\Actions;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Modules\AdminManagement\Models\Admin;

class NotificationService
{
    /**
     * List the most recent notifications for any notifiable user (admin or public).
     */
    public static function index(User|Admin|Model $user)
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

    public static function update(User|Admin|Model $user, int $id): void
    {
        $notification = $user->notifications()->where('id', $id)->firstOrFail();
        $notification->update(['read' => true]);
    }
}
