<?php

namespace App\Console\Commands;

use App\Models\Class\ClassBooking;
use App\Notifications\BookingMissedNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkNoshowBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:mark-noshow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark past confirmed/waiting bookings without check-in as no-show';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $stale = ClassBooking::with(['user', 'schedule.class'])
            ->whereIn('status', ['confirmed', 'waiting_list'])
            ->whereDate('booking_date', '<', now()->toDateString())
            ->limit(500)
            ->get();

        $marked = 0;

        foreach ($stale as $booking) {
            try {
                $booking->update(['status' => 'no_show']);
                $marked++;

                $booking->user?->notify(new BookingMissedNotification(
                    $booking->schedule?->class?->name ?? 'Class',
                    trim(ucfirst($booking->schedule?->day ?? '') . ' ' . substr((string) $booking->schedule?->start_time, 0, 5)),
                    $booking->booking_date?->format('d M Y') ?? '-',
                ));
            } catch (\Throwable $e) {
                Log::warning('Booking no-show marking failed for ' . $booking->uuid . ': ' . $e->getMessage());
            }
        }

        $message = "Marked {$marked} bookings as no-show.";
        $this->info($message);
        Log::info('bookings:mark-noshow: ' . $message);

        return self::SUCCESS;
    }
}
