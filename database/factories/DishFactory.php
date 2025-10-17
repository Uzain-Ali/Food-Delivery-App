<?php

namespace Database\Factories;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DishFactory extends Factory
{
    protected $model = Dish::class;

    public function definition()
    {
        return [
            'restaurant_id' => 1,  
            'name' => fake()->word,  
            'category' => fake()->word,
            'price' => fake()->randomFloat(2, 1, 100),  
            'popularity_score' => fake()->numberBetween(1, 100),
            'availability_status' => fake()->boolean,
        ];
    }
}