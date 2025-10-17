<?php

namespace App\Listeners;

use App\Services\NotificationService;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;

class SendNotificationListener
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle($event)
    {
        $this->notificationService->sendOrderNotification($event->order, $event instanceof OrderCreated ? 'created' : 'updated');
    }
}