<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSlugTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_is_generated_from_product_name(): void
    {
        $category = Category::factory()->create();

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Bio Moisturizing Cream',
            'description' => 'Hydrating cream',
            'price' => 25.00,
            'stock' => 5,
        ]);

        $this->assertSame('bio-moisturizing-cream', $product->slug);
    }

    public function test_slug_generation_stays_unique_for_same_name(): void
    {
        $category = Category::factory()->create();

        $first = Product::create([
            'category_id' => $category->id,
            'name' => 'Vitamin C Serum',
            'description' => 'Antioxidant care',
            'price' => 35.00,
            'stock' => 5,
        ]);

        $second = Product::create([
            'category_id' => $category->id,
            'name' => 'Vitamin C Serum',
            'description' => 'Antioxidant care plus',
            'price' => 45.00,
            'stock' => 3,
        ]);

        $this->assertNotSame($first->slug, $second->slug);
    }
}
