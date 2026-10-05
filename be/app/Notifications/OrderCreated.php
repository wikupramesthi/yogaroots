<?php

namespace App\Notifications;

use App\Models\Payment\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderCreated extends Notification
{
    use Queueable;

    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_uuid' => $this->order->uuid,
            'order_number' => $this->order->order_number,
            'type' => $this->order->type,
            'amount' => $this->order->amount,
            'status' => $this->order->status,

            'title' => 'Pesanan Baru',
            'message' => "Pesanan #{$this->order->order_number} berhasil dibuat dan menunggu pembayaran.",
        ];
    }
}