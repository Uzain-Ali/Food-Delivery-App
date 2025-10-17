<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use App\Services\AnalyticsService;  // Assuming this service exists

class UpdateAnalyticsListener
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function handle($event)
    {
        if ($event instanceof OrderCreated || $event instanceof OrderUpdated) {
            $dishes = $event->order->dishes ?? collect(); // Use empty collection if null
            foreach ($dishes as $dish) {
                $this->analyticsService->updatePopularityScore($dish);
            }

            if ($event->order->delivery) {
                $this->analyticsService->updateAverageDeliveryTimes($event->order->delivery);
            }
        }
    }
}
