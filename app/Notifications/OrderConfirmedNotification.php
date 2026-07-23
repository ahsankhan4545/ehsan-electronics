<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Queued so checkout never waits on SMTP/HTTP mailers.
 * Required on Railway: php artisan serve does not flush before afterResponse,
 * so sync mail (Gmail SMTP) blocks the redirect for 30–60s.
 */
class OrderConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public int $timeout = 30;

    public function __construct(
        public Order $order,
    ) {
        $this->afterCommit();
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
