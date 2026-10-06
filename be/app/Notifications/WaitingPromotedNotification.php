<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WaitingPromotedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $className,
        public string $scheduleLabel,
        public string $dateLabel,
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
            'judul_kegiatan' => 'Seat available — you are booked in',
            'message' => 'A seat opened up: you moved from the waiting list to confirmed for '
                . $this->className . ' (' . $this->scheduleLabel . ', ' . $this->dateLabel . ').',
            'path' => route('bookings.my', [], false),
            'icon' => 'bi-calendar-check',
        ];
    }
}
