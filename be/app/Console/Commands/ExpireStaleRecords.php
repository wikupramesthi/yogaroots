<?php

namespace App\Console\Commands;

use App\Models\Payment\Order;
use App\Models\UserPackage;
use App\Notifications\OrderExpiredNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireStaleRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'records:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire pending orders and memberships past their expiry time';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $staleOrders = Order::with('user')
            ->where('status', 'pending')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->limit(500)
            ->get();

        $expiredOrders = 0;

        if ($staleOrders->isNotEmpty()) {
            $expiredOrders = Order::whereIn('uuid', $staleOrders->pluck('uuid'))
                ->where('status', 'pending')
                ->update(['status' => 'expired']);

            foreach ($staleOrders as $order) {
                try {
                    $order->user?->notify(new OrderExpiredNotification($order->order_number));
                } catch (\Throwable $e) {
                    Log::warning('Order expiry notification failed for ' . $order->order_number . ': ' . $e->getMessage());
                }
            }
        }

        $expiredPackages = UserPackage::where('status', 'active')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->update(['status' => 'expired']);

        $message = "Expired {$expiredOrders} orders and {$expiredPackages} memberships.";

        $this->info($message);
        Log::info('records:expire: ' . $message);

        return self::SUCCESS;
    }
}
