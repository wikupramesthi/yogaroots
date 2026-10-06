<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $className,
        public string $scheduleLabel,
        public string $dateLabel,
        public string $window = '24h',
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
        $when = $this->window === '2h'
            ? 'starts in about 2 hours'
            : 'is tomorrow';

        return [
            'judul_kegiatan' => 'Class reminder',
            'message' => $this->className . ' (' . $this->scheduleLabel . ', ' . $this->dateLabel . ') ' . $when . '. See you on the mat!',
            'path' => route('bookings.my', [], false),
            'icon' => 'bi-alarm',
        ];
    }
}
