<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Notification\App\Channels\SendPushNotificationChannel;
use Modules\Notification\App\Channels\SendWhatsAppChannel;
use Modules\Notification\Enums\NotificationTypes;
use Modules\Notification\Enums\WhatsAppTemplateIDS;

class TestAllNotification extends BaseUserNotification
{
    use Queueable;

    public NotificationTypes $notificationType;

    public function __construct(public $recipient, public array $action)
    {
        $this->notificationType = NotificationTypes::TEST;
        parent::__construct();
    }

    public function via(mixed $notifiable): array
    {
        return [SendPushNotificationChannel::class, SendWhatsAppChannel::class];
    }

    public function toDB(): array
    {
        return [
            'type' => NotificationTypes::class,
            'data' => ['test' => 'test'],
            'action_key' => $this->action['key'],
            'action_value' => $this->action['value'],
            'model_type' => get_class($this->recipient),
        ];
    }

    public function toFireBase(): array
    {
        return [
            'data' => [
                'title' => "getTranslation($this->notificationType->value, 'title', [])",
                'body' => "getTranslation($this->notificationType->value, 'desc', [])",
            ],
            'vibrate' => 1,
            'sound' => 1,
            'click_action' => [$this->action['key'] => $this->action['value']],
        ];
    }

    public function toWhatsApp(): array
    {
        $templateId = WhatsAppTemplateIDS::TEST->value;

        return [
            'phone' => $this->recipient,
            'templateId' => $templateId,
            'params' => [
                'asdf',
                'asdf',
            ],
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
            ->view('notification::emails.auth.sendVerificationCodeEmail', [
                'code' => 'asd',
                'name' => 'asd',
            ]);
    }
}
