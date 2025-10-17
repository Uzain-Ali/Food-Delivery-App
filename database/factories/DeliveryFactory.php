<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DeliveryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Delivery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Automatically creates an Order and a User (driver) if none exist.
            'order_id' => Order::factory(),
            'driver_id' => User::factory(), 
            'estimated_duration' => $this->faker->numberBetween(15, 60), // Duration in minutes
            'delivery_time' => Carbon::now()->subMinutes($this->faker->numberBetween(1, 120)), // Some time in the past
        ];
    }

    /**
     * Indicate that the delivery occurred today.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function today()
    {
        return $this->state(function (array $attributes) {
            return [
                'delivery_time' => Carbon::now()->startOfDay()->addMinutes(rand(1, 60 * 24)),
            ];
        });
    }
}
