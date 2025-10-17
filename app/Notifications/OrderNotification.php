<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;  // Assuming your Order model is in App\Models

class OrderNotification extends Notification
{
    use Queueable;

    /**
     * The order instance.
     *
     * @var Order
     */
    protected $order;

    /**
     * The type of event (e.g., 'created' or 'updated').
     *
     * @var string
     */
    protected $eventType;

    /**
     * Create a new notification instance.
     *
     * @param Order $order
     * @param string $eventType
     */
    public function __construct(Order $order, string $eventType)
    {
        $this->order = $order;
        $this->eventType = $eventType;  // e.g., 'created' or 'updated'
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];  // You can add more channels like 'broadcast' if needed
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Update Notification')
            ->line("Your order has been {$this->eventType}.")
            ->line("Order ID: {$this->order->id}")
            ->line("Current Status: {$this->order->status}")
            ->line("Total Cost: {$this->order->total_cost}")
            ->action('View Your Order', url("/orders/{$this->order->id}"))  // Assuming a route for viewing orders
            ->line('If you have any questions, please contact support.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'event_type' => $this->eventType,
            'status' => $this->order->status,
            'total_cost' => $this->order->total_cost,
            // Add more data as needed
        ];
    }
}