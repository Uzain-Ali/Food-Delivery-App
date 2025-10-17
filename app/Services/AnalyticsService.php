<?php

namespace App\Services;

use App\Models\Dish;
use App\Models\Delivery;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get the top 5 popular dishes for a restaurant.
     *
     * @param int $restaurantId
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getTopDishes(int $restaurantId, int $limit = 5)
    {
        return Dish::where('restaurant_id', $restaurantId)
            ->orderBy('popularity_score', 'desc')
            ->take($limit)
            ->get(['id', 'name', 'popularity_score']);
    }

    /**
     * Compute average delivery times (daily and weekly).
     *
     * @return array
     */
    public function getAverageDeliveryTimes()
    {
        $dailyAverage = Delivery::whereDate('delivery_time', Carbon::today())
            ->avg('estimated_duration');  // Returns a float or null

        $weeklyAverage = Delivery::whereBetween('delivery_time', [Carbon::now()->subDays(7), Carbon::now()])
            ->avg('estimated_duration');

        return [
            'daily_average' => $dailyAverage !== null ? (float) round($dailyAverage, 2) : 0.0,  // Explicitly cast to float
            'weekly_average' => $weeklyAverage !== null ? (float) round($weeklyAverage, 2) : 0.0,
        ];
    }

    /**
     * Determine peak ordering hours based on historical data.
     *
     * @return array  // e.g., hours with the most orders
     */
    public function getPeakOrderingHours()
    {
        $peakHours = DB::table('orders')
            ->select(DB::raw('HOUR(order_time) as hour'), DB::raw('COUNT(*) as order_count'))
            ->groupBy('hour')
            ->orderBy('order_count', 'desc')
            ->take(5)  // Top 5 peak hours
            ->get();

        return $peakHours;
    }
}