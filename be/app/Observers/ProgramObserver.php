<?php

namespace App\Observers;

use App\Models\Program;
use App\Notifications\ProgramStatusChanged;

class ProgramObserver
{
    public function updating(Program $program)
    {
        if ($program->isDirty('status')) {
            $oldStatus = $program->getOriginal('status');

            // Kirim notifikasi ke user yang punya program
            $program->user->notify(new ProgramStatusChanged($program, $oldStatus));
        }
    }
}
