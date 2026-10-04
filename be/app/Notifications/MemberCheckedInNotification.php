<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MemberCheckedInNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $className,
        public string $scheduleLabel,
        public ?int $remainingQuota,
        public bool $byAdmin = false,
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
        $message = ($this->byAdmin ? 'Admin checked you in to ' : 'You checked in to ')
            . $this->className . ' (' . $this->scheduleLabel . ').';

        if (!is_null($this->remainingQuota)) {
            $message .= ' Remaining quota: ' . $this->remainingQuota . '.';
        }

        return [
            'judul_kegiatan' => 'Checked in successfully',
            'message' => $message,
            'path' => route('class-bookings.index', [], false),
            'icon' => 'bi-check2-circle',
        ];
    }
}
