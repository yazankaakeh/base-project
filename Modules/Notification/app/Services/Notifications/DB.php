<?php

namespace Modules\Notification\App\Services\Notifications;

use Modules\Notification\Models\Notification;

class DB
{
    public function sendDBNotification(array $data, $model): void
    {
        Notification::query()->create([
            'type' => $data['type'],
            'data' => $data['data'] ?? [],
            'notifiable_type' => get_class($model),
            'notifiable_id' => $model->id,
            'action_key' => $data['action_key'],
            'action_value' => $data['action_value'],
        ]);
    }
}
