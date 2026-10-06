<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('records:expire')->hourly();
Schedule::command('bookings:remind')->everyThirtyMinutes();
Schedule::command('bookings:mark-noshow')->hourly();
