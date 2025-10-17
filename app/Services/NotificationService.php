<?php

namespace App\Services;

use App\Models\Order;
use App\Notifications\OrderNotification;  
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Send a notification for an order event.
     *
     * @param Order $order
     * @param string $eventType  // e.g., 'created' or 'updated'
     */
    public function sendOrderNotification(Order $order, string $eventType)
    {
        $user = $order->user;
        if ($user) {
            Notification::send($user, new OrderNotification($order, $eventType));
        }
    }
}