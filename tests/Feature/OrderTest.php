<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_place_order_with_product_slug(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $token = JWTAuth::fromUser($customer);
        $category = Category::factory()->create();
        $firstProduct = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Bio Moisturizing Cream',
            'slug' => 'bio-moisturizing-cream',
            'stock' => 15,
            'price' => 25.00,
        ]);
        $secondProduct = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Vitamin C Serum',
            'slug' => 'vitamin-c-serum',
            'stock' => 10,
            'price' => 40.00,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson('/api/orders', [
                'products' => [
                    ['slug' => $firstProduct->slug, 'quantity' => 2],
                    ['slug' => $secondProduct->slug, 'quantity' => 1],
                ],
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Order placed successfully'])
            ->assertJsonFragment(['total_amount' => 90]);

        $this->assertDatabaseHas('orders', [
            'users_id' => $customer->id,
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('orders_items', [
            'products_id' => $firstProduct->id,
            'quantity' => 2,
        ]);
        $this->assertDatabaseHas('orders_items', [
            'products_id' => $secondProduct->id,
            'quantity' => 1,
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $firstProduct->id,
            'stock' => 13,
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $secondProduct->id,
            'stock' => 9,
        ]);
    }

    public function test_customer_cannot_place_order_with_duplicate_product_slug(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $token = JWTAuth::fromUser($customer);
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'slug' => 'bio-moisturizing-cream',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson('/api/orders', [
                'products' => [
                    ['slug' => $product->slug, 'quantity' => 1],
                    ['slug' => $product->slug, 'quantity' => 2],
                ],
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['products.1.slug']);
    }

    public function test_customer_can_cancel_pending_order(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $token = JWTAuth::fromUser($customer);
        $order = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'pending',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson('/api/orders/'.$order->id.'/cancel');

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Order successfully canceled']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_customer_cannot_cancel_order_once_being_prepared(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $token = JWTAuth::fromUser($customer);
        $order = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'being_prepared',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson('/api/orders/'.$order->id.'/cancel');

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Order can only be cancelled while it is pending.']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'being_prepared',
        ]);
    }

    public function test_customer_cannot_cancel_delivered_order(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $token = JWTAuth::fromUser($customer);
        $order = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'delivered',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson('/api/orders/'.$order->id.'/cancel');

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Order can only be cancelled while it is pending.']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'delivered',
        ]);
    }

    public function test_employee_can_update_order_status(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $token = JWTAuth::fromUser($employee);
        $customer = User::factory()->create(['role' => 'customer']);
        $order = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'pending',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->putJson('/api/orders/'.$order->id.'/status', [
                'status' => 'being_prepared',
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'being_prepared']);
    }

    public function test_employee_can_mark_prepared_order_as_delivered(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $token = JWTAuth::fromUser($employee);
        $customer = User::factory()->create(['role' => 'customer']);
        $order = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'being_prepared',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->putJson('/api/orders/'.$order->id.'/status', [
                'status' => 'delivered',
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'delivered']);
    }

    public function test_employee_cannot_mark_pending_order_as_delivered_directly(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $token = JWTAuth::fromUser($employee);
        $customer = User::factory()->create(['role' => 'customer']);
        $order = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'pending',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->putJson('/api/orders/'.$order->id.'/status', [
                'status' => 'delivered',
            ]);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Order must be marked as being prepared before delivery.']);
    }

    public function test_customer_can_check_their_order_status_by_id(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $token = JWTAuth::fromUser($customer);
        $order = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'delivered',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->getJson('/api/orders/'.$order->id);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $order->id,
                'status' => 'delivered',
            ]);
    }

    public function test_customer_can_list_only_their_order_statuses(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $token = JWTAuth::fromUser($customer);
        $anotherCustomer = User::factory()->create(['role' => 'customer']);

        $pendingOrder = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'pending',
        ]);
        $preparedOrder = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'being_prepared',
        ]);
        Order::factory()->create([
            'users_id' => $anotherCustomer->id,
            'status' => 'delivered',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'id' => $pendingOrder->id,
                'status' => 'pending',
            ])
            ->assertJsonFragment([
                'id' => $preparedOrder->id,
                'status' => 'being_prepared',
            ])
            ->assertJsonMissing([
                'status' => 'delivered',
            ]);
    }
}
