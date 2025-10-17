<?php

namespace App\Listeners;

use Predis\Client;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderEventListener
{
    public function handle($event)
    {
        $stream = 'orders-stream';
        $redis = new Client();
        $redis->xadd($stream, ['order_id' => $event->order->id, 'status' => $event->order->status]);
    }
}
