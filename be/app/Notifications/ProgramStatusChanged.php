<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Program;

class ProgramStatusChanged extends Notification
{
    use Queueable;

    protected $program;
    protected $oldStatus;

    public function __construct(Program $program, $oldStatus)
    {
        $this->program = $program;
        $this->oldStatus = $oldStatus;
    }

    public function via($notifiable)
    {
        return ['database']; // hanya database
    }

    public function toDatabase($notifiable)
    {
        return [
            'program_id' => $this->program->id,
            'judul_kegiatan' => $this->program->judul_kegiatan,
            'old_status' => $this->oldStatus,
            'new_status' => $this->program->status,
            'message' => "Status program '{$this->program->judul_kegiatan}' berubah dari '{$this->oldStatus}' menjadi '{$this->program->status}'."
        ];
    }
}
