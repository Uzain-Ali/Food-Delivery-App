<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = (new OrderService())->createOrder($request->all());
        event(new OrderCreated($order));
        return response()->json(['message' => 'Order created', 'order' => $order], 201);
    }

    public function updateStatus($id, Request $request)
    {
        $order = Order::findOrFail($id);
        $order->update($request->only('status'));
        event(new OrderUpdated($order));
        return response()->json(['message' => 'Order updated', 'order' => $order]);
    }

    public function getActiveOrders()
    {
        $orders = Order::where('status', '!=', 'completed')
                       ->where('order_time', '<', now()->subMinutes(30))
                       ->with('restaurant')
                       ->get();
        return response()->json($orders);
    }
}