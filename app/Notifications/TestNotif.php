<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class TestNotif extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [WebPushChannel::class]; // Gunakan saluran WebPush
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Halo dari Tasker! 🚀')
            ->icon('/icons/logo-192.png')
            ->body('Yay! Push Notification kamu sudah berhasil berjalan sempurna.')
            ->action('Buka App', 'explore');
    }
}