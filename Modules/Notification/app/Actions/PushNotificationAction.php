<?php

namespace Modules\Notification\App\Actions;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Models\Patient;
use Modules\Notification\Models\NotificationPushToken;
use Modules\AdminManagement\app\Models\Admin;

class PushNotificationAction
{
    public static function action(User|Doctor|Patient|Admin $user, array $data): Model|bool|Builder
    {
        try {
            return NotificationPushToken::query()->updateOrCreate(['push_token' => $data['push_token']], $data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
