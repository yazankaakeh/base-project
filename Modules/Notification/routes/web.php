<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\FirebaseNotificationController;
use Modules\Notification\Http\Controllers\NotificationController;
use Modules\Notification\Http\Controllers\WhatsAppCallBackController;

Route::group(['middleware' => ['admin'], 'prefix' => config('app.admin_url')], function () {
    Route::get('/notification/config', [NotificationController::class, 'index'])->name('admin.notification.configs');
    Route::post('/notification/update', [NotificationController::class, 'update'])->name('admin.notification.update');
    Route::post('/notification/sendTestEmail', [NotificationController::class, 'sendTestEmail'])->name(
        'admin.notification.sendTestEmail',
    );
});
/*Route::get('asd/{id}', function ($id) {
    $data = [
        'key' => NotificationsActionKeys::CATEGORY->value,
        'value' => 123,
    ];
    app()->setLocale('en');

    $customer = Customer::query()->find($id);
    $customer->notify(new TestAllNotification(905522998130, $data, ['test']));

    dd($customer->notifications);
});*/
Route::post('/notification/firebase/token', [FirebaseNotificationController::class, 'push_notification'])->name(
    'push_notification',
);

Route::post('/whatsapp/callback', [WhatsAppCallBackController::class, 'checkMessage']);
