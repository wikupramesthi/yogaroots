<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LoginAnehNotification extends Notification
{
    use Queueable;

    /**
     * @param  array<int, string>  $alasan
     */
    public function __construct(
        public string $namaUser,
        public string $emailUser,
        public string $ipAddress,
        public array $alasan,
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
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'judul_kegiatan' => 'Unusual login detected',
            'message' => $this->namaUser . ' (' . $this->emailUser . ') signed in from ' . $this->ipAddress
                . ' — ' . implode(', ', $this->alasan),
            'path' => route('security.login-activity.index', [], false),
            'icon' => 'bi-shield-exclamation',
        ];
    }
}
