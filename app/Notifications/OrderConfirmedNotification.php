<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
    ) {
        $this->order->loadMissing(['items.product']);
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Confirmed — Ehsan Electronics #'.$this->order->id)
            ->markdown('emails.orders.confirmed', [
                'order' => $this->order,
                'customerName' => $notifiable->name,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Order Confirmed',
            'message' => 'Aapka order #'.$this->order->id.' confirm ho gaya hai. Total: '.money($this->order->total_price),
            'order_id' => $this->order->id,
            'total' => (float) $this->order->total_price,
            'type' => 'order_confirmed',
        ];
    }
}
