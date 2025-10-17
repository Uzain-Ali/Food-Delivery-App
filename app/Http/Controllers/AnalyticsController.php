<?php

    namespace App\Http\Controllers;

    use App\Services\AnalyticsService;
    use Illuminate\Http\Request;

    class AnalyticsController extends Controller
    {
        protected $analyticsService;

        public function __construct(AnalyticsService $analyticsService)
        {
            $this->analyticsService = $analyticsService;
        }

        public function popularDishes($restaurantId)
        {
            $dishes = $this->analyticsService->getTopDishes($restaurantId, 5);
            return response()->json(['data' => $dishes]);
        }

        public function averageDeliveryTimes()
        {
            $data = $this->analyticsService->getAverageDeliveryTimes();
            return response()->json([
                'daily_average' => (float) $data['daily_average'],
                'weekly_average' => (float) $data['weekly_average'],
            ]);
        }
    }
    