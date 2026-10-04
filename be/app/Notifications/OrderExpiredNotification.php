<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderExpiredNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $orderNumber,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * Keys follow the admin header bell contract:
     * judul_kegiatan + message (+ optional path/icon).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'judul_kegiatan' => 'Order expired',
            'message' => $this->orderNumber
                . ' was automatically cancelled after 24 hours without payment. Please place a new order if you still want the membership.',
            'path' => route('packages.member', [], false),
            'icon' => 'bi-hourglass-bottom',
        ];
    }
}
