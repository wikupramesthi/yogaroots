<?php

namespace App\Console\Commands;

use App\Models\Class\ClassBooking;
use App\Notifications\BookingReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemindBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send H-1 and 2-hour reminders for confirmed class bookings';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now();
        $sent24 = 0;
        $sent2 = 0;

        // H-1: booking confirmed untuk besok yang belum diingatkan.
        $tomorrow = ClassBooking::with(['user', 'schedule.class'])
            ->where('status', 'confirmed')
            ->whereDate('booking_date', $now->copy()->addDay()->toDateString())
            ->whereNull('reminded_24h_at')
            ->limit(500)
            ->get();

        foreach ($tomorrow as $booking) {
            try {
                $booking->user?->notify(new BookingReminderNotification(
                    $booking->schedule?->class?->name ?? 'Class',
                    trim(ucfirst($booking->schedule?->day ?? '') . ' ' . substr((string) $booking->schedule?->start_time, 0, 5)),
                    $booking->booking_date?->format('d M Y') ?? '-',
                    '24h',
                ));
                $booking->update(['reminded_24h_at' => $now]);
                $sent24++;
            } catch (\Throwable $e) {
                Log::warning('Booking H-1 reminder failed for ' . $booking->uuid . ': ' . $e->getMessage());
            }
        }

        // 2 jam: booking confirmed hari ini yang kelasnya mulai <= 2 jam lagi.
        $today = ClassBooking::with(['user', 'schedule.class'])
            ->where('status', 'confirmed')
            ->whereDate('booking_date', $now->toDateString())
            ->whereNull('reminded_2h_at')
            ->limit(500)
            ->get()
            ->filter(function ($booking) use ($now) {
                $start = $booking->schedule?->start_time;
                if (! $start) {
                    return false;
                }
                $classAt = $now->copy()->setTimeFromTimeString(substr((string) $start, 0, 5));
                return $classAt->greaterThan($now) && $classAt->diffInMinutes($now) <= 120;
            });

        foreach ($today as $booking) {
            try {
                $booking->user?->notify(new BookingReminderNotification(
                    $booking->schedule?->class?->name ?? 'Class',
                    trim(ucfirst($booking->schedule?->day ?? '') . ' ' . substr((string) $booking->schedule?->start_time, 0, 5)),
                    $booking->booking_date?->format('d M Y') ?? '-',
                    '2h',
                ));
                $booking->update(['reminded_2h_at' => $now]);
                $sent2++;
            } catch (\Throwable $e) {
                Log::warning('Booking 2h reminder failed for ' . $booking->uuid . ': ' . $e->getMessage());
            }
        }

        $message = "Sent {$sent24} H-1 and {$sent2} 2-hour booking reminders.";
        $this->info($message);
        Log::info('bookings:remind: ' . $message);

        return self::SUCCESS;
    }
}
