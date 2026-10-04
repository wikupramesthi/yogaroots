<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProofUploadedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $orderUuid,
        public string $orderNumber,
        public string $customerName,
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
            'judul_kegiatan' => 'Transfer proof uploaded',
            'message' => $this->orderNumber . ' — ' . $this->customerName
                . ' uploaded transfer proof (Rp ' . number_format($this->amount, 0, ',', '.') . '). Please verify.',
            'path' => route('orders.show', $this->orderUuid, false),
            'icon' => 'bi-file-earmark-check',
        ];
    }
}
