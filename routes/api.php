<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AnalyticsController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/active', [OrderController::class, 'getActiveOrders']);
    Route::get('/analytics/popular-dishes/{restaurant_id}', [AnalyticsController::class, 'popularDishes']);  
    Route::get('/analytics/delivery-times', [AnalyticsController::class, 'averageDeliveryTimes']);  
    });
    
