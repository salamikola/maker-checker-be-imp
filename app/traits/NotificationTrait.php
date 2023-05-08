<?php

namespace App\traits;

use Illuminate\Notifications\Notification;

trait NotificationTrait
{

    /**
     * @param Notification $notification
     * @param $notifiables
     * @return void
     */
    public function bulkNotification(Notification $notification, $notifiables): void
    {
        foreach ($notifiables as $notifiable) {
            \Illuminate\Support\Facades\Notification::route('mail', $notifiable->email)
                ->notify(($notification));
        }
    }
}
