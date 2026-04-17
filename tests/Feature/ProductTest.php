<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $adminToken;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = JWTAuth::fromUser($this->user);
        $admin = User::factory()->create(['role' => 'admin']);
        $this->adminToken = JWTAuth::fromUser($admin);
        $this->category = Category::factory()->create();
    }

    public function test_can_list_products()
    {
        Product::factory()->count(3)->create(['category_id' => $this->category->id]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonCount(3)
                 ->assertJsonStructure([
                     '*' => [
                         'slug',
                         'name',
                         'description',
                         'price',
                         'image',
                         'images',
                         'category' => ['id', 'name'],
                     ],
                 ]);
    }

    public function test_can_create_product_and_generates_slug()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->adminToken])
                         ->postJson('/api/products', [
                             'category_id' => $this->category->id,
                             'name' => 'Test Product',
                             'description' => 'A wonderful test product',
                             'price' => 10.99,
                             'stock' => 50,
                             'image' => 'default.jpg'
                         ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Test Product']);
                 
        $product = Product::where('name', 'Test Product')->first();
        $this->assertNotNull($product->slug, 'Slug should be generated');
        $this->assertEquals('test-product', $product->slug);
    }

    public function test_can_show_product_by_slug()
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Specific Product',
        ]);
        
        // Setup slug manually for test isolation if Sluggable isn't hooking in correctly during mass factory creation
        if (!$product->slug) {
            $product->slug = \Illuminate\Support\Str::slug($product->name);
            $product->save();
        }

        $response = $this->getJson('/api/products/' . $product->slug);

        $response->assertStatus(200)
                 ->assertJson([
                     'slug' => $product->slug,
                     'name' => 'Specific Product',
                     'category' => [
                         'id' => $this->category->id,
                         'name' => $this->category->name,
                     ],
                 ])
                 ->assertJsonStructure([
                     'slug',
                     'name',
                     'description',
                     'price',
                     'image',
                     'images',
                     'category' => ['id', 'name'],
                 ]);
    }

    public function test_show_product_by_slug_returns_not_found_for_unknown_slug(): void
    {
        $response = $this->getJson('/api/products/slug-that-does-not-exist');

        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Resource not found.']);
    }

    public function test_product_write_routes_are_protected()
    {
        $response = $this->postJson('/api/products', [
            'category_id' => $this->category->id,
            'name' => 'Unauthorized Product',
            'description' => 'A product',
            'price' => 12.10,
            'stock' => 10,
        ]);

        $response->assertStatus(401);
    }

    public function test_create_product_returns_validation_error_for_invalid_payload(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer '.$this->adminToken])
            ->postJson('/api/products', [
                'category_id' => 999999,
                'name' => '',
                'price' => -10,
                'stock' => -1,
            ]);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Validation error.'])
            ->assertJsonValidationErrors(['category_id', 'name', 'price', 'stock']);
    }

    public function test_customer_cannot_create_product(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer '.$this->token])
            ->postJson('/api/products', [
                'category_id' => $this->category->id,
                'name' => 'Unauthorized Product',
                'description' => 'A product',
                'price' => 12.10,
                'stock' => 10,
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_product(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Original Product',
            'price' => 20.00,
            'stock' => 12,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$this->adminToken])
            ->putJson('/api/products/'.$product->id, [
                'name' => 'Updated Product',
                'price' => 35.50,
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Updated Product',
                'price' => 35.5,
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 35.50,
        ]);
    }

    public function test_admin_can_delete_product(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$this->adminToken])
            ->deleteJson('/api/products/'.$product->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_customer_cannot_update_product(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$this->token])
            ->putJson('/api/products/'.$product->id, [
                'name' => 'Unauthorized Update',
            ]);

        $response->assertStatus(403);
    }

    public function test_customer_cannot_delete_product(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$this->token])
            ->deleteJson('/api/products/'.$product->id);

        $response->assertStatus(403);
    }
}
