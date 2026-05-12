<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // 1. Tambahkan baris ini
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

// 2. Tambahkan "implements ShouldQueue" di sebelah tulisan Notification
class TestNotif extends Notification implements ShouldQueue 
{
    use Queueable;

    public function via($notifiable)
    {
        return [WebPushChannel::class];
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