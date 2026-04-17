<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class StatisticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_sales_popular_products_and_category_distribution(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $adminToken = JWTAuth::fromUser($admin);
        $customer = User::factory()->create(['role' => 'customer']);

        $hydration = Category::factory()->create(['name' => 'Hydration']);
        $cleanser = Category::factory()->create(['name' => 'Cleanser']);

        $cream = Product::factory()->create([
            'category_id' => $hydration->id,
            'name' => 'Bio Moisturizing Cream',
            'slug' => 'bio-moisturizing-cream',
            'price' => 25.00,
        ]);
        $serum = Product::factory()->create([
            'category_id' => $hydration->id,
            'name' => 'Vitamin C Serum',
            'slug' => 'vitamin-c-serum',
            'price' => 40.00,
        ]);
        $foam = Product::factory()->create([
            'category_id' => $cleanser->id,
            'name' => 'Gentle Foam Cleanser',
            'slug' => 'gentle-foam-cleanser',
            'price' => 15.00,
        ]);

        $deliveredOrder = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'delivered',
        ]);
        OrderItem::create([
            'orders_id' => $deliveredOrder->id,
            'products_id' => $cream->id,
            'quantity' => 2,
            'unit_price' => 25.00,
        ]);
        OrderItem::create([
            'orders_id' => $deliveredOrder->id,
            'products_id' => $serum->id,
            'quantity' => 1,
            'unit_price' => 40.00,
        ]);

        $preparedOrder = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'being_prepared',
        ]);
        OrderItem::create([
            'orders_id' => $preparedOrder->id,
            'products_id' => $cream->id,
            'quantity' => 1,
            'unit_price' => 25.00,
        ]);
        OrderItem::create([
            'orders_id' => $preparedOrder->id,
            'products_id' => $foam->id,
            'quantity' => 3,
            'unit_price' => 15.00,
        ]);

        $cancelledOrder = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'cancelled',
        ]);
        OrderItem::create([
            'orders_id' => $cancelledOrder->id,
            'products_id' => $serum->id,
            'quantity' => 10,
            'unit_price' => 40.00,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$adminToken])
            ->getJson('/api/statistics');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total_sales',
                'popular_products',
                'category_distribution',
            ])
            ->assertJsonPath('total_sales', 160)
            ->assertJsonPath('popular_products.0.name', 'Bio Moisturizing Cream')
            ->assertJsonPath('popular_products.0.total_quantity', 3)
            ->assertJsonPath('popular_products.1.name', 'Gentle Foam Cleanser')
            ->assertJsonPath('popular_products.1.total_quantity', 3)
            ->assertJsonPath('category_distribution.0.category_name', 'Hydration')
            ->assertJsonPath('category_distribution.0.total_sold', 4)
            ->assertJsonPath('category_distribution.1.category_name', 'Cleanser')
            ->assertJsonPath('category_distribution.1.total_sold', 3);
    }

    public function test_non_admin_cannot_view_statistics(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $employeeToken = JWTAuth::fromUser($employee);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$employeeToken])
            ->getJson('/api/statistics');

        $response->assertStatus(403)
            ->assertJsonFragment([
                'message' => 'Unauthorized. Only administrators can view statistics.',
            ]);
    }
}
