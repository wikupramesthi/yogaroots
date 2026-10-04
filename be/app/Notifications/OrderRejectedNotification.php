<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $orderUuid,
        public string $orderNumber,
        public ?string $reason,
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
        $message = 'Payment for ' . $this->orderNumber . ' was rejected by admin.';

        if ($this->reason) {
            $message .= ' Reason: ' . $this->reason;
        }

        $message .= ' Please contact admin or place a new order.';

        return [
            'judul_kegiatan' => 'Order rejected',
            'message' => $message,
            'path' => route('orders.show', $this->orderUuid, false),
            'icon' => 'bi-x-circle',
        ];
    }
}
