<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;

class OrderTest extends TestCase
{
    use RefreshDatabase; // This ensures migrations run before each test and DB is reset after

    public function test_order_can_be_created()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();
        $orderData = [
            'restaurant_id' => $restaurant->id,
            'user_id' => $user->id,
            'total_cost' => 250,
        ];
    
        $this->actingAs($user, 'sanctum'); 
    
        $response = $this->postJson('/api/orders', $orderData);

        if ($response->status() == 201) {
            dump($response->json());
        }
        $response->assertStatus(201)
                 ->assertJsonFragment(['message' => 'Order created']);
    
        $this->assertDatabaseHas('orders', [
            'restaurant_id' => $restaurant->id,
            'user_id' => $user->id,
            'total_cost' => 250,
            'status' => 'pending',
        ]);
    }   

public function test_active_orders_endpoint_returns_orders()
{
    $user = User::factory()->create();
    $restaurant = Restaurant::factory()->create();

    $oldOrder = Order::factory()->create([
        'user_id' => $user->id,
        'restaurant_id' => $restaurant->id,
        'order_time' => now()->subMinutes(31),  
        'status' => 'pending',  
    ]);
    $this->actingAs($user, 'sanctum'); 

    $response = $this->getJson('/api/orders/active');

    $response->assertStatus(200)
             ->assertJsonCount(1)  // Expect exactly one order
             ->assertJsonFragment([  // Check for the specific order data
                 'id' => $oldOrder->id,
                 'restaurant_id' => $restaurant->id,
                 'user_id' => $user->id,
                 'status' => 'pending',
             ])
             ->assertJsonStructure([  // Validate the structure of the array
                 '*' => ['id', 'restaurant_id', 'user_id', 'total_cost', 'order_time', 'status']
             ]);
}
}