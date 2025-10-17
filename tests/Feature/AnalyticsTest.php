<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Dish;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create user once for all authenticated tests
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_returns_top_popular_dishes_for_authenticated_user()
    {
        $restaurant = Restaurant::factory()->create();
        
        // Create dishes using the relationship
        $restaurant->dishes()->createMany(
        Dish::factory()->count(5)->make()->toArray()
        );

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/analytics/popular-dishes/{$restaurant->id}");

        $response->assertStatus(200)
        ->assertJsonCount(5, 'data') 
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'popularity_score']
            ]
    ]);
    }
   #[Test]
    public function it_returns_average_delivery_times_for_authenticated_user()
    {
        Delivery::factory()->create(['estimated_duration' => 20, 'delivery_time' => now()]);
        Delivery::factory()->create(['estimated_duration' => 30, 'delivery_time' => now()]);
        Delivery::factory()->create(['estimated_duration' => 40, 'delivery_time' => now()->subDays(3)]);
        Delivery::factory()->create(['estimated_duration' => 50, 'delivery_time' => now()->subDays(10)]);
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/analytics/delivery-times');
        $response->assertStatus(200);
        // Dump the response for debugging
        $response->dump();  // This showed {"daily_average": 25, "weekly_average": 30}
        $response->assertJson(function (AssertableJson $json) {
            $json->has('daily_average')
                 ->has('weekly_average')
                 ->where('daily_average', 25, 1.0)  // Changed to 25 to match the integer type
                 ->where('weekly_average', 30, 1.0);  // Changed to 30 to match the integer type
        });
    }
        /** @test */
    public function it_denies_access_to_analytics_without_authentication()
    {
        $response = $this->getJson('/api/analytics/popular-dishes/1');

        $response->assertStatus(401);  // Unauthorized
    }

    /** @test */
    public function it_handles_non_existent_restaurant()
    {
        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/api/analytics/popular-dishes/999');  // Non-existent ID

        $response->assertStatus(200)  // Or adjust if your controller returns 404
                 ->assertJson([]);  // Empty response
    }

    /** @test */
    public function it_returns_peak_hours_via_another_endpoint_if_needed()
    {
        // If you have a route for peak hours, add a test here
        // For now, assuming it's part of AnalyticsService, you can extend this
        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/api/analytics/peak-hours');  // Hypothetical endpoint

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['hour', 'order_count']
                 ]);
    }
}
