<?php

namespace App\Services;

use App\Models\Order;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use Illuminate\Support\Facades\Event;

class OrderService
{
    /**
     * Create a new order.
     *
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data)
    {
        // Validate data (you can use Laravel's Validator here if needed)
        $order = Order::create([
            'restaurant_id' => $data['restaurant_id'],
            'user_id' => $data['user_id'],
            'total_cost' => $data['total_cost'],
            'order_time' => now(),
            'status' => 'pending',  // Default status
        ]);

        // Trigger the OrderCreated event
        Event::dispatch(new OrderCreated($order));

        return $order;
    }

    /**
     * Update an existing order's status.
     *
     * @param int $orderId
     * @param array $data
     * @return Order
     */
    public function updateOrderStatus(int $orderId, array $data)
    {
        $order = Order::findOrFail($orderId);
        $order->update($data);  // e.g., ['status' => 'in-progress']

        // Trigger the OrderUpdated event
        Event::dispatch(new OrderUpdated($order));

        return $order;
    }
}