<?php

namespace App\DAO;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductDAO
{
    public function getAllWithCategory(): Collection
    {
        return Product::with('category')->get();
    }

    public function findBySlugWithCategory(string $slug): Product
    {
        return Product::with('category')->where('slug', $slug)->firstOrFail();
    }

    public function create(array $payload): Product
    {
        return Product::create($payload);
    }

    public function update(Product $product, array $payload): Product
    {
        $product->update($payload);

        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
