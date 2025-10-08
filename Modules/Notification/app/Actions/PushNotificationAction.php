<?php

namespace Modules\Notification\App\Actions;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\AdminManagement\app\Models\Admin;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Models\Patient;
use Modules\Notification\Models\NotificationPushToken;

class PushNotificationAction
{
    public static function action(User|Doctor|Patient|Admin $user, array $data): Model|bool|Builder
    {
        try {
            return NotificationPushToken::query()->updateOrCreate([
                'push_token' => $data['push_token'],
                'tokenable_id' => $user->id,
                'tokenable_type' => get_class($user),
            ], $data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
