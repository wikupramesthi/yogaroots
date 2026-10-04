<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderBaruNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $orderUuid,
        public string $orderNumber,
        public string $customerName,
        public string $packageName,
        public float $amount,
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
            'judul_kegiatan' => 'New order received',
            'message' => $this->orderNumber . ' — ' . $this->customerName
                . ' ordered ' . $this->packageName
                . ' (Rp ' . number_format($this->amount, 0, ',', '.') . ')',
            'path' => route('orders.show', $this->orderUuid, false),
            'icon' => 'bi-receipt',
        ];
    }
}
