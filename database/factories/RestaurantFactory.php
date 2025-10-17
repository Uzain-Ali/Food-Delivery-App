<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Restaurant::class;

    public function definition(): array
    {
        return [
            // Generate a fake restaurant name
            'name' => $this->faker->company() . ' Grill',
            
            // Generate a fake city name for location
            'location' => $this->faker->city(),
            
            // Generate a random rating between 3.0 and 5.0, rounded to 1 decimal place
            'rating' => $this->faker->randomFloat(1, 3, 5),
        ];
    }
}
