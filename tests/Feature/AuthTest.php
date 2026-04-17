<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'admin'
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['user', 'token']);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com', 'role' => 'customer']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'user', 'permissions']);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    public function test_user_can_get_profile()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/profile');

        $response->assertStatus(200)
                 ->assertJsonFragment(['email' => $user->email]);
    }

    public function test_employee_login_returns_order_management_permissions(): void
    {
        $employee = User::factory()->create([
            'role' => 'employee',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $employee->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('user.role', 'employee')
            ->assertJsonFragment(['orders.read.all'])
            ->assertJsonFragment(['orders.update.status']);
    }

    public function test_employee_can_manage_order_status_after_login(): void
    {
        $employee = User::factory()->create([
            'role' => 'employee',
            'password' => bcrypt('password'),
        ]);
        $customer = User::factory()->create(['role' => 'customer']);
        $order = Order::factory()->create([
            'users_id' => $customer->id,
            'status' => 'pending',
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => $employee->email,
            'password' => 'password',
        ]);
        $employeeToken = $loginResponse->json('token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$employeeToken,
        ])->putJson('/api/orders/'.$order->id.'/status', [
            'status' => 'being_prepared',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'being_prepared']);
    }

    public function test_customer_cannot_manage_order_status_after_login(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'password' => bcrypt('password'),
        ]);
        $anotherCustomer = User::factory()->create(['role' => 'customer']);
        $order = Order::factory()->create([
            'users_id' => $anotherCustomer->id,
            'status' => 'pending',
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => $customer->email,
            'password' => 'password',
        ]);
        $customerToken = $loginResponse->json('token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$customerToken,
        ])->putJson('/api/orders/'.$order->id.'/status', [
            'status' => 'being_prepared',
        ]);

        $response->assertStatus(403)
            ->assertJsonFragment(['message' => 'Unauthorized']);
    }
}
